<?php
class Checkout_model extends CI_Model {
    // CRUD (CREATE UPDATE DELETE) -> Database

    // Add order
    public function createOrder($data) {
        $this->db->insert('orders', $data);
    }
    
}