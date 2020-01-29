<?php
include "common.php";

$logid = $_POST['logid'];
$logpwd = $_POST['logpwd'];

$findid = mysqli_query($conn, "SELECT userid,userpwd,lv FROM li_member WHERE userid='$logid';")
    or die(mysqli_error($conn));
//로그인 할때 레벨을 섹션안에 넣어놓으면 계속 사용가능하니까 레벨도 불러와야함
$findidlen = mysqli_num_rows($findid);

if ($findidlen == 0) {
    warning("아이디와 비밀번호를 확인해주세요.", "login.php");
} else {
    $data = mysqli_fetch_array($findid);
    $hashpw = $data['userpwd'];


    if (password_verify($logpwd, $hashpw)) {
        $_SESSION['log'] = true;
        $_SESSION['userid'] = $data['userid'];
        $_SESSION['lv'] = $data['lv'];
        if ($_SESSION['lv'] >= 8) {
            echo "alert('관리자 아이디로 접속중입니다.')";
        }
        warning("로그인이 되었습니다.", -2);
    } else {
        warning("아이디와 비밀번호를 다시 한번 확인해주세요", "login.php");
    }
}