-- 게시글 제목 : 제목n
-- 게시글 내용 : 내용n
-- 작성일 현재 일자
-- 1~20까지 insert

INSERT INTO board_info (
	board_title
	,board_contents
	,board_write_date
)
VALUES ('제목21','내용21',NOW())
,('제목22','내용22',NOW())
,('제목23','내용23',NOW())
,('제목24','내용24',NOW())
,('제목25','내용25',NOW())
;

COMMIT;


SELECT * FROM board_info;
