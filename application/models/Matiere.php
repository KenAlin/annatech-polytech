<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matiere extends CI_Model {
    public function __construct() {
            // Call the CI_Model constructor
            parent::__construct();
    }
    
    public function exists($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM matieres WHERE id_mat = {$id};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) return TRUE;
        else return FALSE;
    }
    
    public function get_list($id_ue) {
        $id_ue = $this->db->escape($id_ue);
        $sql = "SELECT * FROM matieres WHERE id_ue = {$id_ue} ORDER BY nom_mat;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function get_infos($id) {
        $id_mat = $this->db->escape($id);
        $sql = "SELECT * FROM matieres mat, ue, sections sec WHERE id_mat = {$id_mat} AND mat.id_ue=ue.id_ue AND ue.section=sec.nom_section;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_nom($id) {
        // Select UE list from DB
        $id = $this->db->escape($id);
        $sql = "SELECT nom_mat FROM matieres WHERE id_mat = {$id};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) {
            return $row->nom_mat;
        }
        else return "";
    }
    
    public function get_section($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT sec.nom_section, sec.nom_complet FROM sections sec, ue, matieres mat WHERE mat.id_mat = {$id} AND mat.id_ue = ue.id_ue AND ue.section = sec.nom_section;";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) {
            return $row->nom_section;
        }
        else return "";
    }
    
    public function get_annee($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT ue.annee FROM matieres mat, ue WHERE mat.id_mat = {$id} AND mat.id_ue = ue.id_ue;";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) {
            return $row->annee;
        }
        else return "";
    }
    public function get_description($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT description FROM matieres WHERE id_mat = {$id};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) {
            return $row->description;
        }
        else return "";
    }
    
    public function get_sujets($id) {
        $id_mat = $this->db->escape($id);
        $sql = "SELECT * FROM sujets WHERE matiere = {$id_mat} AND correction = FALSE ORDER BY annee DESC;";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}