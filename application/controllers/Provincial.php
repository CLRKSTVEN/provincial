<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Provincial extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Winners_model');
        $this->load->model('MeetSettings_model'); // NEW
        $this->load->library(array('form_validation', 'session'));
        $this->load->helper(array('url', 'form'));
    }

    public function index()
    {
        $group = $this->input->get('group', TRUE);

        if ($group === 'Elementary' || $group === 'Secondary') {
            $winners  = $this->Winners_model->get_winners_list($group);
            $overview = $this->Winners_model->get_overview($group);
            $active   = $group;
        } else {
            $winners  = $this->Winners_model->get_winners_list(null);
            $overview = $this->Winners_model->get_overview(null);
            $active   = 'ALL';
        }

        $data = array(
            'active_group' => $active,
            'winners'      => $winners,
            'overview'     => $overview,
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

            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
            $this->form_validation->set_rules('event_name', 'Event', 'required|trim');
            $this->form_validation->set_rules('event_group', 'Group', 'required|trim');
            $this->form_validation->set_rules('medal', 'Medal', 'required|trim');
            $this->form_validation->set_rules('municipality', 'Municipality', 'required|trim');

            if ($this->form_validation->run()) {
                $insert = array(
                    'first_name'   => $this->input->post('first_name', TRUE),
                    'middle_name'  => $this->input->post('middle_name', TRUE),
                    'last_name'    => $this->input->post('last_name', TRUE),
                    'event_name'   => $this->input->post('event_name', TRUE),
                    'event_group'  => $this->input->post('event_group', TRUE),
                    'category'     => $this->input->post('category', TRUE),
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

        $this->load->view('dashboard_admin', $data);
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
