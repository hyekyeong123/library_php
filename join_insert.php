<?php
//li_member 테이블
include "common.php";

//일단 변수에 저장
$userid = $_POST['userid'];
$userpwd = $_POST['userpwd'];
$userpwd = password_hash($userpwd, PASSWORD_DEFAULT, ['cost' => 10]);


$username = $_POST['username'];
$residentPost = $_POST['residentPost'];
$residentBack = $_POST['residentBack'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$joindate = date("Y-m-d");

mysqli_query($conn, "INSERT INTO li_member (userid,userpwd,username,residentPost,residentBack,phone,address,nowrent,accrent,rentable,joindate,lv) VALUES ('$userid','$userpwd','$username',$residentPost,'$residentBack',$phone,'$address',0,0,1,'$joindate',1);") or die(mysqli_error($conn));
//회원가입 정보 데이터 베이스에 넣기

echo "<script>";
echo    "alert('회원가입이 완료되었습니다. 로그인 해 주세요.');";
echo    "location.href='login.php';";
echo "</script>";
include "log.php";