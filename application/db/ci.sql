PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
DROP TABLE IF EXISTS 'news';
CREATE TABLE news ( 
    id    INTEGER         PRIMARY KEY AUTOINCREMENT
                          NOT NULL,
    title VARCHAR( 128 )  NOT NULL,
    slug  VARCHAR( 128 )  NOT NULL
                          UNIQUE,
    text  TEXT            NOT NULL 
);
INSERT INTO "news" VALUES(1,'title1','slug1','This is a test news, number 1');
INSERT INTO "news" VALUES(2,'title2','title2','asdfadsf
asdfasdfas
adsfadsfads');
INSERT INTO "news" VALUES(3,'title3','title3','asfasdf
afasdfas
afdsfads');
INSERT INTO "news" VALUES(4,'标题4','4','asdfsad');
INSERT INTO "news" VALUES(5,'title6','title6','adfasdf
asdfasdf');
INSERT INTO "news" VALUES(6,'title 7','title-7','asdfsadf
adsfdsaf
title 7');
INSERT INTO "news" VALUES(7,'title 8','title-8','asdfdsa
adsfdsa
asdfdsaf');
DROP TABLE IF EXISTS 'users';
CREATE TABLE users ( 
    uid      INTEGER         PRIMARY KEY AUTOINCREMENT
                             NOT NULL,
    login     VARCHAR( 50 )   NOT NULL
                             UNIQUE,
    email    VARCHAR( 100 ),
    mobile   VARCHAR( 11 ),
    password VARCHAR( 100 ),
    nickname VARCHAR( 100 ),
    cust_id  INTEGER,
    status   INT( 1 )        NOT NULL
                             DEFAULT ( 1 ),
    remark   TEXT 
);
INSERT INTO "users" VALUES(1,'admin','zhengmz@139.com','13823456789',NULL,'Oscar',NULL,1,NULL);
INSERT INTO "users" VALUES(2,'webmaster',NULL,NULL,NULL,NULL,NULL,1,NULL);
INSERT INTO "users" VALUES(10000,'user',NULL,NULL,NULL,NULL,NULL,1,NULL);
DELETE FROM sqlite_sequence;
INSERT INTO "sqlite_sequence" VALUES('news',7);
INSERT INTO "sqlite_sequence" VALUES('users',10000);
COMMIT;
