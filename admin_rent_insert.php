<?php
include "common.php";

$bookno = $_GET['no']; //책 번호
$userno = $_GET['userno'];
$rentdate = date('Y-m-d');
$returnduedate = date("Y-m-d", strtotime("+1 week"));

if (strlen($userno) == 0) {
    echo "<script>alert('존재하지 않는 유저의 번호입니다.');</script>";
}
if (strlen($no) == 0) {
    echo "<script>alert('존재하지 않는 책의 번호입니다.');<script>";
}
//일단 li_bookinfo 와 li_member의 모든 정보를 가져오기
$memberdata = mysqli_query($conn, "SELECT * FROM li_member WHERE userno='$userno'");
$memrow = mysqli_fetch_array($memberdata);

$bookdata = mysqli_query($conn, "SELECT * FROM li_bookinfo WHERE no='$bookno'");
$bookrow = mysqli_fetch_array($bookdata);

//3-1   if li_bookinfo에서 rentable이나 whorent가 0인경우 대여 금지하도록 제한
if ($memrow['rentable'] == 0 || $memrow['whorent'] == 0) {
    echo "<script>alert('현재 대여가 불가능한 책입니다.');</script>";
}
//3-2   if li_member에서 nowrent가 6이상이거나 rentable이 0인경우 대여 금지하도록
if ($bookrow['nowrent'] > 6 || $bookrow['rentable'] == 0) {
    echo "<script>alert('현재 사용자분께서는 책을 빌릴 수 없습니다.');</script>";
}

//대여 성공
mysqli_query($conn, "INSERT INTO li_rent (bookno,userno,rentdate,returnduedate) VALUES ($bookno,$userno,'$rentdate','$returnduedate');") or die(mysqli_error($conn));

//회원의 현재 대여수(nowrent), 누적 대여수(accrent) 1씩 더하기
mysqli_query($conn, "UPDATE  li_member SET nowrent=nowrent+1, accrent=accrent+1 WHERE userno = '$userno';") or die(mysqli_error($conn));

//도서의 누적 대여수(accrent) 1씩 더하기, whorent의 값을 0(대여한것임)로 바꾸기
mysqli_query($conn, "UPDATE  li_bookinfo SET accrent=accrent+1, whorent=0 WHERE no = '$bookno';") or die(mysqli_error($conn));

warning("대여하였습니다.", -1);

//whorent 