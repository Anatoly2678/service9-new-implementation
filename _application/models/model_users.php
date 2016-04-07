<?php

class Model_Users extends Model
{
	public function get_data($sql = null) {	
		$myArray = array();
       	$sql ="SELECT u.user_id as id, u.user_login, u.user_name, u.user_password, u.user_admin, u.user_comment, u.user_disabled, u.CompanyName, u.Phone, u.Email, 
       	u.FieldOfActivivty, u.user_ip, DATE_FORMAT(DATE_ADD(u.user_datareg, INTERVAL 3 HOUR),'%d.%m.%Y %H:%i') as user_datareg1,
       	u.user_datareg, u.user_datapo, u.TypeID, u.TarifID,
       	ut.TypeName tarif, GROUP_CONCAT(tt.Subject,' ') type  
       	FROM users u  
       	left JOIN usertype ut  
       	ON u.TypeID=ut.id  
       	left JOIN usersTarif t  
       	ON u.user_id=t.users_id  
       	left JOIN tarif tt  
       	ON t.tarif_id=tt.id  ".$sql." GROUP BY u.user_id";
    	if ($result =parent::$mysqliPublic->query($sql, MYSQLI_USE_RESULT)) {
				while($row = $result->fetch_array(MYSQL_ASSOC)) {
            		$myArray[] = $row;	
            	}
    			return json_encode($myArray);
		}
		if (parent::$mysqliPublic->errno) { die('Select Error (' . parent::$mysqliPublic->errno . ') ' . parent::$mysqliPublic->error); }
	}

		/* ! Процедура для обновления таблицы тарифов пользователей
			сначала удаляем, потом вставляем первый тариф, потом второй
			ОГРАНИЧЕНИЕ: берет только 2 тарифа 
		*/
	public function updateTableUsersTarif()	{
			$sql = "UPDATE users u SET u.TarifID = null WHERE u.TarifID IS NOT NULL AND u.TarifID=';'; ";
			$sql .= "INSERT IGNORE INTO usersTarif (users_id, tarif_id) (SELECT u.user_id ,substring_index(u.TarifID,';',1) First FROM users u  WHERE u.TarifID IS NOT NULL); ";
			$sql .= "INSERT IGNORE INTO usersTarif (users_id, tarif_id) (SELECT u.user_id, CASE WHEN substring_index(u.TarifID,';',1)=substring_index(substring_index(u.TarifID,';',-2),';',1) 
				THEN NULL ELSE substring_index(substring_index(u.TarifID,';',-2),';',1) END Second FROM users u WHERE u.TarifID IS NOT NULL	HAVING Second IS NOT null)";
			if (!$result =parent::$mysqliPublic->multi_query($sql))	{ 
					echo "Error updating record: " . parent::$mysqliPublic->error;
			};
	}
}