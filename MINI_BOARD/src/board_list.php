<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."src/common/db_common.php" );
    define( "URL_HEADER", DOC_ROOT."src/board_header.php" );
    include_once( URL_DB );

    // 페이지 수(GET 체크)
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
    
    // 한 블럭 당 페이지 수
    $block_num = 3;

    // 게시판 정보 테이블 전체 카운트 획득
    $total_page = select_board_info_cnt();
    
    // max page 번호
    $max_page_num = ceil( $total_page[0]["cnt"] / $limit_num );

    // max blcok 번호
    $max_block_num = ceil( $max_page_num / $block_num );

    // 현재 블럭 번호
    $now_block = ceil( $page_num / $block_num );

    // 블럭 안 시작 페이지 번호
    $s_page_num = ( $now_block - 1 ) * $block_num + 1;
    if ( $s_page_num <= 0 ) 
    {
        $s_page_num = 1;
    }

    // 블럭 안 마지막 페이지 번호
    $e_page_num = $now_block * $block_num;
    if ( $e_page_num > $max_page_num )
    {
        $e_page_num = $max_page_num;
    }

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
    <link rel="stylesheet" href="css/board_list2.css">
    <title>게시판</title>
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
            <button type='button' onclick="location.href='board_insert.php'">게시글 작성</button>
            <div class='board'>
                <h1>게시판</h1>
                <div class='k'>
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th class='radius-left'>게시글 번호</th>
                                <th>게시글 제목</th>
                                <th class='radius-right'>작성일자</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                                foreach ( $result_paging as $record ) 
                                {
                            ?>
                                <tr>
                                    <td class='radius-left'><? echo $record["board_no"]?></td>
                                    <td>
                                        <a href='board_detail.php?board_no=<?echo $record["board_no"]?>'><? echo $record["board_title"]?></a>
                                    </td>
                                    <td class='radius-right'><? echo $record["board_write_date"]?></td>
                                </tr>
                            <?
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='button'>
                <a href='board_list.php?page_num=1'>처음</a>
                <a href='board_list.php?page_num=<? if($page_num > 1 && $page_num <= $max_page_num) {echo ( $page_num - 1 ); } else { echo $page_num; } ?>'>이전</a>
                <?
                for ($i=$s_page_num; $i <= $e_page_num; $i++)
                {
                    if ( $i == $page_num ) {
                    ?>
                    <a href='board_list.php?page_num=<? echo $i ?>' class='target'><? echo $i ?></a>
                    <? }
                    else
                    { ?>
                        <a href='board_list.php?page_num=<? echo $i ?>' class='non_target'><? echo $i ?></a>
                    <?}
                }
                ?>
                <a href='board_list.php?page_num=<? if($page_num > 0 && $page_num < $max_page_num) {echo ( $page_num + 1 ); } else { echo $page_num; } ?>'>이후</a>
                <a href='board_list.php?page_num=<? echo $max_page_num ?>'>끝</a>
            </div>
        </div>
    </div>

</body>
</html>