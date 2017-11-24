<?php

class usermodel extends CI_model {

    function get_search($searchterm, $start, $limit) {
        $query = "select * from userdata where name = '" . $searchterm['uname'] . "' || email='" . $searchterm['email'] . "' || mobile = '" . $searchterm['mobil'] . "' limit " . $start . ", " . $limit;
        $res = $this->db->query($query);
        return $res->result();
    }

    function count_search($searchterm) {
        $query = "select * from userdata where name = '" . $searchterm['uname'] . "' || email = '" . $searchterm['email'] . "' || mobile = '" . $searchterm['mobil'] . "' ";
        $res = $this->db->query($query);
        $Data = $res->result();
        return count($Data);
    }

}

?>
