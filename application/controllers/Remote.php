<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remote extends CI_Controller {
	public function upload($contexte = null, $id_contexte = -1) {
		if (!$this->session->logged_in) {
			echo "Vous devez être connecté pour envoyer un fichier !";
		}
		else {
			$this->load->model('matiere');
			$this->load->model('sujet');
			chmod(realpath(APPPATH.'../content/files/'), 0777);
			$config['upload_path']          = realpath(APPPATH.'../content/files/');
			$config['allowed_types']        = 'pdf';
			$config['max_size']             = 6144;
			$config['file_ext_tolower'] 	= TRUE;
			$config['encrypt_name'] 		= TRUE;
			$this->load->library('upload', $config);
			
			if ($contexte == "newsujet" && $id_contexte >= 1 && $this->matiere->exists($id_contexte)) {
				// New SUJET to upload ! (id_contexte -> matiere id)
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');

				$this->form_validation->set_rules('titre', 'Titre', 'trim|required');
				$this->form_validation->set_rules('annee', 'Année', 'trim|required|numeric|is_natural|greater_than[1980]');
				$this->form_validation->set_rules('rattrapage', 'Rattrapage', '');
				
				if ($this->form_validation->run() == FALSE)	{
					$data['reponse'] = "error";
					$data['message'] = $this->form_validation->error_array();
				}
				else {
					// Form success ! We can upload
					if (!$this->upload->do_upload('file')) {
						$data['reponse'] = "error";
						$data['message'] = $this->upload->display_errors();
					}
					else {
						$data['reponse'] = "success";
						$data['message'] = $this->upload->data();
						$this->load->model('uploadfile');
						$fileName = $this->upload->data('file_name');
						$this->uploadfile->nouveausujet($fileName, $id_contexte, $this->input->post('titre'), $this->input->post('annee'), $this->input->post('rattrapage'));
					}	
				}
				$data['nom_mat'] = $this->matiere->get_nom($id_contexte);
				$data['title'] = "Nouveau sujet en {$data['nom_mat']} &bull; AnnaTech";
				$data['id_mat'] = $id_contexte;
				
				$this->load->view('templates/html_head', $data);
				$this->load->view('templates/body_nav', $data);
				$this->load->view('annatech/nouveau_sujet', $data);
				$this->load->view('templates/body_footer', $data); 	
			}
			else if ($contexte == "newcorrection" && $id_contexte >= 1 && $this->sujet->exists($id_contexte)) {
				// New CORRECTION to upload ! (id_contexte -> sujet id)
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');

				$this->form_validation->set_rules('titre', 'Titre', 'trim|required');
				
				if ($this->form_validation->run() == FALSE)	{
					$data['reponse'] = "error";
					$data['message'] = $this->form_validation->error_array();
				}
				else {
					// Form success ! We can upload
					if (!$this->upload->do_upload('file')) {
						$data['reponse'] = "error";
						$data['message'] = $this->upload->display_errors();
					}
					else {
						$data['reponse'] = "success";
						$data['message'] = $this->upload->data();
						$this->load->model('uploadfile');
						$fileName = $this->upload->data('file_name');
						$this->uploadfile->nouvellecorrection($fileName, $id_contexte, $this->input->post('titre'));
					}
				}
				$id_mat = $this->sujet->get_matiere($id_contexte);
				$data['nom_mat'] = $this->matiere->get_nom($id_mat);
				$data['title'] = "Nouvelle correction en {$data['nom_mat']} &bull; AnnaTech";
				$data['id_mat'] = $id_mat;
				$data['id_suj'] = $id_contexte;
				
				$this->load->view('templates/html_head', $data);
				$this->load->view('templates/body_nav', $data);
				$this->load->view('annatech/nouvelle_correction', $data);
				$this->load->view('templates/body_footer', $data);	
			}
			else {
				// Return error
				echo "Paramètres invalides :(";
			}
		}
	}
	
	
	
	
	public function delete($contexte = null, $id_contexte = -1) {
		if (!$this->session->logged_in && !$this->session->admin) {
			$data['json'] = json_encode(array(
				"message" => "Vous devez être connecté et avoir des droits d'administrateur pour supprimer un fichier !"
			), JSON_UNESCAPED_UNICODE);
		}
		else {
			$this->load->model('matiere');
			$this->load->model('sujet');
			
			if ($contexte == "correction" && $id_contexte >= 1 && $this->sujet->existsCorrection($id_contexte)) {
				unlink("content/files/".$this->sujet->get_url($id_contexte));
				$this->sujet->supprCorrection($id_contexte);
				$data['json'] = json_encode(array("message" => "Correction supprimée avec succès !"), JSON_UNESCAPED_UNICODE);
			}
			if ($contexte == "sujet" && $id_contexte >= 1 && $this->sujet->existsSujet($id_contexte)) {
				unlink("content/files/".$this->sujet->get_url($id_contexte));
				$this->sujet->supprSujet($id_contexte);
				$data['json'] = json_encode(array("success" => TRUE), JSON_UNESCAPED_UNICODE);
			}
			else {
				// Return error
				$data['json'] = json_encode(array("message" => "Paramètres invalides"), JSON_UNESCAPED_UNICODE);
			}
		}
		$this->load->view('api/json', $data);
	}
	
}
