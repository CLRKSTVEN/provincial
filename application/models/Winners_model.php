<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Winners_model extends CI_Model
{
    public function insert_winner($data)
    {
        return $this->db->insert('winners', $data);
    }
    public function get_winners_list($event_group = null)
    {
        $this->db->select("
        event_name,
        event_group,
        category,
        CONCAT(last_name, ', ', first_name, ' ', COALESCE(middle_name, '')) AS full_name,
        medal,
        municipality,
        created_at
    ", FALSE);
        $this->db->from('winners');

        if ($event_group === 'Elementary' || $event_group === 'Secondary') {
            $this->db->where('event_group', $event_group);
        }

        // Order: Event, Group, Category, Medal (Gold > Silver > Bronze), Name
        $this->db->order_by('event_name', 'ASC');
        $this->db->order_by('event_group', 'ASC');
        $this->db->order_by('category', 'ASC');
        $this->db->order_by("FIELD(medal, 'Gold', 'Silver', 'Bronze')", '', FALSE);
        $this->db->order_by('full_name', 'ASC');

        return $this->db->get()->result();
    }

    public function get_recent_winners($limit = 10)
    {
        $this->db->select("
            event_name,
            event_group,
            category,
            CONCAT(last_name, ', ', first_name, ' ', COALESCE(middle_name, '')) AS full_name,
            medal,
            municipality,
            created_at
        ", FALSE);
        $this->db->from('winners');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    // Medal tally by municipality (all groups)
    public function get_medal_tally()
    {
        $this->db->select("
            municipality,
            SUM(medal = 'Gold')   AS gold,
            SUM(medal = 'Silver') AS silver,
            SUM(medal = 'Bronze') AS bronze,
            COUNT(*)              AS total_medals
        ", FALSE);
        $this->db->from('winners');
        $this->db->group_by('municipality');
        $this->db->order_by('gold', 'DESC');
        $this->db->order_by('silver', 'DESC');
        $this->db->order_by('bronze', 'DESC');
        $this->db->order_by('municipality', 'ASC');

        return $this->db->get()->result();
    }

    // Medal tally by municipality + group (Elementary / Secondary)
    public function get_medal_tally_by_group($event_group)
    {
        $this->db->select("
            municipality,
            event_group,
            SUM(medal = 'Gold')   AS gold,
            SUM(medal = 'Silver') AS silver,
            SUM(medal = 'Bronze') AS bronze,
            COUNT(*)              AS total_medals
        ", FALSE);
        $this->db->from('winners');
        $this->db->where('event_group', $event_group);
        $this->db->group_by(array('municipality', 'event_group'));
        $this->db->order_by('gold', 'DESC');
        $this->db->order_by('silver', 'DESC');
        $this->db->order_by('bronze', 'DESC');
        $this->db->order_by('municipality', 'ASC');

        return $this->db->get()->result();
    }

    // NEW: overview stats for the header cards
    public function get_overview($event_group = null)
    {
        $this->db->select("
            COUNT(DISTINCT municipality)         AS municipalities,
            COUNT(DISTINCT event_name)           AS events,
            SUM(medal = 'Gold')                  AS gold,
            SUM(medal = 'Silver')                AS silver,
            SUM(medal = 'Bronze')                AS bronze,
            COUNT(*)                             AS total_medals,
            MAX(created_at)                      AS last_update
        ", FALSE);
        $this->db->from('winners');

        if ($event_group === 'Elementary' || $event_group === 'Secondary') {
            $this->db->where('event_group', $event_group);
        }

        return $this->db->get()->row();
    }
}
