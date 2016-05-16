<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Annatech extends CI_Controller {

	public function homepage() {
		$data['title'] = "AnnaTech Polytech Montpellier";
		
		$this->load->view('templates/html_head', $data);
		$this->load->view('templates/body_nav', $data);
		$this->load->view('annatech/homepage', $data);
		$this->load->view('templates/body_footer', $data);
	}
	
	public function section($dept, $annee = 3) {
		$data['title'] = "{$dept}{$annee} &bull; AnnaTech";
		$data['section'] = $dept;
		$data['annee'] = $annee;
		
		$this->load->view('templates/html_head', $data);
		$this->load->view('templates/body_nav', $data);
		$this->load->view('annatech/liste_ue', $data);
		$this->load->view('templates/body_footer', $data);
	}
	
	public function matiere($id_mat) {
		$this->load->model('matiere');
		$data['nom_mat'] = $this->matiere->get_nom($id_mat);
		$data['title'] = "{$data['nom_mat']} &bull; AnnaTech";
		$data['id_mat'] = $id_mat;
		
		$this->load->view('templates/html_head', $data);
		$this->load->view('templates/body_nav', $data);
		$this->load->view('annatech/liste_sujets', $data);
		$this->load->view('templates/body_footer', $data);
	}
	
	public function nouveausujet($id_mat) {
		$this->load->model('matiere');
		$data['nom_mat'] = $this->matiere->get_nom($id_mat);
		$data['title'] = "Nouveau sujet en {$data['nom_mat']} &bull; AnnaTech";
		$data['id_mat'] = $id_mat;
		
		$this->load->view('templates/html_head', $data);
		$this->load->view('templates/body_nav', $data);
		$this->load->view('annatech/nouveau_sujet', $data);
		$this->load->view('templates/body_footer', $data);
	}
	
	public function nouvellecorrection($id_suj) {
		$this->load->model('matiere');
		$this->load->model('sujet');
		$id_mat = $this->sujet->get_matiere($id_suj);
		$data['nom_mat'] = $this->matiere->get_nom($id_mat);
		$data['title'] = "Nouvelle correction en {$data['nom_mat']} &bull; AnnaTech";
		$data['id_mat'] = $id_mat;
		$data['id_suj'] = $id_suj;
		
		$this->load->view('templates/html_head', $data);
		$this->load->view('templates/body_nav', $data);
		$this->load->view('annatech/nouvelle_correction', $data);
		$this->load->view('templates/body_footer', $data);
	}
	
	public function utilisateur($action = "default") {
		$data['title'] = "Espace utilisateur &bull; AnnaTech";
		
		if ($action == "deconnexion") {
			$this->session->sess_destroy();
		}
		
		$this->load->view('templates/html_head', $data);
		$this->load->view('templates/body_nav', $data);
		$this->load->view('annatech/utilisateur', $data);
		$this->load->view('templates/body_footer', $data);
	}
	
	public function activate($username, $token) {
		$data['title'] = "Activation de compte &bull; AnnaTech";
		
		$this->load->model('user');
		
		if (!$this->user->exists($username)) {
			$reply = array("code" => "error", "message" => "Ce nom de compte n'existe pas.");
		} else if ($this->user->active($username)) {
			$reply = array("code" => "error", "message" => "Ce compte est déjà actif.");
		} else if (!$this->user->token_matches($username, $token)) {
			$reply = array("code" => "error", "message" => "Le token fourni n'est pas valide.");
		} else {
			$this->user->activate($username, $token);
			$reply = array("code" => "success", "message" => "Ce compte a été activé, vous pouvez donc vous connecter.");
		}
		
		$data['activate'] = TRUE;
		$data['reply_activate'] = $reply['code'];
		$data['message_activate'] = $reply['message'];
		
		$this->load->view('templates/html_head', $data);
		$this->load->view('templates/body_nav', $data);
		$this->load->view('annatech/utilisateur', $data);
		$this->load->view('templates/body_footer', $data);
	}
}
