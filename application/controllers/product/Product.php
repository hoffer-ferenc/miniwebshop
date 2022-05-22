<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Product extends CI_Controller {

    public $Product;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('product/ProductModel');
        $this->Product = new ProductModel();
        $this->load->library('cart');
    }
    
    public function getProducts()
    {
        $per_page = 5;
        $data['products'] = $this->Product->getAllProduct($per_page);
        $rows = $this->Product->recordCount();
        $data["counted_items"] = $rows;
        $data["per_page"] = $per_page;
        $data["all_data"] = $rows / $per_page;

        $this->load->view('themes/header');
        $this->load->view('product/list', $data);
        $this->load->view('themes/footer');
    }

    public function getProductList()
    {
        $per_page = 5;
        $data['products'] = $this->Product->filterProducts();
        $rows = $this->Product->recordCount();
        $data["counted_items"] = $rows;
        $data["per_page"] = $per_page;
        $data["all_data"] = $rows / $per_page;
        
        echo json_encode($this->load->view('product/product_list', $data));
    }

    public function getSingleProduct($id)
    {
        $data['product'] = $this->Product->getProductById($id);
        $this->load->view('themes/header');
        $this->load->view('product/product', $data);
        $this->load->view('themes/footer');
    }

    public function addProductToCart()
    {
        $this->Product->addToCart();
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
        $this->form_validation->set_rules('zip', 'Irányítószám', 'required');
        $this->form_validation->set_rules('city', 'Város', 'required');
        $this->form_validation->set_rules('address', 'Utca/házszám', 'required');
        $this->form_validation->set_rules('tel', 'Telefonszám', 'required');
        if(count($this->cart->contents()) == 0){
            $this->form_validation->set_rules('carterror','Kosár','required');
        }
        if ($this->form_validation->run() == FALSE || count($this->cart->contents() == 0)){
            $this->session->set_flashdata('errors', validation_errors());
            redirect(base_url('checkout'));
        }else{
            $this->Product->insertOrder();
            redirect(base_url('my_orders'));
        }

    }

    public function deleteCartItem()
    {
        $this->Product->deleteCartItem();
    }
}
