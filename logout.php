<?
include "common.php";

unset($_SESSION['userid']);
unset($_SESSION['log']);
unset($_SESSION['lv']);

echo "<script>history.go(-2);</script>";