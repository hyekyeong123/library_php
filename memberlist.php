<?php
include "common.php";
include "header.php";

if ($_SESSION['lv'] < 8) {
    warning("잘못된 접근입니다.", "index.html");
}

$curpage = $_GET['page'];
if ($curpage == "") {
    $curpage = 0;
}
// 이전 버튼과 다음 버튼을 눌렸을때 보내는 url ex) "?page=" . $prev_final_no

$data = mysqli_query($conn, "SELECT userno FROM li_member ORDER by userno DESC;");
$total_len = mysqli_num_rows($data);
$total_pagelen = ceil($total_len / $onepage_postlen); //전체 페이지(네이션의) 수(전체 버튼의 갯수) = (총 게시물의 갯수/한 페이지당 보여줄 게시물의 갯수)올림

$total_blocklen = ceil($total_pagelen / $onepage_btnlen); // 전체 블록의 갯수 =(전체 페이지 네이션 갯수 / 한 페이지당 보여줄 버튼의 갯수)올림

$firstpostno = $onepage_postlen * $curpage; // 현재 페이지

$cur_blockno = floor($curpage / $onepage_btnlen); //현재 블록의 번호= 내림(현재 보고 있는 페이지 / 한 페이지당 보여줄 버튼의 갯수)

$firstbtnno = $cur_blockno * $onepage_btnlen; //첫번째로 보여줄 버튼의 넘버 = 현재 블록의 번호 * 한 블록당 보여줄 페이지 네이션의 갯수
?>
<a href="admin.php" class='btn btn-primary'>관리자 페이지로 돌아가기</a>
<div class='table-responsive'>

    <table class='table table-hover'>
        <thead class='table table-warning'>
            <tr>
                <td>번호</td>
                <td>아이디</td>
                <td>성명</td>
                <td>폰 번호</td>
                <td>주소</td>
                <td>현재 대여한 갯수</td>
                <td>총 대여 누적 갯수</td>
                <td>대여가능한지 여부</td>
                <td>가입한 날짜</td>
                <td>레벨</td>
            </tr>
        </thead>

        <tbody>
            <?php
            $data2 = mysqli_query($conn, "SELECT * FROM li_member ORDER BY userno DESC LIMIT $firstbtnno,$onepage_postlen;") or die(mysqli_error($conn));

            for ($i = 0; $i < $onepage_postlen; $i++) {
                $row = mysqli_fetch_array($data2);
                if ($row['userno'] != "") {
                    echo "<tr>";
                    echo "<td id='userno'>{$row['userno']}</td>";
                    echo "<td >{$row['userid']}</td>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['phone']}</td>";
                    echo "<td>{$row['address']}</td>";
                    echo "<td>{$row['nowrent']}</td>";
                    echo "<td>{$row['accrent']}</td>";


                    if ($row['rentable'] == 1) {
                        echo "<td class='rentable'>가능</td>";
                    } else {
                        echo "<td class='rentable'>불가능</td>";
                    }
                    echo "<td>{$row['joindate']}</td>";
                    echo "<td><select class='lvsel' data='{$row['lv']}'>";
                    for ($k = 0; $k < 9; $k++) {
                        $num = $k + 1;
                        if ($row['lv'] == $num) {
                            echo "<option selected disabled value = '$num'>$num</option>;";
                            //처음에 유저레벨의 등급을 선택해 놓음, 하지만 같은것은 선택못하게 함
                        } else {
                            echo "<option value='$num'>$num</option>;";
                        }
                    }
                    echo "</select>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
            <!----------------------------------------------------------------------------------------->
            <tr>
                <td colspan="10">
                    <nav>
                        <ul class="pagination">
                            <?php
                            $prev_disabled = "";
                            $prev_url = "";
                            if ($cur_blockno - 1 < 0) {
                                //이전 페이지가 없다면
                                $prev_disabled = "disabled";
                            } else {
                                $prev_final_no = $firstbtnno - 1;
                                $prev_url = "?page=" . $prev_final_no; //최상단에 있는 $_GET['page']와 연결됨
                            }
                            $next_disabled = "";
                            $next_url = "";
                            if ($cur_blockno >= $total_blocklen - 1) {
                                //이전 페이지가 없다면
                                $next_disabled = "disabled";
                            } else {
                                $next_first_no = $firstbtnno + $onepage_btnlen;
                                $next_url = "?page=" . $next_first_no; //최상단에 있는 $_GET['page']와 연결됨
                            }
                            ?>
                            <!--뒤로가기 버튼--------------------------------------------------------------------- -->
                            <li class="<?php echo $prev_disabled; ?>">
                                <a href="<?php echo $prev_url; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                            </li>
                            <!----------------------------------------------------------------------->
                            <!-- 
                            1. 첫번째 시작하는 버튼 번호부터 시작해서 1씩 늘어나면서 버튼을 만들되 pbtnlen개만 만든다.
                            2. 단 버튼 안에 써야할 그 숫자가 전체 페이지 갯수보다 크면 만들지 않는다.
                            3. 마침 버튼에 써야하는 숫자가 지금 보고 있는(페이지 번호+1)와 같다면 
                                그 버튼에 클래스(.active)를 추가한다.
                         -->
                            <?php
                            for ($j = 0; $j < $onepage_btnlen; $j++) {
                                $btnno = $firstbtnno + $j + 1; //우린 0부터 시작했으니까 1을 더해줘야함
                                if ($btnno <= $total_pagelen) {
                                    $active = "";
                                    if ($curpage + 1 == $btnno) {
                                        $active = "active";
                                    }
                                    $pageurl = "?page=" . ($btnno - 1); //url이니까 다시 -1을 해줘야지
                                    echo "<li class='$active'><a href='$pageurl'>$btnno</a></li>;";
                                }
                            }
                            ?>
                            <li class='<?php echo $next_disabled; ?>'>
                                <a href="<?php echo $next_url; ?>">&raquo</a>
                            </li>
                        </ul>
                    </nav>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!--멤버 등급 전환-->
<form id="levelform" action="member_insert.php" method="post">
    <input type="text" id='memno' name='memno' hidden>
    <input type="text" id='memlv' name='memlv' hidden>
    <!-- //아이디와 현재 레벨만 post 방식으로 보내면 된다 -->
</form>
<script>
    $('.lvsel').change(function() {
        if (confirm('정말로 수정하시겠습니까?')) {

            var memno = $(this).siblings("#userno").text();
            var memlv = $(this).val();

            $("#memno").attr("value", memno);
            $("#memlv").attr("value", memlv);
            $("#levelform").submit();
        } else {
            var origin = $(this).attr("data");
            $(this).children("option").removeAttr("selected");
            // 선택한 것으로 가면 안되니까 그 선택한 값을 지워야함
            $(this).children("option").eq(origin - 1).attr("selected", true);
            //-1을 한 이유는 eq는 0부터 시작하지만 origin은 1부터 시작하기 때문에 그 다음 다시 selected를 true
        }
    });
</script>