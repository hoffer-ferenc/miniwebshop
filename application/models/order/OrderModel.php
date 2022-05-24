<?php

class OrderModel extends CI_Model{
    
    public function __construct() {
        parent::__construct(); 
        $this->load->database();
        $this->load->helper('url', 'form');
        $this->load->library('cart');
    }
    
    public function insertOrder(){
        $iduser = (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['user_id'] > 0) ? $_SESSION['user_id'] : 0;
        $order_data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'zip_code' => $this->input->post('zip_code'),
            'city' => $this->input->post('city'),
            'address' => $this->input->post('address'),
            'shipping' => 1500,
            'order_total' => $this->cart->total(),
            'iduser' => $iduser,
            'status' => 1
        );
        $this->db->insert('orders', $order_data);
        $order_id =$this->db->insert_id();
        foreach($this->cart->contents() as $cart_item){
            $order_items = array(
                'idorder' => $order_id,
                'idproduct' => $cart_item['id'],
                'price' => $cart_item['price'],
                'sale_price' => $cart_item['sale_price'],
                'amount' => $cart_item['qty'],
                'status' => 1
            );
            $this->db->insert('order_items', $order_items);

            //készlet levonás
//            $this->db->from('products');
//            $this->db->where('id', $cart_item['id']);
//            $result = $this->db->get()->row();
//            $amount = $result->amount - $cart_item['qty'];

//            $this->db->where('id',$cart_item['id']);
//            $this->db->update('products', array('stock' => $amount));
        }
        $this->cart->destroy();
    }
    
    public function getOrders(){
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
            $this->db->from('orders');
            if($_SESSION['is_admin'] == 0 && $_SESSION['user_id'] >= 0){
                $this->db->where('orders.iduser', $_SESSION['user_id']);
            }
            $this->db->where('orders.status', 1);
            $query = $this->db->get();
            return $query->result();
        } else {
            redirect('products');
        }
    }

    public function getOrderItems($idorder = null){
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
            $this->db->from('order_items');
            $this->db->join('products','products.id = order_items.idproduct');
            $this->db->where('order_items.idorder', $idorder);
            $this->db->where('order_items.status', 1);
            $query = $this->db->get();
            return $query->result();
        } else {
            redirect('products');
        }
    }
    
    public function deleteOrder(){
        try {
            $this->db->where('idorder', $this->input->post('idorder'));
            $this->db->update('orders', array('status' => 0));
            $this->db->where('idorder', $this->input->post('idorder'));
            $this->db->update('order_items', array('status' => 0));

            $db_error = $this->db->error();
            if (!empty($db_error)) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
            }
            echo '1';
            return TRUE;
        } catch (Exception $e) {
            log_message('error ',$e->getMessage());
            return false;
        }
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

    
}
