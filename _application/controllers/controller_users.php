<?php

class Controller_Users extends Controller
{
		function __construct()
	{
		$this->model = new Model_Users();
		$this->view = new View();
	}
	
	function action_index()
	{
		$this->model->updateTableUsersTarif();
		$this->view->generate('users_view.php', 'service9_template.php');
	}

}
