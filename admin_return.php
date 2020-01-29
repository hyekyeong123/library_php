<!--도서 반납 시스템-->
<?php
include "common.php";
include "header.php";
?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h2>반납하기</h2>
    </div>
    <div id="panel-body">
        <form id="rentform" action="admin_return_insert.php" method="GET">
            <div class="form-group">
                <label for="userno">반납는 회원의 no</label>
                <input id="userno" name="userno" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="no">반납할 도서 no</label>
                <input id="no" name="no" type="text" class="form-control">
            </div>
            <div class="center-block">
                <button id="rentsub" type="button" class="btn btn-warning">반납하기</button>
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