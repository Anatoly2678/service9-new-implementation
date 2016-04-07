<?php
require_once '../core/model.php';
require_once '../models/model_users.php';
require_once '../cfg/connectConfig.php';
$model = new Model_Users();
switch ($_GET['usertype']) {
	case 'admin':
		$where = 'WHERE u.user_admin=1';
	break;
	case 'active':
		$where = 'WHERE u.user_admin=0 AND u.user_disabled=0 AND u.user_datapo>NOW()';
	break;
	case 'all':
		$where = 'WHERE u.user_admin=0';
	break;
	
	default:
		# code...
		break;
}
$data = $model->get_data($where);
echo ($data);
?>