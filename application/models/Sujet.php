<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sujet extends CI_Model {
    public function __construct() {
            // Call the CI_Model constructor
            parent::__construct();
    }
    
    public function exists($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM sujets WHERE id_suj = {$id};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) return TRUE;
        else return FALSE;
    }
    
    public function existsSujet($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM sujets WHERE id_suj = {$id} AND correction = FALSE;";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) return TRUE;
        else return FALSE;
    }
    
    public function existsCorrection($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM sujets WHERE id_suj = {$id} AND correction = TRUE;";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) return TRUE;
        else return FALSE;
    }
    
    public function supprCorrection($id) {
        $sql = "DELETE FROM correspondance WHERE id_correction = {$id};";
        $query = $this->db->query($sql);
        $sql = "DELETE FROM sujets WHERE id_suj = {$id};";
        $query = $this->db->query($sql);
    }
    
    public function supprSujet($id) {
        $sql = "DELETE FROM sujets WHERE id_suj IN (SELECT id_correction FROM correspondance WHERE id_correction = {$id});";
        $query = $this->db->query($sql);
        $sql = "DELETE FROM correspondance WHERE id_sujet = {$id};";
        $query = $this->db->query($sql);
        $sql = "DELETE FROM sujets WHERE id_suj = {$id};";
        $query = $this->db->query($sql);
    }

    public function get_matiere($id) {
        // Select UE list from DB
        $id = $this->db->escape($id);
        $sql = "SELECT matiere FROM sujets WHERE id_suj = {$id};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) {
            return $row->matiere;
        }
        else return -1;
    }
    
    public function get_url($id) {
        // Select UE list from DB
        $id = $this->db->escape($id);
        $sql = "SELECT url FROM sujets WHERE id_suj = {$id};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) {
            return $row->url;
        }
        else return "";
    }
    
    public function get_infos($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM sujets WHERE id_suj = {$id};";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}