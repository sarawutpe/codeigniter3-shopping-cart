<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CheckoutController extends CI_Controller {
	// Autoload
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('checkout_model');
    }

    // checkout
   	public function checkout()
	{
        // โหลดวิว
        $this->load->view('pages/checkout');

        // ถ้ามี post ข้อมูลเข้ามา
        if($this->input->post()) {
            // รวมที่อยู่จัดส่ง
            $myaddress = "";
            $myaddress = ($this->input->post('name')." ".($this->input->post('addresses')." ".$this->input->post('mobile_phone')));

            // สร้าง data
            $data = array(
                'address ' => $myaddress,
                'orders' => $this->input->post('order'),
            );
            
            // print_r($data);

            $this->checkout_model->createOrder($data);
        }
	}




}
