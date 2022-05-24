<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    public $Order;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('order/OrderModel');
        $this->Order = new OrderModel();
        $this->load->library('cart');
        $this->load->library('form_validation');
    }
    
    public function getCart()
    {
        $this->load->view('themes/header');
        $this->load->view('checkout/checkout');
        $this->load->view('themes/footer');
    }

    public function saveCheckout()
    {
        $this->form_validation->set_message('required', '%s kitöltése kötelező!');
        $this->form_validation->set_rules('name', 'Név', 'required');
        $this->form_validation->set_rules('email', 'Email cím', 'required|valid_email');
        $this->form_validation->set_rules('zip_code', 'Irányítószám', 'required');
        $this->form_validation->set_rules('city', 'Város', 'required');
        $this->form_validation->set_rules('address', 'Utca/házszám', 'required');
        $this->form_validation->set_rules('tel', 'Telefonszám', 'required');
        if(count($this->cart->contents()) == 0){
            $this->form_validation->set_rules('carterror','Kosár','required');
        }
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect(base_url('checkout'));
        } else {
            $this->Order->insertOrder();
            redirect(base_url('orders'));
        }
    }

    public function getOrders()
    {
        $data['orders'] = $this->Order->getOrders();
        $this->load->view('themes/header');
        $this->load->view('order/order', $data);
        $this->load->view('themes/footer');
    }

    public function getOrderItems($id = null)
    {
        $data['order_items'] = $this->Order->getOrderItems($id);
        $this->load->view('themes/header');
        $this->load->view('order/order_items', $data);
        $this->load->view('themes/footer');
    }

    public function deleteOrder()
    {
        $this->Order->deleteOrder();
    }

    public function addProductToCart()
    {
        $this->Order->addToCart();
    }
    
    public function deleteCartItem()
    {
        $this->Order->deleteCartItem();
    }
}
