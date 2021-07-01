<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends CI_Controller {
	// Autoload
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('stock_model');
    }

	// get all product from stock_model
	public function index()
	{
		$data['products'] = $this->stock_model->getProducts();
		$this->load->view('pages/index', $data);
	}

}
