<?php
class Controller_invoice extends Controller {
    function __construct() {
        $this->model = new Model_Invoice();
        $this->view = new View();
    }
	
    function action_index() {
        $data_step1 = $this->model->get_data_step1();	
        $data_step4_i = $this->model->get_data_step4_individual();
        $data_step4_le = $this->model->get_data_step4_legalEntity();
        $data_arr=array($data_step1,$data_step4_i,$data_step4_le);
        $this->view->generate('invoice_view.php', 'service9_template.php',$data_arr); //,'service9_template.php'
    }

}


?>