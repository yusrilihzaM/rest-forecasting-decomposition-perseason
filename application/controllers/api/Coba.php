<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Coba extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SeasonalIndex_model');
        $this->load->model('Ctdma_model');
    }


    public function index_get(){
        $this->db->empty_table('calculate_ctdma');
        $this->db->empty_table('calculate_ratio');
        $this->db->empty_table('seasonal_index');

        $this->Ctdma_model->ctdma_year();
        $this->Ctdma_model->ctdma_semester();
        $this->Ctdma_model->ctdma_quartal();
        $this->SeasonalIndex_model->year_season_index();
        $this->SeasonalIndex_model->semester_season_index();
        $this->SeasonalIndex_model->quartal_season_index();
        // if($user){
        //     $this->response([
        //         'status' => true,
        //         'data_user' => $user
        //     ], REST_Controller::HTTP_OK);
        // }else{
        //     $this->response([
        //         'status' => false,
        //         'message' => 'Data user tidak ada'
        //     ], REST_Controller::HTTP_NOT_FOUND);
        // }
    }
}