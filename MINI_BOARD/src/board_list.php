<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."src/common/db_common.php" );
    include_once( URL_DB );

    // 페이지 수
    if ( array_key_exists( "page_num", $_GET ) )
    {
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1;
    }


    // 페이지에 표시하는 최대 레코드 수
    $limit_num = 5;



    // 게시판 정보 테이블 전체 카운트 획득
    $result_cnt = select_board_info_cnt();

    //max page 번호
    $max_page_num = ceil( $result_cnt[0]["cnt"] / $limit_num );

    // offset
    $offset = $limit_num*($page_num - 1);

    $arr_prepare = 
        array(
            "limit_num" => $limit_num
            ,"offset"   => $offset
        );
    $result_paging = select_board_info_paging( $arr_prepare );

    
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="..\src\css\board_list.css">
    <title>게시판</title>
</head>
<body>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th>게시글 번호</th>
                <th>게시글 제목</th>
                <th>작성일자</th>
            </tr>
        </thead>
        <tbody>
            <?
                foreach ( $result_paging as $record ) 
                {
            ?>
                <tr>
                <td><? echo $record["board_no"]?></td>
                <td><? echo $record["board_title"]?></td>
                <td><? echo $record["board_write_date"]?></td>
                </tr>
            <?
                }
            ?>
        </tbody>
    </table>

    <nav>
    <ul>
        <li>
            <a href='board_list.php?page_num=<? if($page_num > 1 && $page_num <= $max_page_num) {echo ( $page_num - 1 ); } else { echo $page_num; } ?> ' aria-label="Previous">이전
            </a>
        </li>  
        <?
        for ($i=1; $i <= $max_page_num; $i++) 
        {
        ?>
        <li>
            <a href='board_list.php?page_num=<? echo $i ?>'><? echo $i ?></a>
        </li>
        <?
        }
        ?>
        <li>
        <a href='board_list.php?page_num=<? if($page_num > 0 && $page_num < $max_page_num) {echo ( $page_num + 1 ); } else { echo $page_num; } ?> ' aria-label="Next">이후
        </a>
        </li>   
    </ul>
    </nav>

</body>
</html>