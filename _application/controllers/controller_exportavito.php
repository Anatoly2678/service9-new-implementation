<?php

class Controller_exportavito extends Controller
{
		function __construct()
	{
		$this->model = new model_exportAvito();
	}
	
	function action_index()
	{
		print_r ("StartExport Avito<br>");
		$this->model->GetURL('https://www.avito.ru/novosibirskaya_oblast/zaprosy_na_uslugi/remont_stroitelstvo','https://m.');
		$this->model->LoadPageHREF(); 
		$this->model->parsingHREFList(); 
		sleep(30); 
		$this->model->GetURL('https://www.avito.ru/novosibirskaya_oblast/zaprosy_na_uslugi/sad_blagoustroystvo','https://m.');
		$this->model->LoadPageHREF();
		$this->model->parsingHREFList();
		sleep(30);
		$this->model->GetURL('https://www.avito.ru/novosibirskaya_oblast/zaprosy_na_uslugi/master_na_chas','https://m.');
		$this->model->LoadPageHREF();
		$this->model->parsingHREFList();
		$this->model->parsingfromSQLData('SELECT AvitoID,AvitoHREF FROM avitoexporp where Header is null and TypeID=4 LIMIT 10'); // limit 5
		$this->model->Export('avito');

		print_r ("EndExport Avito");
	}

}


?>