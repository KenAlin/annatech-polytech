<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section extends CI_Model {
    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }
    
    public function get_uelist($section, $annee) {
        $section = $this->db->escape($section);
        $annee = $this->db->escape($annee);
        $sql = "SELECT * FROM ue WHERE section = {$section} AND annee = {$annee} ORDER BY semestre;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function get_list() {
        $sql = "SELECT * FROM sections;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}