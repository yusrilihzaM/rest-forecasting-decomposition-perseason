<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class User extends REST_Controller {
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
                'message' => 'User does not exist'
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
            if($this->User_model->delete_user($id)>0){
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

    public function index_post(){

        $data = array(
            'email'    => $this->post('email'),
            'password'    =>$this->post('password')
        );

        if($this->User_model->post_user($data) > 0){
            $this->response([
                'status' => true,
                'message'=>'New user saved successfully'
            ], REST_Controller::HTTP_CREATED);
        }{
            // id tidak ada
            $this->response([
                'status' => false,
                'message' => 'Failed to save new user'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }
    public function index_put(){
        $id=$this->put('id');
        $data = array(
            'email'    => $this->put('email'),
            'password'    =>$this->put('password')
        );

        if($this->User_model->put_user($data,$id) > 0){
            $this->response([
                'status' => true,
                'message'=>'User updated successfully'
            ], REST_Controller::HTTP_CREATED);
        }{
            // id tidak ada
            $this->response([
                'status' => false,
                'message' => 'Failed to update user'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }


}