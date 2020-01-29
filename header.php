<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="author" content="jeong hye kyeong">
    <meta name="description" content="도서 정보 시스템,대여하기">
    <meta property="og:image" content="">
    <meta property="og:description" content="도서 정보 시스템,대여하기">
    <meta property="og:title" content="도서 정보 시스템">
    <link rel="shortcut icon" href="" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/common.css">
    <!-- <link rel="stylesheet" href="css/bootstrap.css.map">
	<link rel="stylesheet" href="css/bootstrap-theme.css"> -->



    <script src="script/bootstrap.js"></script>
    <script src="script/npm.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <title>도서 관리 정보 시스템</title>

</head>


<body>
    <header>
        <nav id="nav">

            <ul class="nav nav-pills ">
                <li role="presentation">
                    <a href=" index.php">한율 도서관</a>
                </li>
                <li role="presentation" class="active">
                    <a href="#">한율도서관 정보</a>
                </li>
                <li role="presentation" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                        aria-expanded="false">도서 정보 검색<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="booklist.php">자료 검색</a>
                        </li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                        aria-expanded="false">
                        대출안내<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="#">대출하기</a>
                        </li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                        aria-expanded="false">
                        안내사항<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="notice.php">공지사항</a>
                        </li>
                    </ul>
                </li>
                <?php
				if ($_SESSION['log']) {
					//로그인을 했으면
					echo "<li role='presentation' class='label label-info'></li>";
					echo "<li role='presentation' class='dropdown'>";
					echo "<button type='button'class='btn btn-primary dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'
					href='#'>{$_SESSION['userid']}님 마이페이지<span class='caret'></span></button>";
					echo "<ul class='dropdown-menu' role='menu'>";
					echo "<li><button type='button' id='logout' class='btn btn-danger'>로그아웃</button></li>";
					echo "<li><a href='mybook.php'>나의 도서 정보 보기</a></li>";
					echo "<li><a href='mem_modify.php'>개인정보 수정</a></li>";
					echo "</ul>";
					echo "</li>";
					if ($_SESSION['lv'] > 8) {
						echo "<li class='nav-item'>";
						echo "<a class='nav-link btn btn-warning' href='admin.php'>관리자페이지</a>";
						echo "</li>";
					}
				} else {
					//로그인을 하지 않았다면
					echo "<li role='presentation'><a href='login.php'>로그인</a></li>";
					echo "<li role='presentation'><a href='join.php'>회원가입</a></li>";
				}
				?>
            </ul>
        </nav>
    </header>
    <section>
        <script>
        $("#logout").click(function() {
            if (confirm('정말로 로그아웃 하시겠습니까?')) {
                location.href = "logout.php";
            }
        });
        // 오늘 접속자, 누적접속자 기능 안 넣었음
        </script>