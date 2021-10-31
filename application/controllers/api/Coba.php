<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Coba extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Calculate_model');
        $this->load->model('Future_model');
    }


    public function index_get(){
        // $this->db->empty_table('calculate_ctdma');
        // $this->db->empty_table('calculate_ratio');
        // $this->db->empty_table('seasonal_index');
        // $this->db->empty_table('calculate_smoothed');
        //  $this->db->empty_table('coefficient_parameter');
        //  $this->db->empty_table('calculate_forecasting');
        // $this->Ctdma_model->ctdma_year();
        // $this->Ctdma_model->ctdma_semester();
        // $this->Ctdma_model->ctdma_quartal();
        // $this->Calculate_model->year_season_index();
        // $this->Calculate_model->semester_season_index();
        // $this->Calculate_model->quartal_season_index();
        // $coba=$this->Calculate_model->calculate_smoothed(1);
        // $coba=$this->Calculate_model->calculate_smoothed(2);
        // $coba=$this->Calculate_model->calculate_coefficient_parameter();
        // $this->Calculate_model->calculate_forecast_year(1,1);
        // $this->Calculate_model->calculate_forecast_year(2,1);
        // $this->Calculate_model->calculate_forecast_year(3,1);

        // $this->Calculate_model->calculate_forecast_year(1,2);
        // $this->Calculate_model->calculate_forecast_year(2,2);
        $coba=$this->Future_model->future_quartal(12,3,2);
        // $coba=$this->Future_model->get_coefisien_parameter(1,2);
        var_dump($coba);
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