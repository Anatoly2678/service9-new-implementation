<?php
class Model
{
	public static $mysqliPublic;
	/*
		Модель обычно включает методы выборки данных, это могут быть:
			> методы нативных библиотек pgsql или mysql;
			> методы библиотек, реализующих абстракицю данных. Например, методы библиотеки PEAR MDB2;
			> методы ORM;
			> методы для работы с NoSQL;
			> и др.
	*/
	public function __construct() {
		$mysqli = new mysqli(Host, User, Password, DB);
		if (mysqli_connect_errno()) { echo "Подключение невозможно: ".mysqli_connect_error(); }
		self::$mysqliPublic=$mysqli;
	}

	public function __destruct() {
		self::$mysqliPublic->close();	
   	}

  public function getSelfSQLI() {
	  return self::$mysqliPublic;
  }

	// метод вставки\обновления данных
	public function query_data($sql=null) {
 	if (!$result =self::$mysqliPublic->multi_query($sql)) { echo "Error updating record: " . self::$mysqliPublic->error."<br>"; };
 	return $result;
	}

	// метод выборки данных
	public function get_data($sql=null,$param=null) {
 	if (!$result =self::$mysqliPublic->query($sql,$param)) { echo "Error GET record: " . self::$mysqliPublic->error."<br>"; };
 	return $result;
	}

	// метод выборки данных
	public function get_data_real($sql=null) {
 	if (!$result =self::$mysqliPublic->real_query($sql)) { echo "Error GET record: " . self::$mysqliPublic->error."<br>"; };
 	return $result;
	}

	public function get_count_include_user() {
            	$UserID = $_SESSION['UserID'];
                return $result;
	}
}