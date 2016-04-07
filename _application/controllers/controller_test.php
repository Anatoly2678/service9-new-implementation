<?php

class Controller_test extends Controller
{
		function __construct()
	{
		$this->model = new model_test();
		 $this->view = new View();
	}
	
	function action_index()
	{
            $this->model->get_data();
            $this->view->generate('temp_url.php', 'service9_template.php');
	}

}


?>