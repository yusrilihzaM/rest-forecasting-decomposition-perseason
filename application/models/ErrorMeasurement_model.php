<?php
class ErrorMeasurement_model extends CI_model
{
    public function get_error_measurement(
        $id_season_type = null,
        $id_method_type = null
        )
    {
        if ($id_season_type == null){
            return $this->db->get('error_measurement')->result_array();
        }else{
            return $this->db->get_where('error_measurement',[
                'id_season_type'=>$id_season_type,
                'id_method_type'=>$id_method_type
            ])->row_array();
        }
    }
}