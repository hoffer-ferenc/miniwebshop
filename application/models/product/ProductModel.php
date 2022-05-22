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
    
    public function fill(){
        //$string = 'INSERT INTO `products` (`name`, `description`, `Bzip_code`, `Bcity`, `Baddress`, `Btel`, `Bemail`, `sameadr`, `Czip_code`, `Ccity`, `Caddress`, `Ctel`, `order_total`, `order_status`, `date_record`)';
        
        //for($i = 0; $i <= 1000; $i++){
           // $string .= 'VALUES (7, 'Hoffer Ferenc Joachim', '', 2750, 'Nagykőrös', 'Sólyom utca 3.-5.', '06205262456', 'ferike.hoffer@gmail.com', 0, 0, '', '', '', 10000, 2, '2021-10-26 22:21:15'),';
        //}
        
        for($i = 0; $i <= 1000; $i++){
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
    
    public function addToCart(){
        $cart_data = array(
            'id' => $this->input->post("id"),
            'qty' => $this->input->post("amount"),
            'name' => $this->input->post("name"),
            'price' => $this->input->post("price"),
            'sale_price' => $this->input->post("sale_price"),
        );
        $query = $this->cart->insert($cart_data);
        echo count($this->cart->contents());
        return $query;
    }

    public function deleteCartItem(){
        if(!empty($this->input->post("rowid"))){
            $data = array('rowid' => $this->input->post("rowid"), 'qty' => 0);
            $this->cart->update($data);
            echo '1';
        }else{
            throw new Exception("...");
        }

    }

    public function insertOrder(){
        foreach($this->cart->contents() as $cart_data){
            $order_items = array(
                'idproduct' => $cart_data['id'],
                'product_name' => $cart_data['name'],
                'price' => $cart_data['size'],
                'sale_price' => $cart_data['color'],
                'amount' => $cart_data['qty'],
                'shipping' => 1500,
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'tel' => $this->input->post('tel'),
                'zip' => $this->input->post('zip'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city')
            );
            $this->db->insert('order_items', $order_items);

            //készlet levonás
            $this->db->from('products');
            $this->db->where('id', $cart_data['id']);
            $result = $this->db->get()->row();
            $amount = $result->amount - $cart_data['qty'];

            $this->db->where('id',$cart_data['id']);
            $this->db->update('products', array('stock' => $amount));
        }
        $this->cart->destroy();
    }
    
}
