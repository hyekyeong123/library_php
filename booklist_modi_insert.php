<?php
//북 리스트 수정 인서트
include "common.php";

if ($_SESSION['lv'] < 8) {
    warning("이곳은 관리자 전용 페이지입니다.", "index.php");
}

$no = $_GET['no'];
$name = $_GET['name'];
$author = $_GET['author'];
$publisher = $_GET['publisher'];
$pubdate = $_GET['pubdate'];
$kind = $_GET['kind'];
$isbn = $_GET['isbn'];
$position = $_GET['position'];
$rentable = $_GET['rentable'];

$position = $_GET['position'];
mysqli_query($conn, "UPDATE li_bookinfo SET name='$name',author='$author',publisher='$publisher',pubdate='$pubdate',kind='$kind',isbn='$isbn',position='$position',rentable='$rentable' WHERE no='$no';") or die(mysqli_error($conn));

warning("도서 정보를 수정하였습니다. 도서목록화면으로 이동합니다.", "admin_booklist.php");