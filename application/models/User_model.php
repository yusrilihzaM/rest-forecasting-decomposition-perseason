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
    public function delete_user($id){

        $this->db->where('id_user', $id);
        $this->db->delete('user');
        return $this->db->affected_rows();
        
    }

    public function post_user($data){
        $this->db->insert('user', $data);
        return $this->db->affected_rows();
    } 

    public function put_user($data, $id){

        $this->db->update('user', $data, ['id_user'=>$id]);
        return $this->db->affected_rows();
    }

}