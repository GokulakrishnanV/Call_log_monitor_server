<?php

class SuperUserHome_model extends CI_Model
{
    //Retreive all call logs from database
    function retreive_call_logs()
    {
        $query = $this->db->query("SELECT * FROM user_data;");
        return $query;
    }
}

?>