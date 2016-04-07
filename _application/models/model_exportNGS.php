<?php

class model_exportNGS extends parsing implements parsingInterface
{
	/* Получаем основные блоки, выуживая из них основную информацию 
	- ИД объявления = $get_id_pattern
	- ссылка = $get_href_pattern
	- описание = $get_description_pattern
	- сумма = $get_mony_pattern (убираем лишние пробелы)
	- кто подал = $get_who_pattern
	*/
public function parsingHREFList() {
    
    echo $this->resultPage;
    
    $pattern='|<section class="do-advert__inner js-list-item-wrap">(.*)<\/section>|Usi';
    preg_match_all($pattern, $this->resultPage, $m); 
    foreach ($m[0] as $key => $value) {
        $result2=$value;
        $get_id_pattern='|data-id="(.*)"|isU';
        $get_href_pattern='|<a itemprop="url" href="(.*)"(.*)"|isU';		
        $get_description_pattern='|<h3 class="do-advert__title">(.*<a (.*)>(.*)</a>)(.*)</h3>|isU';					
	$get_mony_pattern='|<span itemprop="price" content="(.*)">|isU'; 								
	$get_who_pattern='|<div class="do-advert__contacts-name">(.*)</div>|isU'; 
        $get_phone_pattern='|data-id=\"(.*)\"(.*)data-key=\"(.*)\"(.*)<\/a>|isU';
	preg_match($get_id_pattern, $result2, $id);
 	preg_match($get_href_pattern, $result2, $href);
 	preg_match($get_description_pattern, $result2, $description);
 	preg_match($get_mony_pattern, $result2, $mony); 
 	preg_match($get_who_pattern, $result2, $who); 
        preg_match($get_phone_pattern, $result2, $phonePartUrl); 
        $phoneUrl='http://do.ngs.ru/image/offer/phone/'.$phonePartUrl[1].'/?pkey='.$phonePartUrl[3].'&layout=vertical';
        print_r ($phoneUrl);
        $this->GetPhoneNGS($phoneUrl,$phonePartUrl[1],'http://do.ngs.ru/image/offer/phone/'.$phonePartUrl[1]);
 	$mony_txt=preg_replace("/\D/", "", $mony[1]);
	if ($mony_txt == '') { $mony_txt='NULL';}
	$array_data = array ('id'=>$id[1],'href'=>$href[1],'description'=>trim($description[3]),"who"=>$who[1],"mony"=>$mony_txt);
	$this->InsertToDB($array_data,'ngs');
        echo "<hr>";
    }
}

private function ModDate($date) {
    $array = array(1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая'
        ,6=>'июня',7=>'июля',8=>'августа',9=>'сентября',10=>'октября',11=>'ноября',12=>'декабря'
        ,100=>'час',101=>'часов',102=>'часа'
        ,200=>'дня',201=>'день',202=>'дней');
    $myDate=$date;
    $P_intmyDate='|(\d+) (\S+)|';
    preg_match($P_intmyDate, $myDate, $intmyDate);
    $daymyDate=trim($intmyDate[2]);
    $key=(array_keys($array, $daymyDate));
    $ret='';
    if ($key[0] <=12) {
        $ret=date('Y-m-d', strtotime('2016-'.$key[0].'-'.$intmyDate[1]));
        $ret=$ret.date(' H:i:s');
    } 
    if ($key[0]>=100 && $key[0]<=110) {
        $date = new DateTime();
        $date->modify('-'.$intmyDate[1].' hour');
        $ret=$date->format('Y-m-d H:i:s');
    }
    if ($key[0]>=200 && $key[0]<=210) {
        $date = new DateTime();
        $date->modify('-'.$intmyDate[1].' day');
        $ret=$date->format('Y-m-d H:i:s');
    }
    return $ret;
}

/* Парсинг выбранной записи */
public function singleParsingData($id) {
//    print_r($this->resultPage);
    $P_Header='|<span class="do-advert__title-text" itemprop="name">(.*)</span>|Usi'; 				// получаем заголовок
    preg_match($P_Header, $this->resultPage, $header);
    $P_Who='|<div class="do-advert__contacts-name">(.*)</div>|Usi';																				// имя
    preg_match($P_Who, $this->resultPage, $who);
    $P_Street='|<span class="do-advert__address-text">(.*)</span>|Usi';														// адрес 
    preg_match($P_Street, $this->resultPage, $street);
    $P_Description='|<p class="do-advert__desc-text">(.*)<\/p>|Usi';  		// Описание заявки [1]
    preg_match($P_Description, $this->resultPage, $description);
    $description=preg_replace("/<br \/>/", "\r\n", $description[1]);		// меняем тэги BR на /n/r
    $P_Time_Modify='|Обновлено(.*)</nobr>|isU';						  // дата создания\модификации заявки
    preg_match($P_Time_Modify, $this->resultPage, $Time);
    $trimTime=trim($Time[1]);
    $Time_nsk=$this->ModDate($trimTime);
    $P_Phone='|data-key="(.*)"|';
    preg_match($P_Phone, $this->resultPage, $phoneCode);
    $Phone='http://do.ngs.ru/image/offer/phone/'.$id.'/?pkey='.$phoneCode[1].'&layout=vertical';
    $Phone0='http://do.ngs.ru/image/offer/phone/'.$id;
    $this->GetPhoneNGS($Phone,$id,$Phone0);
    $array_return = array ('Header'=>trim($header[1]),'Who'=>trim($who[1]),'Street'=>trim($street[1]),'Description'=>$description,'Phone'=>$Phone,'ArticleDateCreate'=>$Time_nsk,'AvitoID'=>$id);
    
    var_dump($array_return);
    }

