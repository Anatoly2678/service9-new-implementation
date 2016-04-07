<?php

class Controller_Main extends Controller
{
	function action_index()
	{	
		$this->view->generate('main_view.php', 'service9_template.php');
	}
}