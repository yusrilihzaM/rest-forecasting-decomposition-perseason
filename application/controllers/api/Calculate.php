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
        $this->load->model('Calculate_model');
    }

	public function index_get()
	{
        $this->db->empty_table('calculate_ctdma');
        $this->db->empty_table('calculate_ratio');
        $this->db->empty_table('seasonal_index');
        $this->db->empty_table('calculate_smoothed');
        $this->db->empty_table('coefficient_parameter');
        $this->db->empty_table('calculate_forecasting');
        $this->db->empty_table('error_measurement');

        $this->Ctdma_model->ctdma_year();
        $this->Ctdma_model->ctdma_semester();
        $this->Ctdma_model->ctdma_quartal();

        $this->Calculate_model->year_season_index();
        $this->Calculate_model->semester_season_index();
        $this->Calculate_model->quartal_season_index();

        $this->Calculate_model->calculate_smoothed(1);
        $this->Calculate_model->calculate_smoothed(2);
        $this->Calculate_model->calculate_smoothed(3);

        $this->Calculate_model->calculate_coefficient_parameter();

        $this->Calculate_model->calculate_forecast_year(1,1);
        $this->Calculate_model->calculate_forecast_year(2,1);
        $this->Calculate_model->calculate_forecast_year(3,1);

        $this->Calculate_model->calculate_forecast_year(1,2);
        $this->Calculate_model->calculate_forecast_year(2,2);
        $this->Calculate_model->calculate_forecast_year(3,2);

        $this->Calculate_model->calculate_error_measurement(1,1);
        $this->Calculate_model->calculate_error_measurement(2,1);
        $this->Calculate_model->calculate_error_measurement(3,1);

        $this->Calculate_model->calculate_error_measurement(1,2);
        $this->Calculate_model->calculate_error_measurement(2,2);
        $this->Calculate_model->calculate_error_measurement(3,2);

	}
}
