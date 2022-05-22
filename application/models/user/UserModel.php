<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class UserModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function createUser($username, $email, $password) {
        $data = array(
            'username'   => $username,
            'email'      => $email,
            'password'   => $this->hashPassword($password),
            'created_at' => date('Y-m-j H:i:s'),
        );
        return $this->db->insert('users', $data);
    }

    public function resolveUserLogin($username, $password) {
        $this->db->select('password');
        $this->db->from('users');
        $this->db->where('username', $username);
        $hash = $this->db->get()->row('password');
        return $this->verifyPasswordHash($password, $hash);
    }

    public function getUserIdFromUsername($username) {
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('username', $username);
        return $this->db->get()->row('id');
    }

    public function getUser($user_id) {
        $this->db->from('users');
        $this->db->where('id', $user_id);
        return $this->db->get()->row();
    }

    private function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private function verifyPasswordHash($password, $hash) {
        return password_verify($password, $hash);
    }
	
}
