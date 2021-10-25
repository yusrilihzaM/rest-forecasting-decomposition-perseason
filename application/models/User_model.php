<?php
class User_model extends CI_model
{
    public function get_user($id = null)
    {
        if ($id == null){
            return $this->db->get('user')->result_array();
        }else{
            return $this->db->get_where('user',['id_user'=>$id])->result_array();
        }
    }

}