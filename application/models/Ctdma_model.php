<?php
class Ctdma_model extends CI_model
{

    public function ctdma_year(){
        $season=12;
        $limit_season=$season/2;
        $sql_count_data="SELECT COUNT(id_data_pengunjung) count_data FROM data_pengunjung WHERE id_season_type=1";
        $count_data=(int) $this->db->query($sql_count_data)->result_array()[0]["count_data"];

        $lower_limit=$count_data-$limit_season;

        $sql_data_tourist="SELECT * FROM data_pengunjung WHERE id_season_type=1";
        $data_tourist=$this->db->query($sql_data_tourist)->result_array();

        for ($x = 0; $x < $count_data; $x++){
            if($x<=$limit_season-1){
                // echo($data_tourist[$x]['t']."<br>");
                $data=array(
                    "id_calculate_ctdma"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "ctdma"=>null
                );
                $data_aditif=array(
                    "id_calculate_ratio"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "id_method_type"=>1,
                    "ratio"=>null
                );

                $data_multiplikatif=array(
                    "id_calculate_ratio"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "id_method_type"=>2,
                    "ratio"=>null
                );

                $this->db->insert('calculate_ratio', $data_aditif);
                $this->db->insert('calculate_ratio', $data_multiplikatif);
                $this->db->insert('calculate_ctdma', $data);
            }
            else
            if($x>=$lower_limit){
                // echo($data_tourist[$x]['t']."<br>");
                $data=array(
                    "id_calculate_ctdma"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "ctdma"=>null
                );
                $data_aditif=array(
                    "id_calculate_ratio"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "id_method_type"=>1,
                    "ratio"=>null
                );

                $data_multiplikatif=array(
                    "id_calculate_ratio"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "id_method_type"=>2,
                    "ratio"=>null
                );

                $this->db->insert('calculate_ratio', $data_aditif);
                $this->db->insert('calculate_ratio', $data_multiplikatif);
                $this->db->insert('calculate_ctdma', $data);
            }
            else
            {
                $ctdma=((int) $data_tourist[$x-$limit_season]['data_pengunjung']*0.5
                +(int) $data_tourist[$x-5]['data_pengunjung']
                +(int) $data_tourist[$x-4]['data_pengunjung']
                +(int) $data_tourist[$x-3]['data_pengunjung']
                +(int) $data_tourist[$x-2]['data_pengunjung']
                +(int) $data_tourist[$x-1]['data_pengunjung']
                +(int) $data_tourist[$x]['data_pengunjung']
                +(int) $data_tourist[$x+1]['data_pengunjung']
                +(int) $data_tourist[$x+2]['data_pengunjung']
                +(int) $data_tourist[$x+3]['data_pengunjung']
                +(int) $data_tourist[$x+4]['data_pengunjung']
                +(int) $data_tourist[$x+5]['data_pengunjung']
                +(int) $data_tourist[$x+$limit_season]['data_pengunjung']*0.5
                )/$season;
                $ratio_aditif=$data_tourist[$x]['data_pengunjung']-$ctdma;
                $ratio_multiplikatif=$data_tourist[$x]['data_pengunjung']/$ctdma;
                // echo("$ctdma <br>");
                $data=array(
                    "id_calculate_ctdma"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "ctdma"=>$ctdma
                );
                $data_aditif=array(
                    "id_calculate_ratio"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "id_method_type"=>1,
                    "ratio"=>$ratio_aditif
                );

                $data_multiplikatif=array(
                    "id_calculate_ratio"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "id_method_type"=>2,
                    "ratio"=>$ratio_multiplikatif
                );

                $this->db->insert('calculate_ratio', $data_aditif);
                $this->db->insert('calculate_ratio', $data_multiplikatif);
                $this->db->insert('calculate_ctdma', $data);
            }
        }
        return $this->db->affected_rows();
    }

