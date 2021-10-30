<?php
class Calculate_model extends CI_model
{
    public function calculate_season_index(
        $idMethodType,
        $idSeasonType,
        $season
        ){
        $sql_csi="SELECT AVG(ratio) ratio FROM calculate_ratio
        NATURAL JOIN data_pengunjung
        WHERE id_method_type=$idMethodType AND id_season_type=$idSeasonType AND season=$season";
        $csi=(Double) $this->db->query($sql_csi)->row_array() ["ratio"];
        $data=array(
            "id_seasonal_index"=>null,
            "id_season_type"=>$idSeasonType,
            "seasonal_index"=>$csi,
            "season"=>$season,
            "id_method_type"=>$idMethodType
        );
        $this->db->insert('seasonal_index', $data);
    }

    public function year_season_index(){
        $idMethodType=0;
        $season=0;
        $idSeasonType=1;
        for ($method_type = 0; $method_type < 2; $method_type++){
            $idMethodType=$method_type+1;
            for ($year = 0; $year < 12; $year++){
                $season=$year+1;
                $this->calculate_season_index(
                    $idMethodType,
                    $idSeasonType,
                    $season
                );
            }
        }
    }

    public function semester_season_index(){
        $idMethodType=0;
        $season=0;
        $idSeasonType=2;
        for ($method_type = 0; $method_type < 2; $method_type++){
            $idMethodType=$method_type+1;
            for ($year = 0; $year < 2; $year++){
                $season=$year+1;
                $this->calculate_season_index(
                    $idMethodType,
                    $idSeasonType,
                    $season
                );
            }
        }
    }

    public function quartal_season_index(){
        $idMethodType=0;
        $season=0;
        $idSeasonType=3;
        for ($method_type = 0; $method_type < 2; $method_type++){
            $idMethodType=$method_type+1;
            for ($year = 0; $year < 4; $year++){
                $season=$year+1;
                $this->calculate_season_index(
                    $idMethodType,
                    $idSeasonType,
                    $season
                );
            }
        }
    }

    public function get_season_index(
        $id_season_type,
        $id_method_type,
        $season
    ){
        $sql_si="SELECT id_seasonal_index, seasonal_index FROM seasonal_index WHERE id_season_type=$id_season_type AND id_method_type=$id_method_type AND season=$season";
        $data_si=$this->db->query($sql_si)->row_array();
        return $data_si;
    }

    public function insert_calculate_forecast(
        $id_data_pengunjung,
        $id_seasonal_index,
        $smoothed,
        $unadjusted,
        $adjusted,
        $ierrordMethodType,
        $mad,
        $mape,
        $id_method_type
    ){
        $data=array(
            "id_calculate_forecasting"=>null,
            "id_data_pengunjung"=>$id_data_pengunjung,
            "id_seasonal_index"=>$id_seasonal_index,
            "smoothed"=>$smoothed,
            "unadjusted"=>$unadjusted,
            "adjusted"=>$adjusted,
            "error"=>$ierrordMethodType,
            "mad"=>$mad,
            "mape"=>$mape,
            "id_method_type"=>$id_method_type
            );
            $this->db->insert('calculate_forecasting', $data);
    }

    public function insert_smoothed(
        $id_data_pengunjung,
        $method_type,
        $smoothed
    ){
        $data=array(
            "id_calculate_smoothed"=>null,
            "id_data_pengunjung"=>$id_data_pengunjung,
            "id_method_type"=>$method_type+1,
            "smoothed"=>$smoothed
            
        );
        $this->db->insert('calculate_smoothed', $data);
    }
    public function calculate_smoothed(
        $id_season_type
    ){
        $sql_data_tourist="SELECT * FROM data_pengunjung WHERE id_season_type=$id_season_type";
        $data_tourist=$this->db->query($sql_data_tourist)->result_array();

        //year
        for ($method_type = 0; $method_type < 2; $method_type++){
            foreach ($data_tourist as $data) {
              
                $id_season_type=$data['id_season_type'];
                $season=$data['season'];
                $season_index=(double) $this->get_season_index($id_season_type,$method_type+1,$season) ["seasonal_index"];
                $data_pengunjung=$data['data_pengunjung'];
                $id_data_pengunjung=$data['id_data_pengunjung'];
                $smoothed= $data_pengunjung-$season_index;
                $this->insert_smoothed($id_data_pengunjung,$method_type,$smoothed);
                // echo($id_data_pengunjung. "<br>");
            }
        }

    }
    public function calculate_forecast_year(){
        $sql_data_tourist="SELECT * FROM data_pengunjung WHERE id_season_type=1";
        $data_tourist=$this->db->query($sql_data_tourist)->result_array();

        foreach ($data_tourist as $data) {
            // echo($data['season']. "<br>");
            $id_season_type=$data['id_season_type'];
            $season=$data['season'];
            if ($data['season']==1) {
                $season_index=(double) $this->get_season_index($id_season_type,1,$season) ["seasonal_index"];
                $data_pengunjung=$data['data_pengunjung'];

                $id_data_pengunjung=$data['id_data_pengunjung'];
                $id_season_index=(int) $this->get_season_index($id_season_type,1,$season) ["id_seasonal_index"];
                $smoothed= $data_pengunjung-$season_index;
            }
        }
    }
}