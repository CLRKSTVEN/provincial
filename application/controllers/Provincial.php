<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Provincial extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Winners_model');
        $this->load->model('Events_model');
        $this->load->model('Address_model');
        $this->load->model('MeetSettings_model'); // NEW
        $this->load->library(array('form_validation', 'session'));
        $this->load->helper(array('url', 'form'));
    }

    public function index()
    {
        $group = $this->input->get('group', TRUE);
        $municipality = $this->input->get('municipality', TRUE);

        if ($group === 'Elementary' || $group === 'Secondary') {
            $winners  = $this->Winners_model->get_winners_list($group, $municipality);
            $overview = $this->Winners_model->get_overview($group, $municipality);
            $active   = $group;
        } else {
            $winners  = $this->Winners_model->get_winners_list(null, $municipality);
            $overview = $this->Winners_model->get_overview(null, $municipality);
            $active   = 'ALL';
        }

        $data = array(
            'active_group' => $active,
            'active_municipality' => $municipality,
            'winners'      => $winners,
            'overview'     => $overview,
            'municipality_tally' => $this->Winners_model->get_medal_tally(),
            'meet'         => $this->MeetSettings_model->get_settings(), // NEW
        );

        $this->load->view('provincial_landing', $data);
    }

    // Optional alias
    public function standings()
    {
        $this->index();
    }

    public function admin()
    {
        if ($this->input->post('submit')) {

            $this->form_validation->set_rules('event_id', 'Event', 'required|integer|greater_than[0]');
            $rawRows = $this->input->post('winners', TRUE);
            list($winnerRows, $rowErrors) = $this->normalize_winner_rows($rawRows);

            if ($this->form_validation->run()) {
                if (!empty($rowErrors)) {
                    $this->session->set_flashdata('error', implode('<br>', $rowErrors));
                    redirect('provincial/admin');
                    return;
                }

                if (empty($winnerRows)) {
                    $this->session->set_flashdata('error', 'Please add at least one winner.');
                    redirect('provincial/admin');
                    return;
                }

                $eventId = (int) $this->input->post('event_id', TRUE);
                $event   = $this->Events_model->get_event_details($eventId);

                if (!$event) {
                    $this->session->set_flashdata('error', 'Selected event could not be found. Please pick a valid event.');
                    redirect('provincial/admin');
                    return;
                }

                foreach ($winnerRows as $row) {
                    $insert = array(
                        'event_id'    => $event->event_id,
                        'event_name'  => $event->event_name,
                        'event_group' => $event->group_name ?? 'Unspecified',
                        'category'    => $event->category_name,
                        'first_name'  => $row['first_name'],
                        'middle_name' => $row['middle_name'],
                        'last_name'   => $row['last_name'],
                        'medal'       => $row['medal'],
                        'municipality'=> $row['municipality'],
                    );

                    $this->Winners_model->insert_winner($insert);
                }

                $count = count($winnerRows);
                $message = $count > 1
                    ? $count . ' winners saved successfully.'
                    : 'Winner saved successfully.';
                $this->session->set_flashdata('success', $message);
                redirect('provincial/admin');
                return;
            }
        }

        // pass meet settings to the admin form
        $data['meet'] = $this->MeetSettings_model->get_settings();
        $data['recent_winners'] = $this->Winners_model->get_recent_winners(10);
        $data['event_categories'] = $this->Events_model->get_categories();
        $data['event_groups'] = $this->Events_model->get_groups();
        $data['events'] = $this->Events_model->get_events_with_meta();
        $data['municipalities'] = $this->Address_model->get_municipalities();

        $this->load->view('dashboard_admin', $data);
    }

    public function update_winner()
    {
        $this->form_validation->set_rules('winner_id', 'Winner ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('event_id', 'Event', 'required|integer|greater_than[0]');
        $rawRows = $this->input->post('winners', TRUE);

        // Backward compatibility if the request comes from the old single-entry form
        if (!is_array($rawRows)) {
            $rawRows = array(array(
                'first_name'   => $this->input->post('first_name', TRUE),
                'middle_name'  => $this->input->post('middle_name', TRUE),
                'last_name'    => $this->input->post('last_name', TRUE),
                'medal'        => $this->input->post('medal', TRUE),
                'municipality' => $this->input->post('municipality', TRUE),
            ));
        }

        list($winnerRows, $rowErrors) = $this->normalize_winner_rows($rawRows);

        if ($this->form_validation->run()) {
            if (!empty($rowErrors)) {
                $this->session->set_flashdata('error', implode('<br>', $rowErrors));
                redirect('provincial/admin');
                return;
            }

            if (empty($winnerRows)) {
                $this->session->set_flashdata('error', 'Please enter the winner details to update.');
                redirect('provincial/admin');
                return;
            }

            if (count($winnerRows) > 1) {
                $this->session->set_flashdata('error', 'Please edit one winner at a time.');
                redirect('provincial/admin');
                return;
            }

            $winnerId = (int) $this->input->post('winner_id', TRUE);
            $eventId  = (int) $this->input->post('event_id', TRUE);

            $winner = $this->Winners_model->get_winner($winnerId);
            if (!$winner) {
                $this->session->set_flashdata('error', 'Winner not found.');
                redirect('provincial/admin');
                return;
            }

            $event = $this->Events_model->get_event_details($eventId);
            if (!$event) {
                $this->session->set_flashdata('error', 'Selected event could not be found. Please pick a valid event.');
                redirect('provincial/admin');
                return;
            }

            $payload = $winnerRows[0];
            $update = array(
                'event_id'    => $event->event_id,
                'event_name'  => $event->event_name,
                'event_group' => $event->group_name ?? 'Unspecified',
                'category'    => $event->category_name,
                'first_name'   => $payload['first_name'],
                'middle_name'  => $payload['middle_name'],
                'last_name'    => $payload['last_name'],
                'medal'        => $payload['medal'],
                'municipality' => $payload['municipality'],
            );

            $this->Winners_model->update_winner($winnerId, $update);
            $this->session->set_flashdata('success', 'Winner updated successfully.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/admin');
    }

    public function delete_winner($winner_id = null)
    {
        $id = (int) $winner_id;
        if ($id <= 0) {
            $this->session->set_flashdata('error', 'Invalid winner.');
            redirect('provincial/admin');
            return;
        }

        $existing = $this->Winners_model->get_winner($id);
        if (!$existing) {
            $this->session->set_flashdata('error', 'Winner not found.');
            redirect('provincial/admin');
            return;
        }

        $this->Winners_model->delete_winner($id);
        $this->session->set_flashdata('success', 'Winner deleted.');
        redirect('provincial/admin');
    }

    // CRUD: create category
    public function add_category()
    {
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');

        if ($this->form_validation->run()) {
            $name = $this->input->post('category_name', TRUE);
            $this->Events_model->create_category($name);
            $this->session->set_flashdata('success', 'Category added.');
        } else {
            $this->session->set_flashdata('category_error', validation_errors('', ''));
        }

        redirect('provincial/admin');
    }

    // CRUD: update category
    public function update_category()
    {
        $this->form_validation->set_rules('category_id', 'Category ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim');

        if ($this->form_validation->run()) {
            $id   = (int) $this->input->post('category_id', TRUE);
            $name = $this->input->post('category_name', TRUE);

            $existing = $this->Events_model->get_category($id);
            if (!$existing) {
                $this->session->set_flashdata('category_error', 'Category not found.');
                redirect('provincial/admin');
                return;
            }

            $this->Events_model->update_category($id, $name);
            $this->session->set_flashdata('success', 'Category updated.');
        } else {
            $this->session->set_flashdata('category_error', validation_errors('', ''));
        }

        redirect('provincial/admin');
    }

    // CRUD: delete category
    public function delete_category($category_id = null)
    {
        $id = (int) $category_id;
        if ($id <= 0) {
            $this->session->set_flashdata('error', 'Invalid category.');
            redirect('provincial/admin');
            return;
        }

        $existing = $this->Events_model->get_category($id);
        if (!$existing) {
            $this->session->set_flashdata('error', 'Category not found.');
            redirect('provincial/admin');
            return;
        }

        $this->Events_model->delete_category($id);
        $this->session->set_flashdata('success', 'Category deleted.');
        redirect('provincial/admin');
    }

    // CRUD: create event
    public function add_event()
    {
        $this->form_validation->set_rules('event_name', 'Event Name', 'required|trim');
        $this->form_validation->set_rules('group_id', 'Group', 'required|integer|greater_than[0]');

        if ($this->form_validation->run()) {
            $name       = $this->input->post('event_name', TRUE);
            $groupId    = (int) $this->input->post('group_id', TRUE);
            $categoryId = $this->input->post('category_id', TRUE);
            $categoryId = ($categoryId !== '' && $categoryId !== null) ? (int) $categoryId : null;
            $categoryId = ($categoryId !== null && $categoryId > 0) ? $categoryId : null;

            $this->Events_model->create_event($name, $groupId, $categoryId);
            $this->session->set_flashdata('success', 'Event added.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/admin');
    }

    // CRUD: update event
    public function update_event()
    {
        $this->form_validation->set_rules('event_id', 'Event ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('event_name', 'Event Name', 'required|trim');
        $this->form_validation->set_rules('group_id', 'Group', 'required|integer|greater_than[0]');

        if ($this->form_validation->run()) {
            $eventId    = (int) $this->input->post('event_id', TRUE);
            $name       = $this->input->post('event_name', TRUE);
            $groupId    = (int) $this->input->post('group_id', TRUE);
            $categoryId = $this->input->post('category_id', TRUE);
            $categoryId = ($categoryId !== '' && $categoryId !== null) ? (int) $categoryId : null;
            $categoryId = ($categoryId !== null && $categoryId > 0) ? $categoryId : null;

            $existing = $this->Events_model->get_event_details($eventId);
            if (!$existing) {
                $this->session->set_flashdata('error', 'Event not found.');
                redirect('provincial/admin');
                return;
            }

            $this->Events_model->update_event($eventId, $name, $groupId, $categoryId);
            $this->session->set_flashdata('success', 'Event updated.');
        } else {
            $this->session->set_flashdata('error', validation_errors('', ''));
        }

        redirect('provincial/admin');
    }

    // CRUD: delete event
    public function delete_event($event_id = null)
    {
        $id = (int) $event_id;
        if ($id <= 0) {
            $this->session->set_flashdata('error', 'Invalid event.');
            redirect('provincial/admin');
            return;
        }

        $existing = $this->Events_model->get_event_details($id);
        if (!$existing) {
            $this->session->set_flashdata('error', 'Event not found.');
            redirect('provincial/admin');
            return;
        }

        $this->Events_model->delete_event($id);
        $this->session->set_flashdata('success', 'Event deleted.');
        redirect('provincial/admin');
    }

    /**
     * Normalize the posted winners payload: skip empty rows and surface per-row errors.
     *
     * @param array|null $rawRows
     * @return array [$validRows, $errors]
     */
    private function normalize_winner_rows($rawRows)
    {
        $validRows = array();
        $errors    = array();
        $allowed   = array('Gold', 'Silver', 'Bronze');
        $medalCounts = array('Gold' => 0, 'Silver' => 0, 'Bronze' => 0);

        if (!is_array($rawRows)) {
            return array($validRows, $errors);
        }

        foreach ($rawRows as $index => $row) {
            if (!is_array($row)) {
                continue;
            }

            $first = isset($row['first_name']) ? trim($row['first_name']) : '';
            $middle = isset($row['middle_name']) ? trim($row['middle_name']) : '';
            $last = isset($row['last_name']) ? trim($row['last_name']) : '';
            $municipality = isset($row['municipality']) ? trim($row['municipality']) : '';
            $medal = isset($row['medal']) ? trim($row['medal']) : '';

            $allEmpty = ($first === '' && $middle === '' && $last === '' && $municipality === '');
            if ($allEmpty) {
                continue;
            }

            $labelMedal = in_array($medal, $allowed, true) ? $medal : 'Entry';
            $medalCounts[$labelMedal] = isset($medalCounts[$labelMedal]) ? $medalCounts[$labelMedal] + 1 : 1;
            $label = ($labelMedal !== 'Entry')
                ? $labelMedal . ' entry #' . $medalCounts[$labelMedal]
                : 'Entry #' . ($index + 1);

            if (!in_array($medal, $allowed, true)) {
                $errors[] = $label . ' needs a valid medal (Gold, Silver, or Bronze).';
                continue;
            }

            if ($first === '' || $last === '' || $municipality === '') {
                $errors[] = $label . ' is missing first name, last name, or municipality.';
                continue;
            }

            $validRows[] = array(
                'first_name'   => $first,
                'middle_name'  => $middle,
                'last_name'    => $last,
                'medal'        => $medal,
                'municipality' => $municipality,
            );
        }

        return array($validRows, $errors);
    }

    // NEW: update meet title/year/subtitle from admin
    public function update_meet_settings()
    {
        $this->form_validation->set_rules('meet_title', 'Meet Title', 'required|trim');
        $this->form_validation->set_rules('meet_year', 'Meet Year', 'required|trim');

        if ($this->form_validation->run()) {
            $data = array(
                'meet_title' => $this->input->post('meet_title', TRUE),
                'meet_year'  => $this->input->post('meet_year', TRUE),
                'subtitle'   => $this->input->post('subtitle', TRUE),
            );

            $this->MeetSettings_model->update_settings($data);
            $this->session->set_flashdata('success', 'Meet header updated.');
        }

        redirect('provincial/admin');
    }
}
