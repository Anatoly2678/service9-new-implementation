<?php Model::get_count_include_user(); ?>
<div class="mainmenu" style="display:none;padding-right:3%">
<!-- <a href="../Public/mainPage.php" class="BtnMenu">главная</a>  -->
<?php 
/* Если не админ, то получаем тарифы и отображаем в зависимости ОТ*/
if ($_SESSION['AdminFlag'] != '1')
{
	$tarif_arr=explode (';',$_SESSION['TarifID']);
	foreach ($tarif_arr as $value) {
		switch ($value) {
			case 1: /* Сборка ТЕСТ */
				echo '<a href="../Public/Sborka" class="BtnMenu TabRequest" id="TabRequest">Сборка (Test)</a>';
			break;				
			case 3: /* Сборка */
				echo '<a href="../Public/Sborka" class="BtnMenu TabRequest" id="TabRequest">Сборка</a>';
    		break;
			case 6: /* Партнер ТЕСТ */
				echo '<a href="../Public/PartnerLite" class="BtnMenu TabRequest" id="TabRequest">Партнер (Test)</a>';
			break;
		}
	}
}

/* Если админ, то все показываем*/
if ($_SESSION['AdminFlag'] == '1')
{
	echo '<a href="../Public/Sborka" class="BtnMenu TabRequest" id="TabRequest">Сборка</a>';
	echo '<a href="../Public/PartnerLite" class="BtnMenu TabRequest" id="TabRequest">Партнер (Test)</a>';
	echo '<a href="../Public/Record.php" class="BtnMenu TabRequest" id="TabRequest" style="display:none">Партнер</a>'; /* ПАРТНЕР пока срыто*/
}
?>

<!-- <a href="../Personal" class="BtnMenu TabRequest" id="TabRequest">Профиль</a> -->
<?php echo '<a href="/Users" class="BtnMenu">Пользователи</a>';  ?>
<?php echo '<a href="/Invoice" class="BtnMenu">Счет</a>';  ?>
<?php echo '<a href="/Test" class="BtnMenu">Заявки ТЕСТ</a>';  ?>
<?php if ($_SESSION['login']) { echo '<a href="../Public/clssession.php" class="BtnMenu">выход</a>'; } ?>
<?php if (empty($_SESSION['login'])) { '<a href="../Public/main.php" class="BtnMenu">вход</a>'; } ?>
<?php if ($_SESSION['EndPeriod']) { $enddata=" Ваш период заканчивается: ".$_SESSION['EndPeriod']; } else { $enddata=""; } ?>
<img src="_images/calendar.png" class="tmp-img-calendar" alt="" title="<?php echo ("Пользователь: ".$_SESSION['UserName']." Ваш IP: ".$_SERVER['REMOTE_ADDR'].$enddata)?>"/>
</div>