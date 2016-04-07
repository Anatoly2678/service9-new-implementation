<?php

class Controller_exportNGS extends Controller
{
		function __construct()
	{
		$this->model = new model_exportNGS();
	}
	
	function action_index()
	{
        $this->model->GetPhoneNGS('http://do.ngs.ru/image/offer/phone/1881886123/?pkey=c47d128a13c89b851e2e727d36e2cd14.1456519093&layout=vertical',"yyy0");
            
		$this->model->GetURL('http://dom.ngs.ru/do/categories/building_construction/services/require/');
		$this->model->LoadPageHREF();
		$this->model->parsingHREFList();
		$this->model->parsingfromSQLData('SELECT AvitoID,AvitoHREF FROM avitoexporp where Header is null and TypeID=5 order by AvitoID desc LIMIT 5'); // limit 30  and AvitoID=1880733153
        die();
		$this->model->Export('ngs');
	}

}


?>