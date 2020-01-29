<?php
include "common.php";
include "header.php";
?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h2>로그인하기</h2>
    </div>
    <div id="panel-body">
        <form id="logform" action="login_insert.php" method="post">
            <div class="form-group">
                <label for="logid">아이디</label>
                <input id="logid" name="logid" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="logpwd">비밀번호 입력</label>
                <input id="logpwd" name="logpwd" type="password" class="form-control">
            </div>
            <div class="center-block">
                <button id="logsub" type="button" class="btn btn-warning">로그인하기</button>
                <a href="join.php" class="btn btn-warning">회원가입하러가기</a>

                <!-- <button type="button" class="btn btn-warning">아이디/비밀번호 확인</button>
				//이 기능 아직 안 만들었음 -->
            </div>
        </form>
    </div>
</div>
<script>
    $("#logsub").click(function() {
        var a1 = $("#logid").val().length;
        var a2 = $("#logpwd").val().length;
        if (!(a1 * a2 == 0)) {
            $("#logform").submit();

        } else {
            alert("다시 한번 확인해주세요");
        }
    });
    //엔터 클릭시 제출 버튼 클릭한 것처럼----------------------------------------------------------
    $("#logpwd").keydown(function(e) {
        var key = e.keyCode; //괄호 없어도 됨
        if (key == 13) {
            $("#logsub").trigger("click");
        }
    });
</script>

<?
include "footer.php";
?>