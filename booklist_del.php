<?php
include "common.php";
if ($_SESSION['lv'] < 8) {
    warning("잘못된 접근입니다.", "index.php");
}

$no = $_GET['no'];
mysqli_query($conn, "DELETE FROM li_bookinfo WHERE no='$no';");
warning("책의 목록이 삭제되었습니다.", -1);