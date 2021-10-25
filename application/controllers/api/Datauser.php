<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Datauser extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }


    public function index_get(){

        $id=$this->get('id');

        if($id == null){
            $user = $this->User_model->get_user();
        }else{
            $user = $this->User_model->get_user($id);
        }

        
        if($user){
            $this->response([
                'status' => true,
                'data_user' => $user
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data user tidak ada'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete(){

        $id=$this->delete('id');

        if($id == null){
            $this->response([
                'status' => false,
                'message' => 'ID tidak boleh kosong'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            if($this->User_model->delete_user($id)>0){
                // ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message'=>'terhapus'
                ], REST_Controller::HTTP_OK);
            }{
                // id tidak ada
                $this->response([
                    'status' => false,
                    'message' => 'ID tidak boleh kosong'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        
    }

    public function index_post(){

        $data = array(
            'email'    => $this->post('email'),
            'password'    =>$this->post('password')
        );

        if($this->User_model->post_user($data) > 0){
            $this->response([
                'status' => true,
                'message'=>'Data user berhasil disimpan'
            ], REST_Controller::HTTP_CREATED);
        }{
            // id tidak ada
            $this->response([
                'status' => false,
                'message' => 'Gagal menyimpan data user baru'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }



}