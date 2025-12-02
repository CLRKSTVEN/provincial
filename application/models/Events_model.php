<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Events_model extends CI_Model
{
    /**
     * Fetch all categories for filtering/labels.
     */
    public function get_categories()
    {
        return $this->db
            ->order_by('category_name', 'ASC')
            ->get('event_categories')
            ->result();
    }

    public function get_category($category_id)
    {
        return $this->db
            ->get_where('event_categories', array('category_id' => (int) $category_id))
            ->row();
    }

    public function create_category($name)
    {
        return $this->db->insert('event_categories', array(
            'category_name' => $name,
        ));
    }

    public function update_category($category_id, $name)
    {
        return $this->db->update(
            'event_categories',
            array('category_name' => $name),
            array('category_id' => (int) $category_id)
        );
    }

    public function delete_category($category_id)
    {
        return $this->db->delete('event_categories', array('category_id' => (int) $category_id));
    }

    /**
     * Fetch all events with their group/category labels for dropdowns.
     */
    public function get_events_with_meta()
    {
        $this->db->select('
            em.event_id,
            em.event_name,
            em.group_id,
            em.category_id,
            eg.group_name,
            ec.category_name
        ');
        $this->db->from('event_master em');
        $this->db->join('event_groups eg', 'eg.group_id = em.group_id', 'left');
        $this->db->join('event_categories ec', 'ec.category_id = em.category_id', 'left');
        $this->db->order_by('eg.group_name', 'ASC');
        $this->db->order_by('em.event_name', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Fetch a single event with its group/category names.
     */
    public function get_event_details($event_id)
    {
        $this->db->select('
            em.event_id,
            em.event_name,
            em.group_id,
            em.category_id,
            eg.group_name,
            ec.category_name
        ');
        $this->db->from('event_master em');
        $this->db->join('event_groups eg', 'eg.group_id = em.group_id', 'left');
        $this->db->join('event_categories ec', 'ec.category_id = em.category_id', 'left');
        $this->db->where('em.event_id', $event_id);

        return $this->db->get()->row();
    }
}
