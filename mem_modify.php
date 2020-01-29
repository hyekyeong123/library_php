<?php
include "common.php";
include "header.php";

if (!isset($_SESSION['log'])) {
    warning("로그인이 필요합니다.", "login.php");
}
echo "<h1>{$_SESSION['userid']}</h1>";
$memdata = mysqli_query($conn, "SELECT * FROM li_member WHERE userid='{$_SESSION['userid']}';") or die(mysqli_error($conn));
$memrow = mysqli_fetch_assoc($memdata);
echo "<script>alert('{$memrow['userid']}');</script>";
?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h2>나의 정보 수정하기</h2>
    </div>
    <div class="panel-body">
        <form action="mem_modify_insert.php" name="form1" id="form1" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="userid">나의 아이디(수정 불가)</label>
                <input name="userid" type="text" class="form-control" value="<?php echo $memrow['userid']; ?>" readonly>
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
                <label for="phone">전화번호</label>
                <input id="phone" name="phone" type="number" class="form-control" placeholder="-없이 숫자만 입력해주세요"
                    value="<?php echo $memrow['phone'] ?>">
            </div>
            <div class="form-group">
                <label for="address">주소</label>
                <input id="address" name="address" type="text" class="form-control" placeholder="주소를 입력해주세요"
                    value="<?php echo $memrow['address'] ?>">
            </div>
            <button type=" button" class="btn btn-warning" id="submit1">수정하기</button>
            <button type="reset" class="btn btn-warning">다시 작성하기</button>
        </form>
    </div>
</div>
<!------------------------------------------------------------------------------------------->
<script>
$(document).ready(function() {
    $("#submit1").click(function() {
        if ($("#userpwd").val() == 요$("#pwdcheck").val()) {
            $("#form1").submit();
        } else {
            alert("비밀번호를 확인해주세요");
        }
    });
});
</script>
<?php
include "footer.php";
?>