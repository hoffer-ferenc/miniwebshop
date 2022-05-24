<?php

class ProductModel extends CI_Model{
    
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
        $this->load->helper('url', 'form');
        $this->load->library('cart');
    }
    
    public function getAllProduct($limit = 5){
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('status', 1);
        $this->db->limit($limit);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function filterProducts($limit = 5, $offset = 0){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $order_type = $this->input->get('order_type');
        $this->db->from('products');
        $this->db->where('status', 1);
        if(!empty($this->input->get("search"))){
            $this->db->like('name', $this->input->get("search"));
        }
        if($order_type != null && $order_type != ''){
            if($order_type == 'name_asc'){
                $this->db->order_by("name", "asc");
            }
            if($order_type == 'name_desc'){
                $this->db->order_by("name", "desc");
            }
            if($order_type == 'price_asc'){
                $this->db->order_by("sale_price", "asc");
            }
            if($order_type == 'price_desc'){
                $this->db->order_by("sale_price", "desc");
            }
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        
        return $query->result();
    }

    public function recordCount(){
        $this->db->where('status', 1);
        return $this->db->count_all("products");
    }
    
    //hatékonyabb termék import
    public function fill($max_generate = 1000){
        $string = 'INSERT INTO `products` (`name`, `description`, `price`, `sale_price`, `stock`, `available`, `image`, `status`) VALUES ';
        for ($i = 1; $i <= $max_generate - 1; $i++) {
            $price = rand(3000, 10000);
            $sale_price = $price - rand(1000, 2500);
            $string .= '('.'"teszt'.$i.'",'
                . '"Lorem Ipsum is simply dummy text."'.','
                . $price.','
                . $sale_price.','
                . rand(3, 30).','
                . rand(0, 1).',"'
                . base_url().'/assets/images/dummy.jpg"'.','
                . rand(0, 1).'),'
            ;
        }
        $price = rand(3000, 10000);
        $sale_price = $price - rand(1000, 2500);
        $string .= '('.'"teszt'.$max_generate.'",'
            . '"Lorem Ipsum is simply dummy text."'.','
            . $price.','
            . $sale_price.','
            . rand(3, 30).','
            . rand(0, 1).',"'
            . base_url().'/assets/images/dummy.jpg"'.','
            . rand(0, 1).');'
        ;
        $query = $this->db->query($string);
        return $query->result();
    }
    
    //lassabb módszer
    public function fill2($max_generate = 1000){
        for($i = 1; $i <= $max_generate; $i++){
            $price = rand(3000, 10000);
            $sale_price = $price - rand(1000, 2500);
            $import_data = array(
                'name' => 'teszt'.$i,
                'description' => 'Lorem Ipsum is simply dummy text.',
                'price' => $price,
                'sale_price' => $sale_price,
                'stock' => rand(3, 30),
                'available' => rand(0, 1),
                'image' => base_url().'/assets/images/dummy.jpg',
                'status' => rand(0, 1)
            );
            $this->db->insert('products', $import_data);
        }
    }

    public function getProductById($id = null){
        $this->db->where('id',$id);
        $query = $this->db->get('products');
        return $query->row();
    }
    

    
}
