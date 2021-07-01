<?php
class Stock_model extends CI_Model {
    // CRUD (CREATE UPDATE DELETE) -> Database

    // Add product
    public function createProduct($data){
        $this->db->insert('products', $data);
    }
    
    // Get all product
    public function getProducts() {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('products');
        return $query->result_array();
    }

    // Get product by Id
    public function getProductById($id) {
        $query = $this->db->get_where('products', array('id' => $id));
        return $query->result_array();
    }
    
    // Updata product by Id
    public function updatateProductById($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('products', $data);
    }

    // Delete product by Id 
    public function deleteProductById($id) {
        $this->db->where('id', $id);
        $this->db->delete('products');
    }



}