    /* Получение телефона, по отдельному запросу. Страница авторизированная, используются КУКИ
    	INPUT $url - ссылка полученная с сайта
    	OUTPUT $result2 - телефон полученный из запроса из JSON
    */
    public function GetPhoneNGS($url,$id,$url0=null)
   	{
        $url2=$url;
       	$agent= 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36';
		$curlHeaders = array (
            'Host: do.ngs.ru',
            'Connection: keep-alive',
            'Accept: image/webp,image/*,*/*;q=0.8',
            'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36',
            'Referer: http://dom.ngs.ru/do/categories/building_construction/services/require/',
            'Accept-Encoding: gzip, deflate, sdch',
            'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,bg;q=0.2',
            'Cookie: ngs_uid=rBBMZlUNNfS1Ei9nEBHsAg==; _ym_uid=1446818433190359114; RealtyStoredSearch=1; ngs_realty_complaint_captcha=MTE1MzQwMzQ1MXwxNDQ3MTc2NTc5fDUuNDQuMTY4LjQw; _ga=GA1.2.1690829353.1432363465; _ym_isad=1; __utma=191947573.1690829353.1432363465.1456246759.1456500856.2; __utmc=191947573; __utmz=191947573.1456246759.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)'
        );
            $ch = curl_init($url2);
			curl_setopt ($ch, CURLOPT_HTTPHEADER, $curlHeaders); 
            curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt ($ch, CURLOPT_USERAGENT, $agent); 
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false); 
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, true); 
			curl_setopt ($ch,CURLOPT_ENCODING, ''); 
			curl_setopt ($ch, CURLOPT_URL,$url2); 
			$result2 .= curl_exec($ch);
            curl_close($ch);   
            $fp = fopen("$id.png",'w');
            fwrite($fp, $result2); 
            fclose($fp);
   	}


public function parsingfromSQLData($sql) {
    $query_select=$sql; 
    $selectResult=$this->get_data_real($query_select); 
    $query_upd='';
    $sqli=$this->getSelfSQLI();
    $query = $sqli->store_result();
    while ($row = $query->fetch_assoc()) {
       $this->parseURL=parent::$MainURL.$row[AvitoHREF];
       $res=$this->LoadPageHREF();
	   $array_return = $this->singleParsingData($row[AvitoID]);
    }
}
	
}
