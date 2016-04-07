<?php
  interface parsingInterface 
  {
    public function parsingHREFList(); 	                  // Получаем основные данные из полученных объявлений
    public function parsingfromSQLData($query_select);    // Парсинг полученных данных в SQL
    public function singleParsingData($id);                  // Парсинг одного выбранного элемента
  }

/* Класс ПАРСИНГА
  static $mysqliPublic;   // подключение к БД
  $parseURL;              // Полная ссылка, которую парсим (списки объявлений)
  static $MainURL;        // главная страница, полученная из полной ссылки
  $resultPage;            // результирующая страница
*/
class parsing extends Model {
    public static $mysqliPublic;
    public $parseURL;
    public $resultPage;
    public static $MainURL;

  /* Получаем ссылку и преобразуем ее в ссылку с префиксом (например, мобильная версия) */
public function getURL($url,$prefix=null) {	
    $this->parseURL = $url;
    $pattern='/(http|https):\/\/(www.|)(.*)\//Usi';
    preg_match_all($pattern, $this->parseURL, $url);
    self::$MainURL=$prefix.$url[3][0];
}

  /* Загружаем полученную страницу $this->parseURL в переменную $resultPage */
public function loadPageHREF() {
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, $this->parseURL); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // что бы локально открывалось
    // curl_setopt($ch, CURLOPT_PROXY, "62.210.188.121:80");
    $this->resultPage = curl_exec($ch); 
    curl_close($ch);
    return $this->resultPage;
}

  /*  Сохрянаем основные данные в БД
      Входные параметры:
    - data = данные массив
    - typeExport = тип объявления (ПОКА НЕ ИСПОЛЬЗУЕТСЯ)
  */
  public function insertToDB($data,$typeExport=null)
  {
    $id=$data[id];
    $href=$data[href];
    $description=$data[description];
    $mony_txt=$data[mony];
    $sql = "INSERT IGNORE INTO avitoexporp (AvitoID, TypeID, AvitoHREF, AvitoTitle, AvitoMony,DateCreate) VALUES ($id,(SELECT id FROM typerequest WHERE code='".$typeExport."'),'$href','$description',$mony_txt, now())";
    $this->query_data($sql);
  }

  /*
  Помещает объявления из промежуточной таблицы в основную базу с объявлениями, по умолчанию не опубликованные
  $typeCode - код объявления
  */
  public function Export($typeCode)
  {
    $query='SELECT  AvitoID, AvitoMony, Who, Street, CONCAT(Header,". ",CHAR(10),Description) as Description, 
    Phone, ArticleDateCreate, ExportService9 FROM avitoexporp where (ExportService9 = 0 or ExportService9 IS null) and (Phone is not null or Phone = "") order by ArticleDateCreate desc';
    $ret_query=$this->get_data_real($query);
    $sqli=$this->getSelfSQLI();
    $query = $sqli->store_result();
    while ($valueSQL = $query->fetch_assoc()) 
    {

      $query_insert=sprintf("INSERT INTO mainrequest (TypeID, Budget, NameOriginator, Location, Text, Phone, DateNo, TimeNo, Public, Mail, Compare) 
      VALUE ((SELECT id FROM typerequest WHERE code='%s'), %s, '%s', '%s', '%s', '%s', '%s', '%s', 0, '', %s)",
      $typeCode,empty($valueSQL[AvitoMony])? 'NULL':$valueSQL[AvitoMony],$valueSQL[Who],$valueSQL[Street]
      ,$valueSQL[Description],$valueSQL[Phone],date("Y-m-d",strtotime($valueSQL[ArticleDateCreate])),date("H:i:s",strtotime($valueSQL[ArticleDateCreate]))
      ,0,'',empty($valueSQL[AvitoMony])? 1:0 ); 
      $query_update_avito='UPDATE avitoexporp SET ExportService9 = 1 where AvitoID ='.$valueSQL[AvitoID];
      $this->get_data($query_insert);
      $this->get_data($query_update_avito);
      echo date("d.m.Y H:i:s").("<br>");
      print_r($query_insert);
      echo "<hr>";
    }
  }
}

?>