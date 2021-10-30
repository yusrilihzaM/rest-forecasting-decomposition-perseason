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
        $this->load->model('SeasonalIndex_model');
    }

	public function index_get()
	{
        $this->db->empty_table('calculate_ctdma');
        $this->db->empty_table('calculate_ratio');
        $this->db->empty_table('seasonal_index');

        $this->Ctdma_model->ctdma_year();
        $this->Ctdma_model->ctdma_semester();
        $this->Ctdma_model->ctdma_quartal();
        $this->Calculate_model->year_season_index();
        $this->Calculate_model->semester_season_index();
        $this->Calculate_model->quartal_season_index();

        // if($year and $semester and $quartal){
        //     $this->response([
        //         'status' => true,
        //         'message' => "done"
        //     ], REST_Controller::HTTP_OK);
        // }else{
        //     $this->response([
        //         'status' => false,
        //         'message' => 'Data user tidak ada'
        //     ], REST_Controller::HTTP_NOT_FOUND);
        // }
	}
}
