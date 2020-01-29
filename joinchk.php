<?php
include "common.php";

$userid = $_GET['userid'];


if (!empty($userid)) {
	$iddata = mysqli_query($conn, "SELECT userno FROM li_member WHERE userid='$userid';");
	$idlen = mysqli_num_rows($iddata);
	echo $idlen;
} else {
	echo 'empty';
}
?>