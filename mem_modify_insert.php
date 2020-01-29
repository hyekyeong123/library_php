<?php
include "common.php";
$userid = $_POST['userid'];
if ($userid != $_SESSION['userid']) {
    warning("누구십니까?", "http://polic.go.kr");
}
$userpwd = $_POST['userpwd'];
$phone = $_POST['phone'];
$address = $_POST['address'];

if (!empty($userpwd)) {
    //비밀번호만 수정
    $userpwd = password_hash($userpwd . PASSWORD_DEFAULT, ['cost' => 10]);
    mysqli_query($conn, "UPDATE li_member SET userpwd ='$userpwd' WHERE userid='$userid';") or die(mysqli_error($conn));
}
mysqli_query($conn, "UPDATE li_member SET phone='$phone',address='$address' WHERE userid='$userid';") or die(mysqli_error($conn));

warning("회원정보 수정이 완료되었습니다.", "index.php");