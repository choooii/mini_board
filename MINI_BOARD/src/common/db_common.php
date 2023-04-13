<?php
// ---------------------------------------
// 함수명      : db_conn
// 기능        : db DDO 연결
// 파라미터    : &$param_conn
// 리턴값      : 없음
// ---------------------------------------
function db_conn( &$param_conn )
{
    $host        = "localhost";
    $user        = "root";
    $pass        = "root506";
    $charset     = "utf8mb4";
    $db_name     = "board";
    $dns         = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option  =
        array(
            PDO::ATTR_EMULATE_PREPARES     => false
            ,PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION
            ,PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC
        );

    try
    {
        $param_conn = new PDO( $dns, $user, $pass, $pdo_option );
    }
    catch( Exception $e )
    {
        $param_conn = null;
        throw new Exception( $e->getMessage() );
    }
}

// ---------------------------------------
// 함수명      : select_board_info_paging
// 기능        : 게시판에 페이지에 따른 게시글 표시
// 파라미터    : Array      &$param_arr
// 리턴값      : Array     $result
// ---------------------------------------
function select_board_info_paging( &$param_arr )
{
    $sql = 
        " SELECT "
        ."  board_no "
        ." ,board_title "
        ." ,board_write_date "
        ." FROM "
        ."  board_info "
        ." WHERE "
        ."  board_del_flg = '0' "
        ." ORDER BY "
        ."  board_no DESC "
        ." LIMIT :limit_num OFFSET :offset "
        ;

    $arr_prepare = 
        array(
                ":limit_num"    => $param_arr["limit_num"]
                ,":offset"      => $param_arr["offset"]
        );

    $conn = null;
    try 
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    } 
    catch ( Exception $e ) 
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    
    return $result;
}

// ---------------------------------------
// 함수명      : select_board_info_cnt
// 기능        : 삭제되지 않은 모든 게시글 수
// 파라미터    : 없음
// 리턴값      : Array     $result
// ---------------------------------------
function select_board_info_cnt()
{
    $sql =
            " SELECT "
            ."  COUNT(*) cnt "
            ." FROM "
            ."  board_info "
            ." WHERE "
            ."  board_del_flg = '0' "
        ;

    $arr_prepare = array();

    $conn = null;
    try 
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    } 
    catch ( Exception $e ) 
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    
    return $result;
}


// ---------------------------------------
// 함수명      : select_board_info_no
// 기능        : 게시판 특정 게시글 정보 검색
// 파라미터    : Array     &$param_no
// 리턴값      : Array     $result
// ---------------------------------------
function select_board_info_no( &$param_no )
{
    $sql = 
        " SELECT "
        ."  board_no "
        ." ,board_title "
        ." ,board_contents "
        ." ,board_write_date "  // 0412 작성일 추가
        ." FROM "
        ."  board_info "
        ." WHERE "
        ."  board_del_flg = '0' "
        ." AND "
        ."  board_no = :board_no "
        ;

        $arr_prepare = 
        array(
            ":board_no"    => $param_no 
        );

    $conn = null;
    try 
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    } 
    catch ( Exception $e ) 
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    
    return $result[0];
}

// ------------------------------------------------
// 함수명      : update_board_info_no
// 기능        : 게시판 특정 게시글 정보 수정
// 파라미터    : Array          &$param_arr
// 리턴값      : INT/STRING     $result_cnt/ERRMSG
// ------------------------------------------------
function update_board_info_no( &$param_arr )
{
    $sql = 
        " UPDATE "
        ."  board_info "
        ." SET "
        ."  board_title = :board_title "
        ."  ,board_contents = :board_contents "
        ." WHERE "
        ."  board_no = :board_no "
        ;

    $arr_prepare =
        array(
            ":board_title" => $param_arr["board_title"]
            ,":board_contents" => $param_arr["board_contents"]
            ,":board_no" => $param_arr["board_no"]
        );

    $conn = null;
    try 
    {
        db_conn( $conn );
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();  // 업데이트에 영향받은 레코드 수를 반환
        $conn->commit();
    } 
    catch ( Exception $e ) 
    {
        $conn->rollBack();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    
    return $result_cnt;

}

// ------------------------------------------------
// 함수명      : delete_board_info_no
// 기능        : 게시판 특정 게시글 정보의 삭제 플러그 갱신
// 파라미터    : INT            &$param_no
// 리턴값      : INT/STRING     $result_cnt/ERRMSG
// ------------------------------------------------
function delete_board_info_no( &$param_no )
{
    $sql = 
        " UPDATE "
        ."  board_info "
        ." SET "
        ."  board_del_flg = '1' "
        ."  ,board_del_date = NOW() "
        ." WHERE "
        ."  board_no = :board_no "
        ;

    $arr_prepare = 
        array(
            ":board_no"    => $param_no 
        );

    $conn = null;
    try 
    {
        db_conn( $conn );
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();  // 업데이트에 영향받은 레코드 수를 반환
        $conn->commit();
    } 
    catch ( Exception $e ) 
    {
        $conn->rollBack();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    
    return $result_cnt;
}

// ------------------------------------------------
// 함수명      : insert_board_info
// 기능        : 게시글 생성
// 파라미터    : Array          &$param_arr
// 리턴값      : INT/STRING     $result_cnt/ERRMSG
// ------------------------------------------------
function insert_board_info( &$param_arr )
{
    $sql = 
        " INSERT INTO board_info ( "
        ."  board_title "
        ."  ,board_contents "
        ."  ,board_write_date "
        ." ) "
        ." VALUES ( "
        ."  :board_title "
        ."  ,:board_contents "
        ."  ,NOW() "
        ." ) "
        ;

    $arr_prepare = 
        array(
            ":board_title"      => $param_arr["board_title"]
            ,":board_contents"  => $param_arr["board_contents"]
        );

    $conn = null;
    try 
    {
        db_conn( $conn );
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    } 
    catch ( Exception $e ) 
    {
        $conn->rollBack();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    
    return $result_cnt;
}

// TODO : START

// TODO : END


?>