<?php
class Calculate_model extends CI_model
{
    //start calculate season index
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
     //end calculate season index


    public function insert_smoothed(
        $id_data_pengunjung,
        $method_type,
        $smoothed
    ){
        $data=array(
            "id_calculate_smoothed"=>null,
            "id_data_pengunjung"=>$id_data_pengunjung,
            "id_method_type"=>$method_type,
            "smoothed"=>$smoothed
            
        );
        $this->db->insert('calculate_smoothed', $data);
    }
    public function calculate_smoothed(
        $id_season_type
    ){
        $sql_data_tourist="SELECT * FROM data_pengunjung WHERE id_season_type=$id_season_type";
        $data_tourist=$this->db->query($sql_data_tourist)->result_array();

        foreach ($data_tourist as $data) {
            $id_season_type=$data['id_season_type'];
            $season=$data['season'];
            $season_index=(double) $this->get_season_index($id_season_type,1,$season) ["seasonal_index"];
            $data_pengunjung=$data['data_pengunjung'];
            $id_data_pengunjung=$data['id_data_pengunjung'];
            $smoothed= $data_pengunjung-$season_index;
            $this->insert_smoothed($id_data_pengunjung,1,$smoothed);
            }
        foreach ($data_tourist as $data) {
            $id_season_type=$data['id_season_type'];
            $season=$data['season'];
            $season_index=(double) $this->get_season_index($id_season_type,2,$season) ["seasonal_index"];
            $data_pengunjung=$data['data_pengunjung'];
            $id_data_pengunjung=$data['id_data_pengunjung'];
            $smoothed= $data_pengunjung/$season_index;
            $this->insert_smoothed($id_data_pengunjung,2,$smoothed);
            }
            
    }



    public function calculate_parameter_b(
        $id_season_type,
        $id_method_type
    ){
        $sql_b="SELECT
        (N * Sum_XY - Sum_X * Sum_Y)/(N * Sum_X2 - Sum_X * Sum_X) AS b
        FROM
        (SELECT 
        COUNT(*) AS N,
        SUM(smoothed) AS Sum_Y,
        SUM(CAST(t-1 AS INT)) AS Sum_X,
        SUM(CAST(t-1 AS INT) * smoothed) AS Sum_XY,
        SUM(CAST(t-1 AS INT) * CAST(t-1 AS INT)) AS Sum_X2
        FROM data_pengunjung NATURAL JOIN calculate_smoothed WHERE id_season_type=$id_season_type AND id_method_type=$id_method_type)AS data_";
        $data_b=(double) $this->db->query($sql_b)->row_array()["b"];
        return $data_b;
    }
    public function calculate_parameter_a(
        $id_season_type,
        $id_method_type
    ){
        $sql_a="SELECT
        (Sum_Y * Sum_x2 - Sum_X * Sum_XY)/(N * Sum_X2 - Sum_X * Sum_X) AS a
        FROM
        (SELECT 
        COUNT(*) AS N,
        SUM(smoothed) AS Sum_Y,
        SUM(CAST(t-1 AS INT)) AS Sum_X,
        SUM(CAST(t-1 AS INT) * smoothed) AS Sum_XY,
        SUM(CAST(t-1 AS INT) * CAST(t-1 AS INT)) AS Sum_X2
        FROM data_pengunjung NATURAL JOIN calculate_smoothed WHERE id_season_type=$id_season_type AND id_method_type=$id_method_type)AS data_
        ";
        $data_a=(double) $this->db->query($sql_a)->row_array()["a"];
        return $data_a;
    }
    public function insert_coefficient_parameter(
        $a,
        $b,
        $id_season_type,
        $id_method_type
    ){
        $data=array(
            "id_coefficient_parameter"=>null,
            "a"=>$a,
            "b"=>$b,
            "id_season_type"=>$id_season_type,
            "id_method_type"=>$id_method_type,
            
        );
        $this->db->insert('coefficient_parameter', $data);
    }
    public function calculate_coefficient_parameter(){
        for ($method_type = 0; $method_type < 2; $method_type++){
            $id_method_type=$method_type+1;
            $b=$this->calculate_parameter_b(1,$method_type+1);
            $a=$this->calculate_parameter_a(1,$method_type+1)-$b;
            $this->insert_coefficient_parameter($a,$b,1,$id_method_type);
        }

        for ($method_type = 0; $method_type < 2; $method_type++){
            $id_method_type=$method_type+1;
            $b=$this->calculate_parameter_b(2,$method_type+1);
            $a=$this->calculate_parameter_a(2,$method_type+1)-$b;
            $this->insert_coefficient_parameter($a,$b,2,$id_method_type);
        }

        for ($method_type = 0; $method_type < 2; $method_type++){
            $id_method_type=$method_type+1;
            $b=$this->calculate_parameter_b(3,$method_type+1);
            $a=$this->calculate_parameter_a(3,$method_type+1)-$b;
            $this->insert_coefficient_parameter($a,$b,3,$id_method_type);
        }
    }



