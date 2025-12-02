<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Address_model extends CI_Model
{
    /**
     * Returns distinct municipalities (City column) sorted alphabetically.
     */
    public function get_municipalities()
    {
        $this->db->distinct();
        $this->db->select('City AS municipality');
        $this->db->from('settings_address');
        $this->db->where('City IS NOT NULL');
        $this->db->where('City !=', '');
        $this->db->order_by('City', 'ASC');

        return $this->db->get()->result();
    }
}
