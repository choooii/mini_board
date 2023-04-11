<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."src/common/db_common.php" );
    include_once( URL_DB );

    $http_method = $_SERVER["REQUEST_METHOD"]; // 통신에 따라 POST, GET 저장

    // GET 체크
    if ( $http_method === "GET" ) 
    {
        $board_no = 1;
        if ( array_key_exists( "board_no", $_GET ) )
        {
            $board_no = $_GET["board_no"];
        }
        $result_info = select_board_info_no( $board_no );
    }
    else // POST 체크
    {
        $arr_post = $_POST;
        $arr_info =
            array(
                "board_no" => $arr_post["board_no"]
                ,"board_title" => $arr_post["board_title"]
                ,"board_contents" => $arr_post["board_contents"]
            );

        $result_cnt = update_board_info_no( $arr_info );

        $result_info = select_board_info_no( $arr_post["board_no"] );
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/board_update.css">
    <title>게시글 수정</title>
</head>
<body>
    <div class="container">
        <h1>수정</h1>
        <form method="post" action="board_update.php">
            <div class="board">
                <div class="bno">
                    <label for="bno">게시글 번호</label>
                    <input type="text" name="board_no" id="bno" value="<? echo $result_info['board_no'] ?>" readonly>
                </div>
                <div class="bno">
                    <label for="title">게시글 제목</label>
                    <input type="text" name="board_title" id="title" value="<? echo $result_info['board_title'] ?>">
                </div>
                <div class="contents">
                    <label for="contents">게시글 내용</label>
                    <textarea name="board_contents" id="contents" cols="30" rows="10"><?echo $result_info['board_contents']?>
                    </textarea>
                </div>
                <div class="button">
                    <button type="button" onclick="location.href='board_list.php?page_num=1'">목록</button>
                    <button type="submit">수정</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>