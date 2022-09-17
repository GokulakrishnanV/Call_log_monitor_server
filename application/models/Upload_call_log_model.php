<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_call_log_model extends CI_Model
{
    //Insert the call log into the database
    function upload_call_log($data)
    {
        $this->db->where('user_name', $data['user_name']);
        $this->db->insert('user_data',$data);
        return true;
    }
}

?>