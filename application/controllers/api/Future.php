<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Future extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Future_model');
    }
    public function index_get(){
        $id_season_type = $this->get('id_season_type');
        $id_method_type = $this->get('id_method_type');
        if($id_season_type == null){
            $future = $this->Future_model->get_future_forecast();
        }else{
            $future = $this->Future_model->get_future_forecast($id_season_type,$id_method_type);
        }
        if($future){
            $this->response([
                'status' => true,
                'data_future' => $future
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Future does not exist'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }
    public function index_post(){

        $period= $this->post('period');
        $this->db->empty_table('forecast_future');
        $this->Future_model->future_year($period,1,1);
        $this->Future_model->future_year($period,1,2);

        $this->Future_model->future_semester($period,2,1);
        $this->Future_model->future_semester($period,2,2);

        $this->Future_model->future_quartal($period,3,1);
        $this->Future_model->future_quartal($period,3,2);
        // if($this->Tourist_model->post_tourist($data) > 0){
        //     $this->response([
        //         'status' => true,
        //         'message'=>'add new tourist successfully'
        //     ], REST_Controller::HTTP_CREATED);
        // }{
        //     // id tidak ada
        //     $this->response([
        //         'status' => false,
        //         'message' => 'Failed to add new tourist'
        //     ], REST_Controller::HTTP_BAD_REQUEST);
        // }

    }
}
