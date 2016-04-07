<?php

class model_exportavito extends parsing implements parsingInterface
{
	/* Получаем основные блоки, выуживая из них основную информацию 
	- ИД объявления = $get_id_pattern
	- ссылка = $get_href_pattern
	- описание = $get_description_pattern
	- сумма = $get_mony_pattern (убираем лишние пробелы)
	- кто подал = $get_who_pattern
	*/
public function parsingHREFList() {
$pattern='|<div class="item item_table clearfix js-catalog-item-enum c-b-[0-9]".*>(.*)div class="description"(.*)<div class="date c-2">(.*)</div>|Usi';
	preg_match_all($pattern, $this->resultPage, $m); 
		foreach ($m[0] as $key => $value) 
		{
			$result2=$value;
			$get_id_pattern='|id="i(.*)"\s|isU';														
 			$get_href_pattern='|<div class="description"> (.*) href="(.*)"|isU';		
 			$get_description_pattern='|div class="description"(.*)title="(.*)"|isU';					
 			$get_mony_pattern='|<div class="about">(.*)руб|isU'; 								
			$get_who_pattern='|<div class="data">(.*)<div|isU'; 		
			preg_match($get_id_pattern, $result2, $id);
 			preg_match($get_href_pattern, $result2, $href);
 			preg_match($get_description_pattern, $result2, $description);
 			preg_match($get_mony_pattern, $result2, $mony); 
 			preg_match($get_who_pattern, $result2, $who); 
 			$mony_txt=preg_replace("/\D/", "", $mony[1]);
			if ($mony_txt == '') { $mony_txt='NULL';}
			$array_data = array ('id'=>$id[1],'href'=>$href[2],'description'=>$description[2],"who"=>$who[1],"mony"=>$mony_txt);
  			$this->InsertToDB($array_data,'avito');
		}
  }

    /* Парсинг выбранной записи */
    public function singleParsingData($id)
    {
			$P_Header='|<header class="single-item-header b-with-padding">(.*)<\/header>|Usi'; 				// получаем заголовок
			preg_match($P_Header, $this->resultPage, $header);
			$P_Who='|<div class="person-name">(.*)<\/div>|Usi';																				// имя
			preg_match($P_Who, $this->resultPage, $who);
			$P_Who2='|<div class="person-name person-contact-name">(.*)<\/div>|Usi';									// имя2
			preg_match($P_Who2, $this->resultPage, $who2);
			$P_Street='|<span class="avito-address-text">(.*)<\/span>|Usi';														// адрес 
			preg_match($P_Street, $this->resultPage, $street);
			$P_Street2='|<span class="info-text user-address-text">(.*)<\/span>|Usi';               	// адрес 
			preg_match($P_Street2, $this->resultPage, $street2);
			$P_Description='|<div class="description-preview-wrapper">\W{1,10}<p>(.*)<\/p>|Usi';  		// Описание заявки
			preg_match($P_Description, $this->resultPage, $description);
			$P_Url_Phone='|div class="person-actions">(.*)href="(.*)"\W{1,5}title|Usi';								// ссылка для получения телефона
			preg_match($P_Url_Phone, $this->resultPage, $UPhone);
			$P_Time_Modify='|<meta property="article:modified_time" content="(.*)">|isU';						  // дата создания\модификации заявки
			preg_match($P_Time_Modify, $this->resultPage, $Time);
 			$Phone = $this->GetPhoneAvito($UPhone[2]);
			$Phone=preg_replace("/[\s|-]/", "", $Phone);
			$street2a='';
			if ($street2[1]<>'') {$street2a=", ".$street2[1];}
			$Time_nsk= date('Y-m-d H:i:s', strtotime("+0 hours", strtotime($Time[1]))); // Преобразуем полученное чилсо и время в нормальное с учетом часового пояса
			$who2txt='';
			if ($who2[1] != '')	{$who_full=$who2[1];}
			else {$who_full=$who[1];} //'по обьявлению';
			$description=preg_replace("/<br \/>/", "\r\n", $description[1]);		// меняем тэги BR на /n/r
			$array_return = array ('Header'=>trim($header[1]),'Who'=>$who_full,'Street'=>trim($street[1].$street2a),'Description'=>$description,'Phone'=>$Phone,'ArticleDateCreate'=>$Time_nsk,'AvitoID'=>$id);
			return $array_return;
    }

