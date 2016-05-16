<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploadfile extends CI_Model {
    public function __construct() {
            // Call the CI_Model constructor
            parent::__construct();
    }
    
    public function nouveausujet($fileName, $id_mat, $titre, $annee, $rattrapage = FALSE) {
        $titre = $this->db->escape($titre);
        $posteur = $this->session->user_id;
        $rattrapage = ($rattrapage != FALSE);
        if ($rattrapage) { $rattrapage = "TRUE"; } else { $rattrapage = "FALSE"; }
        $sql = "INSERT INTO sujets (titre, matiere, annee, rattrapage, posteur, url)
                VALUES ({$titre}, {$id_mat}, {$annee}, {$rattrapage}, {$posteur}, '{$fileName}');";
        $query = $this->db->query($sql);
    }
    
    public function nouvellecorrection($fileName, $id_suj, $titre) {
        $this->load->model('sujet');
        $infos = $this->sujet->get_infos($id_suj);
        $infos = $infos[0];
        $titre = $this->db->escape($titre);
        $posteur = $this->session->user_id;
        $rattrapage = $infos['rattrapage'];
        $id_mat = $infos['matiere'];
        $annee = $infos['annee'];
        if ($rattrapage) { $rattrapage = "TRUE"; } else { $rattrapage = "FALSE"; }
        
        // Insert new sujet (it is correction)
        $sql = "INSERT INTO sujets (titre, matiere, annee, rattrapage, correction, posteur, url)
                VALUES ({$titre}, {$id_mat}, {$annee}, {$rattrapage}, TRUE, {$posteur}, '{$fileName}');";
        $query = $this->db->query($sql);
        
        // Now, we want its id
        $sql = "SELECT id_suj FROM sujets WHERE url = '{$fileName}';";
        $query = $this->db->query($sql);
        $row = $query->row();
        $id_correction = $row->id_suj;
        
        // Insert new correspondance
        $id_suj = $infos['id_suj'];
        $sql = "INSERT INTO correspondance (id_sujet, id_correction)
                VALUES ({$id_suj}, {$id_correction});";
        $query = $this->db->query($sql);
    }
}