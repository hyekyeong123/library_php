<?php
include "common.php";
include "header.php";

if ($_SESSION['lv'] < 8) {
    warning("잘못된 접근입니다.", 'index.php');
}
?>
<h2>관리자 페이지</h2>
<div class="btn-group text-center center-block">
    <a href="memberlist.php" class="btn btn-info form-control ">회원관리</a>
    <a href="bookinput.php" class="btn btn-success form-control">도서정보 입력</a>
    <a href="admin_booklist.php" class="btn btn-primary form-control">도서 정보 목록, 수정, 삭제</a>
    <a href="admin_rent.php" class="btn btn-warning form-control">도서 대여</a>
    <a href="admin_return.php" class="btn btn-danger form-control">도서 반납</a>
</div>
<style>
.form-control {
    height: 70px;
    line-height: 70px;
    font-size: 2rem;
}
</style>