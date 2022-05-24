<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user/UserModel');
        $this->load->library('cart');
    }
	
    public function index() {}

    public function register() {
        $data = new stdClass();
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'Ez a felhásználó létezik. Kérem válasszon másik nevet.'));
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

        if ($this->form_validation->run() === false) {
            
            $this->load->view('themes/header');
            $this->load->view('user/register/register', $data);
            $this->load->view('themes/footer');
        } else {
            
            $username = $this->input->post('username');
            $email    = $this->input->post('email');
            $password = $this->input->post('password');
                if ($this->UserModel->createUser($username, $email, $password)) {
                    
                    $this->load->view('themes/header');
                    $this->load->view('user/register/register_success', $data);
                    $this->load->view('themes/footer');
                } else {
                    $data->error = 'Probléma lépett fel a regisztráció során, kérem próbálja újra';
                    
                    $this->load->view('themes/header');
                    $this->load->view('user/register/register', $data);
                    $this->load->view('themes/footer');
                }
        }

    }

    public function login() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == false) {

                $this->load->view('themes/header');
                $this->load->view('user/login/login');
                $this->load->view('themes/footer');
            } else {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                if ($this->UserModel->resolveUserLogin($username, $password)) {
                    
                    $user_id = $this->UserModel->getUserIdFromUsername($username);
                    $user    = $this->UserModel->getUser($user_id);
                    
                    $_SESSION['user_id']      = (int)$user->id;
                    $_SESSION['username']     = (string)$user->username;
                    $_SESSION['logged_in']    = (bool)true;
                    $_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
                    $_SESSION['is_admin']     = (bool)$user->is_admin;
                    
                    if($user->is_admin == 1){
                        redirect('products');
                    }else{
                        redirect('products');
                    }

                } else {
                    $data = new stdClass();
                    $data->error = 'Hibás felhasználónév vagy jelszó.';
                    
                    $this->load->view('themes/header');
                    $this->load->view('user/login/login', $data);
                    $this->load->view('themes/footer');
                }
            }

    }

    public function logout() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

            foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
            }
            
            $this->load->view('themes/header');
            $this->load->view('user/logout/logout_success');
            $this->load->view('themes/footer');
        } else {
            redirect('/');
        }

    }
	
}
