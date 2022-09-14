<?php

class Home_model extends CI_Model
{
    //Retreive user-specific call logs from database
    function retreive_call_logs()
    {
        $this->db->where('id', $this->session->userdata('id'));
        $query = $this->db->get('users');
        foreach ($query->result() as $row){
            $username = $row->user_name;
        }
        $this->db->where('user_name',$username);
        $result = $this->db->get('user_data');
        return $result;
    }
}

?>
