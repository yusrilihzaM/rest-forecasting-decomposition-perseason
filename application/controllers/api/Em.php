<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Em extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
   
        $this->load->model('ErrorMeasurement_model');
    }
    public function index_get(){
        $id_season_type = $this->get('id_season_type');
        $id_method_type = $this->get('id_method_type');
        if($id_season_type == null){
            $em = $this->ErrorMeasurement_model->get_error_measurement();
        }else{
            $em = $this->ErrorMeasurement_model->get_error_measurement($id_season_type,$id_method_type);
        }
        if($em){
            $this->response([
                'status' => true,
                'data_em' => $em
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Toursit does not exist'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }
}