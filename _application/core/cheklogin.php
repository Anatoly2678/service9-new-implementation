<?php
if (empty($_SESSION['login']) or empty($_SESSION['crc']))
{
   header('Location: ../MainPage/index.php');
}
?>