    /* Получение телефона, по отдельному запросу. Страница авторизированная, используются КУКИ
    	INPUT $url - ссылка полученная с сайта
    	OUTPUT $result2 - телефон полученный из запроса из JSON
    */
    private function GetPhoneAvito($url)
   	{
   		$url2=parent::$MainURL.$url.'?async';
   		$agent= 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36';
			$curlHeaders = array (
			':host:m.avito.ru',	':method:GET',	':scheme:https',':version:HTTP/1.1','Accept:application/json, text/javascript, */*; q=0.01', 'Accept-encoding:gzip, deflate, sdch',
			'Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,bg;q=0.2',
			'Cookie:u=1x6yp0qy.1hrmo2u.et96v89csy; QllDUjVKSEpKRFJRWksyVlBERFE_fit=1442991651359; fid=SG29D4199FA42B7BCDC38365D09B708F3D890D8120; QllDUjVKSEpKRFJRWksyVlBERFE_fs=eyJiYSI6MTQ0NDAzMjAwMTYzOCwiYmMiOi0xLCJldmVudENvdW50ZXIiOjAsInB1cmNoYXNlQ291bnRlciI6MCwiZXJyb3JDb3VudGVyIjowLCJ0aW1lZEV2ZW50cyI6W119; QllDUjVKSEpKRFJRWksyVlBERFE_flp=1444032002590; _ym_uid=1448602502841367585; _mlocation=637640; dfp_group=27; sessid=fd80e2b2396bbef0d6665eaf8a7656dd.1452753185; _ym_isad=1; f=64d36f23ffab9dd7e888e7a79b7fc038e9656d293bb53cd7e9656d293bb53cd7e9656d293bb53cd7e9656d293bb53cd7e9656d293bb53cd7e9656d293bb53cd7e9656d293bb53cd7e9656d293bb53cd7e9656d293bb53cd76a57efa7bc2737e10fafbcf2130fdc0ebf7c1ac5875e0c280fafbcf2130fdc0ef411a1a0567ce57dd8c965074d8dad71e406bd5d52b435140fafbcf2130fdc0e0fafbcf2130fdc0e28f55511b08ad67d0fafbcf2130fdc0e6d31e1fd26e6b84876cc6a39a0da0bcec71b23942f93d08d818af55b9a6a6f620fafbcf2130fdc0ef147353eb0947f8cba2d34043f9315ec57e50fd3449c5207a392b45dd180f89f28d772428bba9a27; anid=480702960%3B63708db10217ce1ae4cc238666179bf8%3B1; auth=1; __utma=99926606.1649187876.1434680756.1451357810.1452753336.30; __utmb=99926606.3.10.1452753336; __utmc=99926606; __utmz=99926606.1452753336.30.18.utmcsr=m.avito.ru|utmccn=(referral)|utmcmd=referral|utmcct=/;',
			'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36',	'X-requested-with:XMLHttpRequest' );
			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_HTTPHEADER, $curlHeaders); 
			curl_setopt ($ch, CURLOPT_HEADER, TRUE); 
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt ($ch, CURLOPT_USERAGENT, $agent); 
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false); 
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, true); 
			curl_setopt ($ch,CURLOPT_ENCODING, ''); 
			curl_setopt ($ch, CURLOPT_REFERER, $url); 
			curl_setopt ($ch, CURLOPT_URL,$url2); 
			// curl_setopt($ch, CURLOPT_PROXY, "62.210.188.121:80");
			$result2 .= curl_exec($ch);
			curl_close($ch);
			preg_match('|{"phone":"(.*)"}|Uis', $result2, $result2);
			return $result2[1];        
   	}

    public function parsingfromSQLData($sql)
    {
    	$queryTZ="SET time_zone = '+06:00'";
    	$selectResult=$this->get_data_real($queryTZ);
   		$query_select=$sql; 
   		$selectResult=$this->get_data_real($query_select); 
   		$query_upd='';
   		$sqli=$this->getSelfSQLI();
   		$query = $sqli->store_result();
			while ($row = $query->fetch_assoc()) 
			{
	   		$this->parseURL=parent::$MainURL.$row[AvitoHREF];
	   		$res=$this->LoadPageHREF();
	   		$array_return = $this->singleParsingData($row[AvitoID]);
	   		$Time_nsk= date('Y-m-d H:i:s', strtotime("+3 hours", strtotime($array_return[ArticleDateCreate])));
	   		echo "<hr><h1>".$Time_nsk."</h1></hr>";
				$query_upd = sprintf("UPDATE avitoexporp SET Header = '%s',Who = '%s' ,Street = '%s' ,Description =  '%s',Phone = '%s', ArticleDateCreate='%s' WHERE AvitoID = %s; ", 
				$array_return[Header],$array_return[Who],$array_return[Street],$array_return[Description],$array_return[Phone],$Time_nsk,$array_return[AvitoID]);
      	echo date("d.m.Y H:i:s").("<br>");
      	print_r($query_upd);
      	echo ("<hr>");
     		$this->query_data($query_upd);				
			}
		}
	
}

?>