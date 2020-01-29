<?php
include "common.php";

$bookno = $_GET['no']; //책 번호
$userno = $_GET['userno'];
$returndate = date('Y-m-d');

//반납일 기록하기
mysqli_query($conn, "UPDATE li_rent SET returndate='$returndate' WHERE userno='$userno' AND bookno='$bookno';") or die(mysqli_error($conn));

//li_bookinfo ->whorent를 1로 만들고, li_member -> nowrent-1하기

mysqli_query($conn, "UPDATE  li_bookinfo SET whorent=1 WHERE no = '$bookno';") or die(mysqli_error($conn));

mysqli_query($conn, "UPDATE  li_member SET nowrent=nowrent-1 WHERE userno = '$userno';") or die(mysqli_error($conn));





warning("반납하였습니다.", -1);
