<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function section($name = "allOfThem", $annee = -1) {
		$this->load->model('section');
		if ($name != "allOfThem" && $annee >= 1 && $annee <= 5) {
			// Seek UE of the section
			$result = $this->section->get_uelist($name, $annee);
		}
		else {
			// Return the name of every section of Polytech Montpellier
			$result = $this->section->get_list();
		}
		$data['json'] = json_encode($result, JSON_UNESCAPED_UNICODE);
		$this->load->view('api/json', $data);
	}
	
	public function matieres($id_ue = -1) {
		if ($id_ue > 0) {
			// Get every matière of this UE
			$this->load->model('matiere');
			$data['json'] = json_encode($this->matiere->get_list($id_ue), JSON_UNESCAPED_UNICODE);
		}
		else {
			// Return error
			$data['json'] = json_encode(array("error" => "invalid parameters"));
		}
		$this->load->view('api/json', $data);
	}
	
	public function matiere($id_mat = -1) {
		if ($id_mat > 0) {
			$this->load->model('matiere');
			$data['json'] = json_encode($this->matiere->get_infos($id_mat), JSON_UNESCAPED_UNICODE);
		}
		else {
			// Return error
			$data['json'] = json_encode(array("error" => "invalid parameters"));
		}
		$this->load->view('api/json', $data);
	}
	
	public function sujets($id_mat = -1) {
		if ($id_mat > 0) {
			// Select infos of the MAT
			$this->load->model('matiere');
			$data['json'] = json_encode($this->matiere->get_sujets($id_mat), JSON_UNESCAPED_UNICODE);
		}
		else {
			// Return error
			$data['json'] = json_encode(array("error" => "invalid parameters"));
		}
		$this->load->view('api/json', $data);
	}
	
	public function corrections($id_suj = -1) {
		if ($id_suj > 0) {
			// Select infos of the subject
			$id_suj = $this->db->escape($id_suj);
			$sql = "SELECT * FROM sujets s, correspondance c WHERE c.id_sujet = {$id_suj} AND c.id_correction = s.id_suj AND s.correction = TRUE;";
			$query = $this->db->query($sql);
			$data['json'] = json_encode($query->result_array(), JSON_UNESCAPED_UNICODE);
			
		}
		else {
			// Return error
			$data['json'] = json_encode(array("error" => "invalid parameters"));
		}
		$this->load->view('api/json', $data);
	}
	
	public function user($context = "islogged") {
		if ($context == "islogged") {
			/* True or false */
			if (isset($this->session->logged_in) && $this->session->logged_in == TRUE) {
				$data['json'] = json_encode(
					array(
						"logged_in" => TRUE
					), JSON_UNESCAPED_UNICODE);
			}
			else {
				$data['json'] = json_encode(
					array(
						"logged_in" => FALSE
					), JSON_UNESCAPED_UNICODE);
			}
		}
		else if ($context == "infos") {
			/* Want-user-infos case */
			if (isset($this->session->logged_in) && $this->session->logged_in == TRUE) {
				$this->load->model('user');
				$data['json'] = json_encode(
					array(
						"logged_in" => $this->session->logged_in,
						"username" => $this->session->username,
						"admin" => $this->session->admin,
						"nbsujets" => $this->user->nbsujets($this->session->username)
					), JSON_UNESCAPED_UNICODE);
			}
			else {
				$data['json'] = json_encode(
					array(
						"logged_in" => FALSE,
						"username" => null,
						"admin" => FALSE,
						"nbsujets" => 0
					), JSON_UNESCAPED_UNICODE);
			}
			
		}
		else if ($context == "login") {
			/* Login form case */
			$this->load->model('user');
			$_POST = json_decode(file_get_contents("php://input"), true);
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');

			$this->form_validation->set_rules('login', 'Login', 'trim|required|callback_login_check|callback_is_active',
        		array(
					'required' => 'Login requis.',
					'login_check' => 'Login invalide !',
					'is_active' => 'Compte non activé'
				)
			);
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_password['.$this->input->post('login').']',
        		array(
					'required' => 'Mot de passe requis.',
					'check_password' => 'Mot de passe invalide !'
				)
			);
			
			if ($this->form_validation->run() == FALSE)	{
				$data['json'] = json_encode(
					array(
						"error" => "Données saisies invalides ! Vérifiez que votre nom d'utilisateur et mot de passe soient corrects, et que le compte ait été activé."
					), JSON_UNESCAPED_UNICODE);
			}
			else {
				$user = array(
					'username'  => $this->input->post('login'),
					'logged_in' => TRUE,
					'user_id' => $this->user->identifier($this->input->post('login')),
					'admin' => $this->user->admin($this->input->post('login'))
				);
				$this->session->set_userdata($user);
				$data['json'] = json_encode(
					array(
						"message" => "Connexion réussie !",
						"success" => TRUE
					), JSON_UNESCAPED_UNICODE);
			}
		}
		else if ($context == "changepassword") {
			/* Change-password form case */
			if (isset($this->session->logged_in) && $this->session->logged_in == TRUE) {
				// Logged in ! :)
				$this->load->model('user');
				$_POST = json_decode(file_get_contents("php://input"), true);
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_password['.$this->session->username.']',
					array(
						'required' => 'Mot de passe actuel requis.',
						'check_password' => 'Mot de passe actuel invalide !'
					)
				);
				$this->form_validation->set_rules('newpass', 'New password', 'trim|required|min_length[8]',
					array(
						'required' => 'Nouveau mot de passe requis.',
						'min_length' => 'Le nouveau mot de passe doit faire au moins 8 caractères.'
					)
				);
				$this->form_validation->set_rules('newpass2', 'New password confirmation', 'trim|required|matches[newpass]',
					array(
						'required' => 'Confirmation du nouveau mot de passe requis.',
						'matches' => 'Le nouveau mot de passe ne correspond pas à la confirmation.'
					)
				);
				
				// Run the form !
				if ($this->form_validation->run() == FALSE)	{
					$data['json'] = json_encode(
						array(
							"error" => "Données saisies invalides !"
						), JSON_UNESCAPED_UNICODE);
				}
				else {
					$this->user->setpassword($this->session->username, $this->input->post('newpass'));
					$data['json'] = json_encode(
						array(
							"message" => "Changement de mot de passe effectué !",
							"success" => TRUE
						), JSON_UNESCAPED_UNICODE);
				}
			}
			else {
				// Not logged-in 
				$data['json'] = json_encode(
					array(
						"error" => "Vous n'êtes pas/plus connecté !"
					), JSON_UNESCAPED_UNICODE);
			}
		}
		else if ($context == "create") {
			/* New account form case */
			$this->load->model('user');
			$_POST = json_decode(file_get_contents("php://input"), true);
			if (!($this->user->exists($this->input->post('login')))) {
				// Ok ! Compte inexistant
				$this->load->helper(array('form', 'url'));
				$this->load->library('form_validation');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]',
					array(
						'required' => 'Mot de passe requis.',
						'min_length' => 'Le nouveau mot de passe doit faire au moins 8 caractères.'
					)
				);
				$this->form_validation->set_rules('login', 'Login', 'trim|required|min_length[3]',
					array(
						'required' => 'Nom d\'utilisateur requis.',
						'min_length' => 'Le nom de compte doit faire au minimum 3 caractères.'
					)
				);
				
				// Run the form !
				if ($this->form_validation->run() == FALSE)	{
					$data['json'] = json_encode(
						array(
							"error" => "Données saisies invalides ! Vérifiez que les données saisies sont correctes, et qu'un compte à ce nom n'existe pas déjà."
						), JSON_UNESCAPED_UNICODE);
				}
				else {
					$token = str_shuffle("activate".time()."account".mt_rand(1000,9999));
					$login = $this->input->post('login');
					$this->user->create($login, $this->input->post('password'), $token);
					
					// Send MAIL !!
					$this->load->library('email');
					$configMail = array(
						"protocol" => "smtp",
						"smtp_host" => "smtp.phpnet.org",
						"smtp_user" => "annatech@wave-it.fr",
						"smtp_pass" => "XXXXXX",
						"smtp_port" => "8025",
						"smtp_timeout" => "10",
						"wordwrap" => FALSE,
						"crlf" => "\r\n",
						"newline" => "\r\n"
					);
					$this->email->initialize($configMail);
					
					$this->email->from('annatech@wave-it.fr', 'AnnaTech');
					$this->email->to($login."@polytech.univ-montp2.fr");

					$this->email->subject('Activation de votre compte AnnaTech');
					$this->email->message("Activez dès maintenant votre compte AnnaTech !
					
Login : {$this->input->post('login')}
Utilisez ce lien pour activer votre compte : http://annatech.herokuapp.com/activate/{$login}/{$token}

Bien cordialement.
~ L'équipe d'AnnaTech");

					$this->email->send();
					
					// It is a success
					
					$data['json'] = json_encode(
						array(
							"message" => "Compte créé. Rendez-vous sur votre messagerie @polytech.univ-montp2.fr pour activer votre compte.",
							"success" => TRUE
						), JSON_UNESCAPED_UNICODE);
				}
			} else {
				$data['json'] = json_encode(
					array(
						"error" => "Un compte à ce nom existe déjà."
					), JSON_UNESCAPED_UNICODE);
			}
		}
		else {
			/* Default case */
			$data['json'] = json_encode(array("error" => "invalid parameters"), JSON_UNESCAPED_UNICODE);
		}
		$this->load->view('api/json', $data);
	}
	
	public function login_check($login) {
		$this->load->model('user');
		return $this->user->exists($login);
	}
	
	public function check_password($passwd, $login) {
		$this->load->model('user');
		return $this->user->passwordCorrect($login, $passwd);
	}
	
	public function is_active($login) {
		$this->load->model('user');
		return $this->user->active($login);
	}
	
}
