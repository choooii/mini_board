<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."src/common/db_common.php" );
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
    <title>Detail</title>
</head>
<body>
    <div>
        <p>게시글 번호 : <? echo $result_info["board_no"] ?></p>
        <p>작성일 : <? echo $result_info["board_write_date"] ?></p>
        <p>게시글 제목 : <? echo $result_info["board_title"] ?></p>
        <p>게시글 내용 : <? echo $result_info["board_contents"] ?></p>
    </div>

    <button type="button" onclick="location.href='board_list.php?page_num=1'">목록</button>
    <button type="button" onclick='location.href="board_update.php?board_no=<? echo $result_info["board_no"] ?>"'>수정</button>
    <button type="button" onclick='location.href="board_delete.php?board_no=<? echo $result_info["board_no"] ?>"'>삭제</button>
</body>
</html>