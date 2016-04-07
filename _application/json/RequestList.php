<?php
require_once '../core/model.php';
require_once '../models/model_test.php';
require_once '../cfg/connectConfig.php';
$model = new Model_test();
switch ($_GET['listMethod']) {
	case 'all':
		$where = '';
	break;
	case 'public':
		$where = 'AND m.Public=1 ';
	break;
	case 'favorites':
		$where = 'AND m.Public=1 AND f.FavoriteFlag=1 ';
	break;
	default:
		# code...
		break;
}
$data = $model->get_data($where);
echo ($data);
?>