<?php
class Future_model extends CI_model
{
    public function get_last_data(
        $id_season_type
    ){
        $sql_last_data="SELECT 
        t,
        season,
        `year`
        FROM data_pengunjung
        WHERE 
        id_season_type=$id_season_type
        ORDER BY t DESC LIMIT 1";

        $last_data=$this->db->query($sql_last_data)->row_array();
        return $last_data;
    }

    public function insert_future(
        $season_future,
        $year_future,
        $t_future,
        $id_seasonal_index,
        $unadjusted_forecast,
        $adjusted_forecast,
        $id_season_type,
        $id_method_type
    ){
        $data=array(
            "id_forecast_future"=>null,
            "season_future"=>$season_future,
            "year_future"=>$year_future,
            "t_future"=>$t_future,
            "id_seasonal_index"=>$id_seasonal_index,
            "unadjusted_forecast"=>$unadjusted_forecast,
            "adjusted_forecast"=>$adjusted_forecast,
            "id_season_type"=>$id_season_type,
            "id_method_type"=>$id_method_type
        );

        $this->db->insert('forecast_future', $data);
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

    public function get_coefisien_parameter( 
        $id_season_type,
        $id_method_type
        ){
        $sql="SELECT a, b FROM coefficient_parameter WHERE id_season_type=$id_season_type AND id_method_type=$id_method_type";
        $data=$this->db->query($sql)->row_array();
        return $data;
    }
    public function future_year(
        $period,
        $id_season_type,
        $id_method_type
    ){
        $last_data=$this->get_last_data(1);
        $last_t=(int)$last_data['t'];
        $last_season=(int)$last_data['season'];
        $last_year=(int)$last_data['year'];

        $a=(double) $this->get_coefisien_parameter( $id_season_type,$id_method_type)['a'];
        $b=(double) $this->get_coefisien_parameter( $id_season_type,$id_method_type)['b'];

        $current_year=0;
        $current_season=0;
        if($last_season==12){
            $current_season=1;
            $current_year=$last_year+1;
        }
        else{
            $current_season= $last_season+1;
            $current_year=$last_year;
        }
        for ($x = 0; $x < $period; $x++){
            $current_t=$last_t+$x+1;
            $id_seasonal_index=(int)$this->get_season_index( $id_season_type,$id_method_type,$current_season)["id_seasonal_index"];
            $seasonal_index=(double)$this->get_season_index( $id_season_type,$id_method_type,$current_season)["seasonal_index"];
            $unadjusted_forecast=$a+$b*$current_t;
            if( $id_method_type==1){
                $adjusted_forecast=$unadjusted_forecast+$seasonal_index;
            }else
            if( $id_method_type==2){
                $adjusted_forecast=$unadjusted_forecast*$seasonal_index;
            }
            // echo("$adjusted_forecast<br>");
            $this->insert_future(
                $current_season,
                $current_year,
                $current_t,
                $id_seasonal_index,
                $unadjusted_forecast,
                $adjusted_forecast,
                $id_season_type,
                $id_method_type
            );
            $current_season= $current_season+1;
            if($current_season>12){
                $current_season=1;
                $current_year=$current_year+1;
            }
            else{
                $current_year=$current_year;
            }
        }
    }

    public function future_semester(
        $period,
        $id_season_type,
        $id_method_type
    ){
        $last_data=$this->get_last_data(1);
        $last_t=(int)$last_data['t'];
        $last_season=(int)$last_data['season'];
        $last_year=(int)$last_data['year'];

        $a=(double) $this->get_coefisien_parameter( $id_season_type,$id_method_type)['a'];
        $b=(double) $this->get_coefisien_parameter( $id_season_type,$id_method_type)['b'];

        $current_year=0;
        $current_season=0;
        if($last_season==12){
            $current_season=1;
            $current_year=$last_year+1;
        }
        else{
            $current_season= $last_season+1;
            $current_year=$last_year;
        }
        for ($x = 0; $x < $period; $x++){
            $current_t=$last_t+$x+1;
            $id_seasonal_index=(int)$this->get_season_index( $id_season_type,$id_method_type,$current_season)["id_seasonal_index"];
            $seasonal_index=(double)$this->get_season_index( $id_season_type,$id_method_type,$current_season)["seasonal_index"];
            $unadjusted_forecast=$a+$b*$current_t;
            if( $id_method_type==1){
                $adjusted_forecast=$unadjusted_forecast+$seasonal_index;
            }else
            if( $id_method_type==2){
                $adjusted_forecast=$unadjusted_forecast*$seasonal_index;
            }
            // echo("$adjusted_forecast<br>");
            $this->insert_future(
                $current_season,
                $current_year,
                $current_t,
                $id_seasonal_index,
                $unadjusted_forecast,
                $adjusted_forecast,
                $id_season_type,
                $id_method_type
            );
            $current_season= $current_season+1;
            if($current_season>2){
                $current_season=1;
                $current_year=$current_year+1;
            }
            else{
                $current_year=$current_year;
            }
        }
    }
    public function future_quartal(
        $period,
        $id_season_type,
        $id_method_type
    ){
        $last_data=$this->get_last_data(1);
        $last_t=(int)$last_data['t'];
        $last_season=(int)$last_data['season'];
        $last_year=(int)$last_data['year'];

        $a=(double) $this->get_coefisien_parameter( $id_season_type,$id_method_type)['a'];
        $b=(double) $this->get_coefisien_parameter( $id_season_type,$id_method_type)['b'];

        $current_year=0;
        $current_season=0;
        if($last_season==12){
            $current_season=1;
            $current_year=$last_year+1;
        }
        else{
            $current_season= $last_season+1;
            $current_year=$last_year;
        }
        for ($x = 0; $x < $period; $x++){
            $current_t=$last_t+$x+1;
            $id_seasonal_index=(int)$this->get_season_index( $id_season_type,$id_method_type,$current_season)["id_seasonal_index"];
            $seasonal_index=(double)$this->get_season_index( $id_season_type,$id_method_type,$current_season)["seasonal_index"];
            $unadjusted_forecast=$a+$b*$current_t;
            if( $id_method_type==1){
                $adjusted_forecast=$unadjusted_forecast+$seasonal_index;
            }else
            if( $id_method_type==2){
                $adjusted_forecast=$unadjusted_forecast*$seasonal_index;
            }
            // echo("$adjusted_forecast<br>");
            $this->insert_future(
                $current_season,
                $current_year,
                $current_t,
                $id_seasonal_index,
                $unadjusted_forecast,
                $adjusted_forecast,
                $id_season_type,
                $id_method_type
            );
            $current_season= $current_season+1;
            if($current_season>4){
                $current_season=1;
                $current_year=$current_year+1;
            }
            else{
                $current_year=$current_year;
            }
        }
    }
}