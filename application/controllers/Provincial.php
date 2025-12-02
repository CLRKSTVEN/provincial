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
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
            $this->form_validation->set_rules('medal', 'Medal', 'required|trim');
            $this->form_validation->set_rules('municipality', 'Municipality', 'required|trim');

            if ($this->form_validation->run()) {
                $eventId = (int) $this->input->post('event_id', TRUE);
                $event   = $this->Events_model->get_event_details($eventId);

                if (!$event) {
                    $this->session->set_flashdata('error', 'Selected event could not be found. Please pick a valid event.');
                    redirect('provincial/admin');
                    return;
                }

                $insert = array(
                    'event_id'    => $event->event_id,
                    'event_name'  => $event->event_name,
                    'event_group' => $event->group_name ?? 'Unspecified',
                    'category'    => $event->category_name,
                    'first_name'   => $this->input->post('first_name', TRUE),
                    'middle_name'  => $this->input->post('middle_name', TRUE),
                    'last_name'    => $this->input->post('last_name', TRUE),
                    'medal'        => $this->input->post('medal', TRUE),
                    'municipality' => $this->input->post('municipality', TRUE),
                );

                $this->Winners_model->insert_winner($insert);
                $this->session->set_flashdata('success', 'Winner saved successfully.');
                redirect('provincial/admin');
                return;
            }
        }

        // pass meet settings to the admin form
        $data['meet'] = $this->MeetSettings_model->get_settings();
        $data['recent_winners'] = $this->Winners_model->get_recent_winners(10);
        $data['event_categories'] = $this->Events_model->get_categories();
        $data['events'] = $this->Events_model->get_events_with_meta();
        $data['municipalities'] = $this->Address_model->get_municipalities();

        $this->load->view('dashboard_admin', $data);
    }

    public function update_winner()
    {
        $this->form_validation->set_rules('winner_id', 'Winner ID', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('event_id', 'Event', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('medal', 'Medal', 'required|trim');
        $this->form_validation->set_rules('municipality', 'Municipality', 'required|trim');

        if ($this->form_validation->run()) {
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

            $update = array(
                'event_id'    => $event->event_id,
                'event_name'  => $event->event_name,
                'event_group' => $event->group_name ?? 'Unspecified',
                'category'    => $event->category_name,
                'first_name'   => $this->input->post('first_name', TRUE),
                'middle_name'  => $this->input->post('middle_name', TRUE),
                'last_name'    => $this->input->post('last_name', TRUE),
                'medal'        => $this->input->post('medal', TRUE),
                'municipality' => $this->input->post('municipality', TRUE),
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
