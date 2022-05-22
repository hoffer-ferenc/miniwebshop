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
}
