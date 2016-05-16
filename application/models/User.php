<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
    public function __construct() {
            // Call the CI_Model constructor
            parent::__construct();
    }

    public function exists($login) {
        // Does the user exists ?
        $login = $this->db->escape($login);
        $sql = "SELECT * FROM utilisateurs WHERE login = {$login};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) return TRUE;
        else return FALSE;
    }
    
    public function passwordCorrect($login, $passwd) {
        $login = $this->db->escape($login);
        $sql = "SELECT mdp FROM utilisateurs WHERE login = {$login};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) {
            return password_verify($passwd, $row->mdp);
        }
        else {
            return FALSE;
        }
    }
    
    public function setpassword($login, $passwd) {
        $login = $this->db->escape($login);
        $passwd = $this->db->escape(password_hash($passwd, PASSWORD_BCRYPT));
        $sql = "UPDATE utilisateurs SET mdp = {$passwd} WHERE login = {$login};";
        $query = $this->db->query($sql);
    }
    
    public function identifier($login) {
        $login = $this->db->escape($login);
        $sql = "SELECT id_user FROM utilisateurs WHERE login = {$login};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) {
            return $row->id_user;
        }
        else {
            return -1;
        }
    }
    
    public function nbsujets($login) {
        $login = $this->db->escape($login);
        $sql = "SELECT nbsujets FROM utilisateurs WHERE login = {$login};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) {
            return $row->nbsujets;
        }
        else {
            return -1;
        }
    }
    
    public function admin($login) {
        // Is the user an admin ?
        $login = $this->db->escape($login);
        $sql = "SELECT * FROM utilisateurs WHERE login = {$login} AND admin = TRUE;";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) return TRUE;
        else return FALSE;
    }
    
    public function create($login, $passwd, $token) {
        $mail = $this->db->escape($login."@polytech.univ-montp2.fr");
        $login = $this->db->escape($login);
        $passwd = $this->db->escape(password_hash($passwd, PASSWORD_BCRYPT));
        $token = $this->db->escape($token);
        $sql = "INSERT INTO utilisateurs (login, mail, mdp, token) VALUES ({$login}, {$mail}, {$passwd}, {$token});";
        $query = $this->db->query($sql);
    }
    
    public function active($login) {
        $login = $this->db->escape($login);
        $sql = "SELECT * FROM utilisateurs WHERE login = {$login} AND active = TRUE;";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) return TRUE;
        else return FALSE;
    }
    
    public function token_matches($login, $token) {
        $login = $this->db->escape($login);
        $token = $this->db->escape($token);
        $sql = "SELECT * FROM utilisateurs WHERE login = {$login} AND token = {$token};";
        $query = $this->db->query($sql);
        $row = $query->row();

        if (isset($row)) return TRUE;
        else return FALSE;
    }
    
    public function activate($login) {
        $login = $this->db->escape($login);
        $sql = "UPDATE utilisateurs SET active = TRUE WHERE login = {$login};";
        $query = $this->db->query($sql);
    }
}