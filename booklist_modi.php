<?php
include "common.php";
include "header.php";

if ($_SESSION['lv'] < 8) {
    warning("잘못된 접근입니다.", "index.php");
}

$no = $_GET['no'];

$data = mysqli_query($conn, "SELECT * from li_bookinfo WHERE no='$no';") or die(mysqli_error($conn));

$row  = mysqli_fetch_array($data);
//혹시 accrent가 널값이라서 못 가져오나?

?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h2>도서 정보 수정하기</h2>
        <a href="admin.php" class='btn btn-info'>관리자 페이지로 다시 돌아가기</a>
    </div>
    <div class="panel-body">
        <form action="booklist_modi_insert.php" name="inputform" id="inputform" method="get" class="form-horizontal">

            <input id="no" name="no" type="hidden" class="form-control" value="<?php echo $row['no'] ?>">

            <div class="form-group">
                <label for="name">도서 제목</label>
                <input id="name" name="name" type="text" class="form-control" value="<?php echo $row['name'] ?>" re
                    quired>
            </div>
            <div class=" form-group">
                <label for="author">저자</label>
                <input id="author" name="author" type="text" class="form-control" value="<?php echo $row['author'] ?>">
            </div>
            <div class=" form-group">
                <label for="publisher">출판사(숫자)</label>
                <input id="publisher" name="publisher" type="number" class="form-control"
                    value="<?php echo $row['publisher'] ?>">
            </div>
            <div class="form-group">
                <label for="pubdate">출판일</label>
                <input id="pubdate" name="pubdate" type="date" class="form-control"
                    value="<?php echo $row['pubdate'] ?>">
            </div>
            <div class=" form-group">
                <label for="kind">분류(숫자)</label>
                <input id="kind" name="kind" type="number" class="form-control" value="<?php echo $row['kind'] ?>">
            </div>
            <div class=" form-group">
                <label for="isbn">ISBN</label>
                <input id="isbn" name="isbn" type="text" class="form-control" value="<?php echo $row['isbn'] ?>">
            </div>
            <!--누적대여수(accrent)는 여기서 입력할 필요가 없음-->
            <div class=" form-group">
                <label for="position">책장 번호</label>
                <input id="position" name="position" type="number" class="form-control"
                    value="<?php echo $row['position'] ?>">
            </div>
            <div class="form-group">
                <label>이용가능</label>
                <input name="rentable" type="radio" class="form-control rentable" value='1' $checked>

                <label>이용불가능</label>
                <input name="rentable" type="radio" class="form-control rentable" value='0'>
            </div>
            <!--대여중여부(whorent) 또한 여기서 입력할 필요가 없음-->
            <button type="button" class="btn btn-warning" id="bookmodi_sub">도서 정보 수정하기</button>
            <button type="reset" class="btn btn-warning">초기화</button>
        </form>
    </div>
</div>
<!---------------------------------------------------------------------------------->
<script>
$(document).ready(function() {
    $("#bookmodi_sub").click(function() {
        var a1 = $("#name").val().length;
        var a2 = $("#author").val().length;
        var a3 = $("#publisher").val().length;
        var a4 = $("#pubdate").val().length;
        var a5 = $("#kind").val().length;
        var a6 = $("#isbn").val().length;
        var a7 = $("#position").val().length;
        var a8 = $(".rentable").val().length;
        // alert("var_dump[a1, a2, a3, a4, a5, a6, a7, a8, a9]");

        var aaa = a1 * a2 * a3 * a4 * a5 * a6 * a7 * a8;
        if (aaa == 0) {
            alert("모든 값을 입력해주세요.");
        } else {
            $("#inputform").submit();

        }
    });
});
</script>