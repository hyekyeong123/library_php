<!--한페이지 내에서 검색하는거보다 검색페이지를 따로 만들어서 하는 방법-->
<?php
include "common.php";
include "header.php";

$searchtxt = $_GET['searchtxt'];
$searchtype = $_GET['searchtype'];
//value = 0이면 제목, 1이면 저자, 2이면 제목+저자

if ($searchtxt == "" || $searchtype == "") {
    //비어있으면 잘못 접근 한거니까
    echo "<script>";
    echo "alert('잘못된 접근입니다.');";
    echo "history.back();";
    echo "</script>";
}

//현재 페이지 번호 알아내기
$page = $_GET['page'];
if ($page == "") {
    $page = 0;
}
$data = mysqli_query($conn, "SELECT no FROM li_bookinfo ORDER by no DESC;");
$total_len = mysqli_num_rows($data);
$total_pagelen = ceil($total_len / $onepage_postlen);

$total_blocklen = ceil($total_pagelen / $onepage_btnlen);

$firstpostno = $onepage_postlen * $curpage;

$cur_blockno = floor($curpage / $onepage_btnlen);

$firstbtnno = $cur_blockno * $onepage_btnlen;
?>
<a id="back" href='total_booklist.php' class='btn btn-warning form-control'>전체보기</a>
<div class='table-responsive'>
    <table class='table  table-hover'>
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
            if ($searchtype == 0) { //제목
                $data2 = mysqli_query($conn, "SELECT * FROM li_bookinfo WHERE name LIKE '%$searchtxt%' ORDER BY no DESC LIMIT $firstpostno, $onepage_postlen;") or die(mysqli_error($conn));
            } else if ($searchtype == 1) { //저자
                $data2 = mysqli_query($conn, "SELECT * FROM li_bookinfo WHERE author LIKE '%$searchtxt%' ORDER BY no DESC LIMIT $firstpostno, $onepage_postlen;") or die(mysqli_error($conn));
            } else { //제목 + 저자
                $data2 = mysqli_query($conn, "SELECT * FROM li_bookinfo WHERE name LIKE '%$searchtxt%' OR  auhor LIKE '%$searchtxt%' ORDER BY no DESC LIMIT $firstpostno, $onepage_postlen;") or die(mysqli_error($conn));
            }

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
                                if ($btnno <= $total_pagelen) { //만약 현재번호가 전체페이지의 갯수보다 작거나 같다면
                                    $active = "";
                                    if ($curpage + 1 == $btnno) {
                                        $active = "active";
                                    }
                                    $pageurl = "?page=" . ($btnno - 1); //url이니까 다시 -1을 해줘야지
                                    echo "<li class='$active'><a href='$pageurl'>$btnno</li>";
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
<style>
    #back {
        margin: 40px 0px 20px 0px;
        padding-right: 20px;
        padding-left: 20px;
    }
</style>