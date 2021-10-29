<?php
class Ctdma_model extends CI_model
{
    public function ctdma_semester(){
        $season=6;
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
                +(int) $data_tourist[$x-2]['data_pengunjung']
                +(int) $data_tourist[$x-1]['data_pengunjung']
                +(int) $data_tourist[$x]['data_pengunjung']
                +(int) $data_tourist[$x+1]['data_pengunjung']
                +(int) $data_tourist[$x+2]['data_pengunjung']
                +(int) $data_tourist[$x+3]['data_pengunjung']*0.5
                )/$season;
                // echo("$ctdma <br>");
                $data=array(
                    "id_calculate_ctdma"=>null,
                    "id_data_pengunjung"=>$data_tourist[$x]['id_data_pengunjung'],
                    "ctdma"=>$ctdma
                );

                $this->db->insert('calculate_ctdma', $data);
            }
        }
    }
   
}