<?php
include "common.php";
include "header.php";
?>
<!-- 
    3. 관리자 계정에서 대여하는 회원 no와 대여할 도서 no를 입력하면 해당 도서를 해당 회원에게 대여하는 대여시스템을 제작하시오.
    3.1 - 해당 도서가 이미 대여중이거나 이용제한이 있을경우 대여를 금지하도록
    3.2 - 해당 회원이 최대 동시대여수를 초과하였거나 연체자일 경우 대여 금지하도록
    3.3 - 해당 도서 대여에 성공한 경우 회원의 현재대여수, 누적 대여수 업데이트하기
    3.4. - 해당 도시 대여에 성공한 경우 도시의 누적대여수, 대여중여부 업데이트 
-->
<div class="panel panel-warning">
    <div class="panel-heading">
        <h2>대여하기</h2>
    </div>
    <div id="panel-body">
        <form id="rentform" action="admin_rent_insert.php" method="GET">
            <div class="form-group">
                <label for="userno">대여하는 회원의 no</label>
                <input id="userno" name="userno" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="no">대여할 도서 no</label>
                <input id="no" name="no" type="text" class="form-control">
            </div>
            <div class="center-block">
                <button id="rentsub" type="button" class="btn btn-warning">대여하기</button>
            </div>
        </form>
    </div>
</div>
<script>
$("#rentsub").click(function() {
    var a1 = $("#userno").val().length;
    var a2 = $("#no").val().length;
    if (!(a1 * a2 == 0)) {
        $("#rentform").submit();

    } else {
        alert("다시 한번 확인해주세요");
    }
});
</script>

<?
include "footer.php";
?>