<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Technical_model extends CI_Model
{
    public function get_all()
    {
        return $this->db
            ->order_by("FIELD(role, 'Tournament Manager', 'Technical Official')", '', false)
            ->order_by('name', 'ASC')
            ->get('technical_officials')
            ->result();
    }

    public function get($id)
    {
        return $this->db->get_where('technical_officials', array('id' => (int) $id))->row();
    }

    public function create($name, $role)
    {
        return $this->db->insert('technical_officials', array(
            'name' => $name,
            'role' => $role,
        ));
    }

    public function update($id, $name, $role)
    {
        return $this->db->update(
            'technical_officials',
            array('name' => $name, 'role' => $role),
            array('id' => (int) $id)
        );
    }

    public function delete($id)
    {
        return $this->db->delete('technical_officials', array('id' => (int) $id));
    }
}
