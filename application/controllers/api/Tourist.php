<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Tourist extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tourist_model');
    }


    public function index_get(){

        $id=$this->get('id');

        if($id == null){
            $tourist = $this->Tourist_model->get_tourist();
        }else{
            $tourist = $this->Tourist_model->get_tourist($id);
        }

        
        if($tourist){
            $this->response([
                'status' => true,
                'data_tourist' => $tourist
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Toursit does not exist'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete(){

        $id=$this->delete('id');

        if($id == null){
            $this->response([
                'status' => false,
                'message' => 'ID cannot be empty'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            if($this->Tourist_model->delete_tourist($id)>0){
                // ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message'=>'deleted'
                ], REST_Controller::HTTP_OK);
            }{
                // id tidak ada
                $this->response([
                    'status' => false,
                    'message' => 'ID cannot be empty'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        
    }

    public function index_put(){
        $id=$this->put('id_data_pengunjung');
        $data = array(
            'id_data_pengunjung'=> $this->put('id_data_pengunjung'),
            'data_pengunjung'    => $this->put('data_pengunjung'),
            'season'    => $this->put('season'),
            'year'    => $this->put('year'),
            'id_season_type'    => $this->put('id_season_type'),
            't'    => $this->put('t'),
        );

        if($this->Tourist_model->put_tourist($data,$id) > 0){
            $this->response([
                'status' => true,
                'message'=>'tourist updated successfully'
            ], REST_Controller::HTTP_CREATED);
        }{
            // id tidak ada
            $this->response([
                'status' => false,
                'message' => 'Failed to update tourist'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }


}