    public function ctdma_semester(){
        $season=2;
        $limit_season=$season/2;
        $sql_count_data="SELECT COUNT(id_data_pengunjung) count_data FROM data_pengunjung WHERE id_season_type=2";
        $count_data=(int) $this->db->query($sql_count_data)->result_array()[0]["count_data"];

        $lower_limit=$count_data-$limit_season;

        $sql_data_tourist="SELECT * FROM data_pengunjung WHERE id_season_type=2";
        $data_tourist=$this->db->query($sql_data_tourist)->result_array();

        for ($x = 0; $x < $count_data; $x++){
            if($x<=$limit_season-1){
                // echo($data_tourist[$x]['t']."<br>");
                $data=array(
                    "id_calculate_ctdma"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "ctdma"=>null
                );
                $this->db->insert('calculate_ctdma', $data);
            }else
            if($x>=$lower_limit){
                // echo($data_tourist[$x]['t']."<br>");
                $data=array(
                    "id_calculate_ctdma"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "ctdma"=>null
                );

                $this->db->insert('calculate_ctdma', $data);
            }
            else
            {
                $ctdma=((int) $data_tourist[$x-$limit_season]['data_pengunjung']*0.5
                +(int) $data_tourist[$x]['data_pengunjung']
                +(int) $data_tourist[$x+$limit_season]['data_pengunjung']*0.5
                )/$season;
                $ratio=$data_tourist[$x]['data_pengunjung']-$ctdma;
                // echo("$ctdma <br>");
                $data=array(
                    "id_calculate_ctdma"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "ctdma"=>$ctdma
                );

                $this->db->insert('calculate_ctdma', $data);
            }
        }
        return $this->db->affected_rows();
    }

    public function ctdma_quartal(){
        $season=4;
        $limit_season=$season/2;
        $sql_count_data="SELECT COUNT(id_data_pengunjung) count_data FROM data_pengunjung WHERE id_season_type=3";
        $count_data=(int) $this->db->query($sql_count_data)->result_array()[0]["count_data"];

        $lower_limit=$count_data-$limit_season;

        $sql_data_tourist="SELECT * FROM data_pengunjung WHERE id_season_type=3";
        $data_tourist=$this->db->query($sql_data_tourist)->result_array();

        for ($x = 0; $x < $count_data; $x++){
            if($x<=$limit_season-1){
                // echo($data_tourist[$x]['t']."<br>");
                $data=array(
                    "id_calculate_ctdma"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "ctdma"=>null
                );

                $data_aditif=array(
                    "id_calculate_ratio"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "id_method_type"=>1,
                    "ratio"=>null
                );

                $data_multiplikatif=array(
                    "id_calculate_ratio"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "id_method_type"=>2,
                    "ratio"=>null
                );

                $this->db->insert('calculate_ratio', $data_aditif);
                $this->db->insert('calculate_ratio', $data_multiplikatif);
                $this->db->insert('calculate_ctdma', $data);
            }else
            if($x>=$lower_limit){
                // echo($data_tourist[$x]['t']."<br>");
                $data=array(
                    "id_calculate_ctdma"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "ctdma"=>null
                );

                $this->db->insert('calculate_ctdma', $data);
            }
            else
            {
                $ctdma=((int) $data_tourist[$x-$limit_season]['data_pengunjung']*0.5
                +(int) $data_tourist[$x-1]['data_pengunjung']
                +(int) $data_tourist[$x]['data_pengunjung']
                +(int) $data_tourist[$x+1]['data_pengunjung']
                +(int) $data_tourist[$x+$limit_season]['data_pengunjung']*0.5
                )/$season;
                $ratio=$data_tourist[$x]['data_pengunjung']-$ctdma;
                // echo("$ctdma <br>");
                $data=array(
                    "id_calculate_ctdma"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "ctdma"=>$ctdma
                );

                $this->db->insert('calculate_ctdma', $data);
            }
        }
        return $this->db->affected_rows();
    }
}