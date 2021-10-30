<?php
class SeasonalIndex_model extends CI_model
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
}