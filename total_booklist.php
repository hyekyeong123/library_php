<!--일반 계정으로 도서 정보 리스트를 조회하는 화면(필수)-->
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


<!--검색기능-->
<!--1. 최신순, 2. 누적대여순, 3. 제목검색, 4. 저자검색  -->
<form action="book_search.php" method="get" id='search'>
    <select name="searchtype" id="searchtype" class='form-control'>
        <option value="0" selected>제목 검색</option>
        <option value="1">저자 검색</option>
        <option value="2">제목 + 저자검색</option>
    </select>
    <div class="row">
        <div class="col-lg-6" class='pull-right' id='search_style'>
            <div class="input-group">
                <input id='searchtxt' name='searchtxt' type="text" class="form-control">
                <div class="input-group-btn">
                </div>
                <div class="input-group-btn">
                    <button id="searchbtn" type="button" class="btn btn-warning ">검색하기</button>
                </div><!-- /btn-group -->
            </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
</form>
<script>
//1. 두글자 이상만 검색가능하게
$("#searchbtn").click(function() {
    if ($("#searchtxt").val().length < 2) {
        alert("두글자 이상을 입력해주세요");
    } else {
        $("#search").submit();
    }
});
</script>
<style>
#search_style {
    margin: 20px 30px 50px 0px;
    float: right;
}

#searchtype {
    width: 30vw;
    margin-top: 20px;
    margin-right: 30px;
    float: right;
}
</style>
<!----------------------------------------------------->
<div class='btn-group pull-right' style="margin-bottom: 10px;">
    <button type='button' class='btn btn-success' id='new'>최신순</button>
    <button type='button' class='btn btn-warning' id='acc'>누적대여순</button>
</div>
<!--일반 계정 도서 목록 테이블---------------------------------------------------------------------------------->
<div class="table-responsive" style="clear:both;">
    <table class='table table-hover table-striped  table-bordered'>
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
                    if ($row['whorent'] == 1) {
                        echo "<td id='whorent'>대여 가능</td>";
                    } else {
                        echo "<td id='whorent'>대여중</td>";
                    }
                    echo "</td>";
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
                            <!--이전 버튼--------------------------------------------------------------------- -->
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
                                if ($btnno <= $total_pagelen) { //만약 현재번호가 전체페이지의 갯수보다 작거나 같다면
                                    $active = "";
                                    if ($curpage + 1 == $btnno) {
                                        $active = "active";
                                    }
                                    $pageurl = "?page=" . ($btnno - 1); //url이니까 다시 -1을 해줘야지
                                    echo "<li class='$active'><a href='$pageurl'>$btnno</a></li>";
                                }
                            }
                            ?>
                            <!--다음버튼-->
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