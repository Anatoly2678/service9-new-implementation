<?php
session_start();
// подключаем файлы ядра
include 'cfg/connectConfig.php';
$_GET['url']='exportavito';
if (empty($_GET['url'])) { require_once 'core/cheklogin.php'; }
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/export.php';

/*
Здесь обычно подключаются дополнительные модули, реализующие различный функционал:
	> аутентификацию
	> кеширование
	> работу с формами
	> абстракции для доступа к данным
	> ORM
	> Unit тестирование
	> Benchmarking
	> Работу с изображениями
	> Backup
	> и др.
*/
require_once 'core/route.php';
Route::start($_GET['url']); // запускаем маршрутизатор
