<?php
include "common.php";
include "header.php";
if ($_SESSION['lv'] < 8) {
    warning("이곳은 관리자 권한이 필요한 곳입니다.", "index.php");
}
$name = $_GET['name'];
$author = $_GET['author'];
$publisher = $_GET['publisher'];
$pubdate = $_GET['pubdate'];
$kind = $_GET['kind'];
$isbn = $_GET['isbn'];
$possession = date("Y-m-d"); //
$position = $_GET['position'];
$rentable = $_GET['rentable'];
//no, accrent, whorent.possession는 폼으로부터 받아오는 것이 아님

mysqli_query($conn, "INSERT INTO li_bookinfo (name,author,publisher,pubdate,kind,isbn,possession,position,rentable) VALUES ('$name','$author',$publisher,'$pubdate',$kind,'$isbn','$possession',$position,$rentable);") or die(mysqli_error($conn));

warning("도서 정보를 입력하였습니다. 도서목록화면으로 이동합니다.", "admin_booklist.php");