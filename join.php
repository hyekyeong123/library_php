<?php
include "common.php";
include "header.php";
?>


<div class="panel panel-warning">
    <div class="panel-heading">
        <h2>회원가입하기</h2>
    </div>
    <div class="panel-body">

        <!--
			부트스트랩은 사이드 콘텐츠를 감싸고 그리드 시스템을 만들 콘테이너 요소가 필요함 단 padding등의 문제로 중첩 불가
			또는 container-fluid 사용가능(뷰포트 전체폭까지 늘어남)
		-->
        <form action="join_insert.php" name="join" id="join" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="userid">아이디</label>
                <input id="userid" name="userid" type="text" class="form-control" placeholder="아이디를 입력하세요">
                <span class="label label-danger" id="chkid"></span>
            </div>
            <div class="form-group">
                <label for="userpwd">비밀번호</label>
                <input id="userpwd" name="userpwd" type="password" class="form-control" placeholder="비밀번호를 입력하세요">
            </div>
            <div class="form-group">
                <label for="pwdcheck">비밀번호 확인</label>
                <input id="pwdcheck" name="pwdCheck" type="password" class="form-control"
                    placeholder="다시 한번 비밀번호를 입력하세요">
            </div>
            <div class="form-group">
                <label for="username">성명</label>
                <input id="username" name="username" type="text" class="form-control" placeholder="성명을 입력하세요">
            </div>
            <div class="form-group">
                <label for="residentPost">주민번호 앞자리</label>
                <input id="residentPost" name="residentPost" type="number" class="form-control"
                    placeholder="-없이 숫자만 입력해주세요">
            </div>
            <div class="form-group">
                <label for="residentBack">주민번호 뒷자리</label>
                <input id="residentBack" name="residentBack" type="password" class="form-control"
                    placeholder="-없이 숫자만 입력해주세요">
            </div>

            <div class="form-group">
                <label for="phone">전화번호</label>
                <input id="phone" name="phone" type="number" class="form-control" placeholder="-없이 숫자만 입력해주세요">
            </div>
            <div class="form-group">
                <label for="address">주소</label>
                <input id="address" name="address" type="text" class="form-control" placeholder="주소를 입력해주세요">
            </div>
            <button type="button" class="btn btn-warning" id="join_submit">회원가입하기</button>
            <button type="reset" class="btn btn-warning">다시 작성하기</button>
        </form>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------------------->
<script>
$(document).ready(function() {
    //같은 주민번호가 있으면 가입 못하게 하는 기능
    var idchk = false;
    var residentchk = false;


    // 왜 안될까....
    $("#userid").keyup(function() {
        var key = $(this).val();
        $.ajax({
            method: 'get',
            url: 'joinchk.php',
            data: 'userid=' + key,
            dataType: 'html',
            success: function(result) {
                if (result == 0) {
                    //중복된 아이디의 갯수
                    $("#chkid").text("사용할 수 있는 아이디");
                    $("#chkid").removeClass('label-danger');
                    $("#chkid").addClass('label-success'); //초록색깔로
                    idchk = true;
                } else if (result == 1) {
                    $('#chkid').text('사용할 수 없는 아이디');
                    $("#chkid").removeClass('label-success');
                    $("#chkid").addClass('label-danger');
                    idchk = false;
                } else if (result == 'empty') {
                    $('#chkid').text('아이디를 입력하세요');
                    $("#chkid").removeClass('label-success');
                    $("#chkid").addClass('label-danger');
                    idchk = false;
                }
            }
        });
    });

    $("#join_submit").click(function() {
        var resPost = $("#residentPost").val();
        var resBack = $("#residentBack").val();
        $.ajax({
            method: 'post',
            url: "joinchk.php",
            data: {
                'residentPost =': +resPost,
                'residentBack =': +resBack,
            },
            dataType: 'html',
            success: function(res) {
                if (res == 1) {
                    residentchk = true;
                }
            }
        })

        //빈 값이 없는지 확인

        var a1 = $("#userid").val().length;
        var a2 = $("#userpwd").val().length;
        var a3 = $("#pwdcheck").val().length;
        var a4 = $("#username").val().length;
        var a5 = $("#residentPost").val().length;
        var a6 = $("#residentBack").val().length;
        var a7 = $("#phone").val().length;
        var a8 = $("#address").val().length;
        var result = a1 * a2 * a3 * a4 * a5 * a6 * a7 * a8;
        if (result === 0) {
            //어느 한 가지이상을 입력안했다는 뜻
            alert("값을 모두 입력해주세요.");
        } else {
            if ($("#userpwd").val() === $("#pwdcheck").val()) {
                // if (idchk == true) {
                alert("회원가입이 완료되었습니다. ")
                $("#join").submit();
                // } else {
                // 	alert("아이디와 주민번호 중복체크를 확인해주세요.");
                // }
            } else {
                alert("비밀번호를 확인해주세요.");
            }
        }

    });
});
</script>



<?php
include "footer.php";
?>