    public function insert_calculate_forecast(
        $id_data_pengunjung,
        $unadjusted,
        $adjusted,
        $error,
        $mad,
        $mape,
        $id_method_type
    ){
        $data=array(
            "id_calculate_forecasting"=>null,
            "id_data_pengunjung"=>$id_data_pengunjung,
            "unadjusted"=>$unadjusted,
            "adjusted"=>$adjusted,
            "error"=>$error,
            "mad"=>$mad,
            "mape"=>$mape,
            "id_method_type"=>$id_method_type
            );
            $this->db->insert('calculate_forecasting', $data);
    }
    public function get_coefisien_parameter(
        $id_season_type,
        $id_method_type
    ){
        $sql_c="SELECT * FROM coefficient_parameter WHERE id_season_type=$id_season_type AND id_method_type=$id_method_type";
        $data=$this->db->query($sql_c)->row_array();
        return $data;
    }
    public function get_data_all(
        $id_season_type,
        $id_method_type
    ){
        $sql_data_tourist="SELECT t,
        id_data_pengunjung,
        data_pengunjung,
        season,
        `year`,
        ctdma,
        ratio,
        id_seasonal_index,
        seasonal_index,
        smoothed
        FROM data_pengunjung
        NATURAL JOIN calculate_ctdma
        NATURAL JOIN calculate_ratio
        NATURAL JOIN seasonal_index
        NATURAL JOIN calculate_smoothed
        WHERE 
        id_season_type=$id_season_type
        AND 
        id_method_type=$id_method_type
        ORDER BY t ASC";
        $data_tourist=$this->db->query($sql_data_tourist)->result_array();
        return $data_tourist;
    }



    public function calculate_forecast_year(
        $id_season_type,
        $id_method_type
    ){
        $coefisien_parameter=$this->get_coefisien_parameter(
            $id_season_type,
            $id_method_type
        );

        $a=(double)$coefisien_parameter['a'];
        $b=(double)$coefisien_parameter['b'];
        $data_tourist= $this->get_data_all($id_season_type,$id_method_type);
        foreach ($data_tourist as $data) {
            // echo($data['season']. "<br>");
            $t=$data['t'];
            $id_data_pengunjung=$data['id_data_pengunjung'];
            $data_pengunjung=$data['data_pengunjung'];
            $seasonal_index=$data['seasonal_index'];
            $unadjusted=$a+$b*$t;

            if( $id_method_type==1){
                $adjusted=$seasonal_index+$unadjusted;
            }else
            if( $id_method_type==2){
                $adjusted=$seasonal_index*$unadjusted;
            }
            
            $error=$data_pengunjung-$adjusted;
            $mad=abs($error);
            $mape=abs($error/$data_pengunjung);

            $this-> insert_calculate_forecast(
                $id_data_pengunjung,
                $unadjusted,
                $adjusted,
                $error,
                $mad,
                $mape,
                $id_method_type
            );

        }
    }


      //start calculate Measurement error

    public function calculate_error_measurement(
        $id_season_type,
        $id_method_type
    ){
        $sql_data="SELECT
        SUM(error) sum_error,
        SUM(mad) sum_mad,
        SUM(mape) sum_mape
        FROM calculate_forecasting
        NATURAL JOIN data_pengunjung
        WHERE id_season_type=$id_season_type AND id_method_type=$id_method_type";
        $data=$this->db->query($sql_data)->row_array();

        $sql_n="SELECT
        COUNT(id_data_pengunjung) n
        FROM calculate_forecasting
        NATURAL JOIN data_pengunjung
        WHERE id_season_type=$id_season_type AND id_method_type=$id_method_type";

        $n=(int)$this->db->query($sql_n)->row_array()['n'];
        $sum_error=(double)$data['sum_error'];
        $sum_mad=(double)$data['sum_mad'];
        $sum_mape=(double)$data['sum_mape'];

        $mad=1/$n*$sum_mad;
        $mape=100/$n*$sum_mape;
        $ts=$sum_error/$mad;
        $data=array(
            "id_error_measurement"=>null,
            "rsfe"=>$sum_error,
            "mad"=>$mad,
            "mape"=>$mape,
            "ts"=>$ts,
            "id_season_type"=>$id_season_type,
            "id_method_type"=>$id_method_type
            );
            $this->db->insert('error_measurement', $data);
    }
}