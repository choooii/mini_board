-- 게시글 제목 : 제목n
-- 게시글 내용 : 내용n
-- 작성일 현재 일자
-- 1~20까지 insert

INSERT INTO board_info (
	board_title
	,board_contents
	,board_write_date
)
VALUES (
	'제목20'
	,'내용20'
	,NOW()
);

COMMIT;


SELECT * FROM board_info;
