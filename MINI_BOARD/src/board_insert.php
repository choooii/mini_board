<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."src/common/db_common.php" );
    include_once( URL_DB );

    $http_method = $_SERVER["REQUEST_METHOD"];
    
    if ( $http_method === "POST" ) 
    {
        $arr_post = $_POST;
        // 현업에서는 보안때문에 데이터 칼럼명을 그대로 쓰지 않고, php에서 사용할 연상 배열로 수정함

        $result_cnt = insert_board_info( $arr_post );

        header( "Location: board_list.php" ); // 리다이렉트
        exit();
    }

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/board_update.css">
    <title>게시글 작성</title>
</head>
<body>
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
            <h1>게시글 작성</h1>
            <form method="post" action="board_insert.php">
                <div class="board">
                    <div class="bno">
                        <label for="title">게시글 제목</label>
                        <input type="text" name="board_title" id="title">
                    </div>
                    <div class="contents">
                        <label for="contents">게시글 내용</label>
                        <textarea name="board_contents" id="contents" cols="30" rows="10"></textarea>
                    </div>
                    <div class="button">
                        <button type="button" onclick="location.href='board_list.php'">취소</button>
                        <button type="submit">완료</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>