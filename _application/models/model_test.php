<?php

class Model_test extends Model {
    public function get_data($where=null) {
        $query="SELECT m.ReqNo,m.TypeID, DATE_FORMAT(m.DateNo, GET_FORMAT(date, 'EUR')) AS DateRequest,  "
                . "m.TimeNo TimeRequest, "
                . "CONCAT(LEFT(REPLACE(REPLACE(m.Text, '\r', ''), '\n', ''),75), '...') ShotTextRequest , m.Public, a.Contract, "
                . "a.UserID, f.FavoriteFlag,f.UserID FROM mainrequest m left JOIN action a ON m.ReqNo=a.ReqNo "
                . "LEFT JOIN favorites f ON m.ReqNo=f.ReqNo WHERE (a.`Delete` = 0 OR a.`Delete`IS NULL) ".$where
                . "GROUP BY m.ReqNo ORDER BY DateNo DESC, TimeNo DESC";        
       if ($result =parent::$mysqliPublic->query($query, MYSQLI_USE_RESULT)) {
            while($row = $result->fetch_array(MYSQL_ASSOC)) {
                $myArray[] = $row;	
            }
            $myArray = json_encode($myArray);
            return ($myArray);
	   }
    }
}
?>
