<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockController extends CI_Controller {
    // Autoload
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('stock_model');
    }


    // Get all products
	public function index()
	{
        $data['products'] = $this->stock_model->getProducts();
		$this->load->view('pages/stock', $data);
	}

    // Create products
    public function create()
	{

        $this->load->view('pages/stock_create');

        // if input->post begin save to db
        if($this->input->post()) {
            // อัปโหลดไปยัง /uploaded ไฟล์รูปน้อยกว่า 1mb
            $config['upload_path']          = './uploaded/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 1048576; 

            $this->load->library('upload', $config);

            // ถ้าไม่มีอัปโหลดรูปภาพ set image
            if (!$this->upload->do_upload('image')) { 
                $data = array(
                    'name' => $this->input->post('name'),
                    'image' => "",
                    'price' => $this->input->post('price')
                );
                // save
                $this->stock_model->createProduct($data);
                // redirect ไปยังหน้า stock
                redirect("stock");

            // ถ้ามีการอัปโหลดรูปภาพ
            } else {
                $this->upload->data();
                $data = array(
                    'name' => $this->input->post('name'),
                    'image' => $this->upload->data('file_name'),
                    'price' => $this->input->post('price')
                );
                // save
                $this->stock_model->createProduct($data);
                // redirect ไปยังหน้า stock
                redirect("stock");
            }
     
        }
        // end save to db
	}

    // Edit product by Id
    public function edit($id) {
        // get ข้อมูลตาม id ที่เลือก (Get product)
        $data['product'] = $this->stock_model->getProductById($id);
        $this->load->view('pages/stock_edit', $data);

        // ถ้ามี post (Update product)
        if($this->input->post()) {
            $id = ($this->input->post('id'));

            // อัปโหลดไปยังโฟล์เดอร์ /uploaded/ 
            $config['upload_path']      = './uploaded/';
            // อนุญาตไฟล์ gif jpg png
            $config['allowed_types']    = 'gif|jpg|png';
            // ไฟล์รูปน้อยกว่า 1048576 (1MB)
            $config['max_size']         = 1048576;
            
            $this->load->library('upload', $config);

            // ถ้าไม่มีอัปโหลดรูปภาพ set image
            if (!$this->upload->do_upload('image')) { 
                $data = array(
                    'name' => $this->input->post('name'),
                    'image' => $data['product'][0]['image'],
                    'price' => $this->input->post('price')
                );
                // save
                $this->stock_model->updatateProductById($id, $data);
                // redirect ไปยังหน้า stock
                redirect("stock");

            // ถ้ามีการอัปโหลดรูปภาพ
            } else {
                $this->upload->data();
                $data = array(
                    'name' => $this->input->post('name'),
                    'image' => $this->upload->data('file_name'),
                    'price' => $this->input->post('price')
                );
                // save
                $this->stock_model->updatateProductById($id, $data);
                 // redirect ไปยังหน้า stock
                redirect("stock");
            }
        }
        // end save to db
        
    }

    // // Delete product by Id
    public function delete($id) {
        $this->stock_model->deleteProductById($id);
        redirect("stock");
    }

    
}
