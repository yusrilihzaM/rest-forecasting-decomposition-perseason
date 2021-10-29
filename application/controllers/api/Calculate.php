<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Calculate extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Ctdma_model');
    }

	public function index_get()
	{
        $this->db->empty_table('calculate_ctdma_ratio');
        $semester=$this->Ctdma_model->ctdma_semester();

           if($semester){
            $this->response([
                'status' => true,
                'message' => "done"
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data user tidak ada'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
	}
}
