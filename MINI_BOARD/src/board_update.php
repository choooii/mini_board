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

        // update
        $result_cnt = update_board_info_no( $arr_info );

        // select
        // $result_info = select_board_info_no( $arr_post["board_no"] );  // 0412 del

        header( "Location: board_detail.php?board_no=".$arr_post["board_no"] ); // 리다이렉트
        exit(); // 밑에 소스 코드들이 실행이 안됨, 해더를 통해서 다른 화면으로 넘어가기 때문에 작성 함
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
<div class="snowflakes" aria-hidden="true">
    <div class="snowflake">
    ✿
    </div>
    <div class="snowflake">
    ❀
    </div>
    <div class="snowflake">
    ✿
    </div>
    <div class="snowflake">
    ❀
    </div>
    <div class="snowflake">
    ✿
    </div>
    <div class="snowflake">
    ❀
    </div>
    <div class="snowflake">
    ✿
    </div>
    <div class="snowflake">
    ❀
    </div>
    <div class="snowflake">
    ✿
    </div>
    <div class="snowflake">
    ❀
    </div>
</div>

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
                    <textarea name="board_contents" id="contents" cols="30" rows="10"><?echo $result_info['board_contents']?></textarea>
                </div>
                <div class="button">
                    <button type="button" onclick="location.href='board_list.php?page_num=1'">목록</button>
                    <button type="button" onclick="location.href='board_detail.php?board_no=<? echo $result_info['board_no'] ?>'">취소</button>
                    <button type="submit">수정</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>