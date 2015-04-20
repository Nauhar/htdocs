<?php

//session_start();

class Users extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('users_model');
                // Load form helper library
                $this->load->helper('form');

                // Load form validation library
                $this->load->library('form_validation');

                // Load session library
                $this->load->library('session');
        }

        public function index()
        {
                $data['Utilisateurs'] = $this->users_model->get_Utilisateurs();

                $data['title'] = 'Liste utilisateurs';

                $this->load->view('templates/header', $data);
                $this->load->view('users/index', $data);
                $this->load->view('templates/footer');
        }

        public function view($idutilisateur = NULL)
        {
                $data['Utilisateur'] = $this->users_model->get_Utilisateurs($idutilisateur);
        }

        public function login()
        {
            $this->load->view('utilisateurs/login');
        }

        public function inscription()
        {
            $this->load->view('utilisateurs/inscription');
        }

        // Validate and store registration data in database
        public function validation_inscription() {

        // Check validation for user input in SignUp form
            $this->form_validation->set_rules('email_value', 'Email', 'trim|required');
            $this->form_validation->set_rules('nom', 'Nom', 'trim|required');
            $this->form_validation->set_rules('prenom', 'Prenom', 'trim|required');
            $this->form_validation->set_rules('datenaissance', 'Date de Naissance', 'trim|required');
            $this->form_validation->set_rules('organisation', 'Organisation', 'trim|required');
            $this->form_validation->set_rules('pays', 'Pays', 'trim|required');
            $this->form_validation->set_rules('ville', 'Ville', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('utilisateurs/inscription');
            } else {
                $data = array(
                    'IDUtilisateur' => '',
                    'NomUtilisateur' => $this->input->post('nom'),
                    'PrenomUtilisateur' => $this->input->post('prenom'),
                    'DateNaissance' => $this->input->post('datenaissance'),
                    'Organisation' => $this->input->post('organisation'),
                    'Mail' => $this->input->post('email_value'),
                    'PasswordUtilisateur' => $this->input->post('password'),
                    'VilleUtilisateur' => $this->input->post('ville'),
                    'PaysUtilisateur' => $this->input->post('pays'),
                );
                $result = $this->users_model->registration_insert($data) ;
                if ($result == TRUE) {
                    $data['message_display'] = 'Registration Successfully !';
                    $this->load->view('utilisateurs/login', $data);
                } else {
                    $data['message_display'] = 'Un compte utilisant cette adresse mail existe déjà';
                    $this->load->view('utilisateurs/inscription', $data);
                }
            }
        }

        // Check for user login process
        public function user_login_process() {

            $this->form_validation->set_rules('mail', 'Mail', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');


            if ($this->form_validation->run() == FALSE) {
                $this->load->view('utilisateurs/login');
            } else {
                $data = array(
                    'mail' => $this->input->post('mail'),
                    'password' => $this->input->post('password')
                );

                //DEBUG
                echo $data['mail'];
                echo $data['password'];
                //FIN DEBUG


                $result = $this->users_model->login($data);
                if($result == TRUE){
                    $sess_array = array(
                        'mail' => $this->input->post('mail')
                    );

                     // Add user data in session
                    $this->session->set_userdata('logged_in', $sess_array);
                    $result = $this->users_model->read_user_information($sess_array);


                    if($result != false){
                        echo "OK";

                        $data = array(
                            'IDUtilisateur' => $result[0]->IDUtilisateur,
                            'NomUtilisateur' => $result[0]->NomUtilisateur,
                            'PrenomUtilisateur' => $result[0]->PrenomUtilisateur,
                            'DateNaissance' => $result[0]->DateNaissance,
                            'Organisation' => $result[0]->Organisation,
                            'Mail' => $result[0]->Mail,
                            'VilleUtilisateur' => $result[0]->VilleUtilisateur,
                            'PaysUtilisateur' => $result[0]->PaysUtilisateur,
                            'DateInscription' => $result[0]->DateInscription
                        );

                        $this->session->set_userdata($data);
                        redirect('evenement/index');
                        //$this->load->view('admin_page', $data);

                    }
                }else{
                    $data = array(
                        'error_message' => 'Invalid Username or Password'
                    );
                    $this->load->view('utilisateurs/login', $data);
                }
            }


        }

        // Logout from admin page
        public function logout() {

        // Removing session data
            $sess_array = array(
                'mail' => ''
            );
            $this->session->unset_userdata('logged_in', $sess_array);
            $data['message_display'] = 'Successfully Logout';
            $this->load->view('utilisateurs/login', $data);
        }

}