<!--관리자 계정으로 도서 정보 리스트를 조회,입력,수정하는 화면-->
<?php
include "common.php";
include "header.php";

$curpage = $_GET['page'];
if ($curpage == "") {
    $curpage = 0;
}
// 이전 버튼과 다음 버튼을 눌렸을때 보내는 url ex) "?page=" . $prev_final_no

$data = mysqli_query($conn, "SELECT no FROM li_bookinfo ORDER by no DESC;");
$total_len = mysqli_num_rows($data);
$total_pagelen = ceil($total_len / $onepage_postlen); //전체 페이지(네이션의) 수(전체 버튼의 갯수) = (총 게시물의 갯수/한 페이지당 보여줄 게시물의 갯수)올림

$total_blocklen = ceil($total_pagelen / $onepage_btnlen); // 전체 블록의 갯수 =(전체 페이지 네이션 갯수 / 한 페이지당 보여줄 버튼의 갯수)올림

$firstpostno = $onepage_postlen * $curpage; // 현재 페이지

$cur_blockno = floor($curpage / $onepage_btnlen); //현재 블록의 번호= 내림(현재 보고 있는 페이지 / 한 페이지당 보여줄 버튼의 갯수)

$firstbtnno = $cur_blockno * $onepage_btnlen; //첫번째로 보여줄 버튼의 넘버 = 현재 블록의 번호 * 한 블록당 보여줄 페이지 네이션의 갯수
?>
<!-- //만약 관리자라면
//관리자페이지로 이동하기 버튼 만들기, 수정버튼 만들기, 삭제 버튼 만들기 -->
<a href='bookinput.php' class='btb btn-primary form-control'>도서 입력화면으로 이동하기</a>
<div class='table-responsive'>
    <table class='table table-hover'>
        <thead class='table table-warning'>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>저자</th>
                <th>츨판사</th>
                <th>출판일</th>
                <th>분류</th>
                <th>ISBN</th>
                <th>소장일</th>
                <th>누적 대여수</th>
                <th>서고 위치</th>
                <th>이용제한 여부</th>
                <th>대여중 여부</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $data2 = mysqli_query($conn, "SELECT * FROM li_bookinfo ORDER BY no DESC LIMIT $firstbtnno,$onepage_postlen;") or die(mysqli_error($conn));

            for ($i = 0; $i < $onepage_postlen; $i++) {
                $row = mysqli_fetch_array($data2);
                if ($row['no'] != "") {
                    echo "<tr>";
                    echo "<td id='no'>{$row['no']}</td>";
                    echo "<td >{$row['name']}</td>";
                    echo "<td>{$row['author']}</td>";
                    echo "<td>{$row['publisher']}</td>";
                    echo "<td>{$row['pubdate']}</td>";
                    echo "<td>{$row['kind']}</td>";
                    echo "<td>{$row['isbn']}</td>";
                    echo "<td>{$row['possession']}</td>";
                    echo "<td>{$row['accrent']}</td>";
                    echo "<td>{$row['position']}</td>";

                    if ($row['rentable'] == 1) {
                        echo "<td class='rentable'>이용 가능</td>";
                    } else {
                        echo "<td class='rentable'>불가능</td>";
                    }
                    //------------------------------------ 
                    //만약에 누군가 빌려갔다면 whorent를 0으로 바꿔줘야함
                    if ($row['whorent'] == 0) {
                        echo "<td id='whorent'>대여 가능</td>"; //0이면 대여가능한걸로 하자// 아직 아무도 대여안한상태
                    } else {
                        echo "<td id='whorent'>대여중</td>";
                    }
                    echo "<td><a href='booklist_modi.php?no={$row['no']}'  class='bookmodi btn btn-info' data='{$row['no']}'>수정하기</a></td>"; //이 버튼을 클릭하면 이 버튼의 no를 읽어와서 수정할수있게
                    echo "<td><button class='bookdel btn btn-danger' data='{$row['no']}'>삭제하기</button></td>";
                    echo "</tr>";
                }
            }
            ?>
            <!----------------------------------------------------------------------------------------->
            <tr>
                <td colspan="12">
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
                                <a href="<?php echo $prev_url; ?>" aria-label="Previous"><span
                                        aria-hidden="true">&laquo;</span></a>
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
<form id="bnoform" action="booklist_modi.php" method="post">
    <input type="text" id='no' name='no' hidden value="<?php $row['no'] ?>">
</form>
<script>
// #bookdel을 클릭하면 attr("data")의 값을 읽어내서 그 번호의 데이터베이스를 삭제한다-----------------------------
$(document).ready(function() {
    $(".bookdel").click(function() {
        if (confirm('정말로 삭제하겠습니까?')) {
            var delno = $(this).attr('data');
            location.href = 'booklist_del.php?no=' + delno;
        }
        // alert(delno); => 음
        //자바스크립트의 변수를 php에서 부를수는 없어서 쿼리문을 이용하는 수밖에 없음
    });
});
</script>
<style>
td {
    vertical-align: middle !important;
}
</style>