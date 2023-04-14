<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."src/common/db_common.php" );
    define( "URL_HEADER", DOC_ROOT."src/board_header.php" );
    include_once( URL_DB );

    $arr_get = $_GET;

    $result_info = select_board_info_no( $arr_get["board_no"] )
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/board_update.css">
    <title>Detail</title>
</head>
<body>
    <? include_once( URL_HEADER ) ?>
    <div class='entire'>
        <div class='profile'>
            <div>
                <img id="grogu" src="https://pbs.twimg.com/profile_images/1475656796241301508/OYmbPJv3_400x400.jpg" alt="grogu">
            </div>
            <div>
                <h2>Title</h2>
            </div>
            <div>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </div>
            <div>
                <img id="house" src="https://cdn3d.iconscout.com/3d/premium/thumb/house-3260441-2725134.png" alt="house">
            </div>
        </div>
        <div class='container'>
            <div class='posts'>
                <div class='bno_2'>
                    <p>게시글 번호</p> 
                    <span><? echo $result_info["board_no"] ?></span>
                    <p>작성일</p> 
                    <span><? echo mb_substr($result_info["board_write_date"],0,10) ?></span>
                </div>
                <div class='bno'>
                    <p>게시글 제목</p> 
                    <span><? echo $result_info["board_title"] ?></span>
                </div>
                <div class='bno'>
                    <p>게시글 내용</p> 
                    <span id='wide'><? echo $result_info["board_contents"] ?></span>
                </div>
            </div>

            <div class="button">
                <button type="button" onclick="location.href='board_list.php'">목록</button>
                <button type="button" onclick='location.href="board_update.php?board_no=<? echo $result_info["board_no"] ?>"'>수정</button>
                <button type="button" onclick='location.href="board_delete.php?board_no=<? echo $result_info["board_no"] ?>"'>삭제</button>
            </div>
        </div>
    </div>
</body>
</html>