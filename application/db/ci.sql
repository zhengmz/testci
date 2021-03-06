-- rebuild ci.db

-- BEGIN TRANSACTION;

-- Table: products
DROP TABLE IF EXISTS 'products';
CREATE TABLE products ( 
    id             INTEGER         PRIMARY KEY AUTOINCREMENT,
    name           VARCHAR( 50 )   NOT NULL,
    img_url        VARCHAR( 200 ),
    unit           VARCHAR( 10 ),
    original_price REAL( 10, 2 ),
    discount       REAL( 10, 2 ),
    summary        TEXT,
    detail         BLOB,
    detail_url     VARCHAR( 200 ),
    saled_sum      INTEGER         DEFAULT ( 0 ),
    effect_tm      DATETIME,
    expired_tm     DATETIME,
    status         INT( 1 )        DEFAULT ( 1 ),
    create_tm      DATETIME        DEFAULT ( datetime() ),
    update_tm      DATETIME        DEFAULT ( datetime() ) 
);

-- Table: news
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
INSERT INTO "news" VALUES(2,'title2','title2','asdfadsf asdfasdfas adsfadsfads');
INSERT INTO "news" VALUES(3,'title3','title3','asfasdf afasdfas afdsfads');
INSERT INTO "news" VALUES(4,'标题4','4','asdfsad');
INSERT INTO "news" VALUES(5,'title6','title6','adfasdf asdfasdf');
INSERT INTO "news" VALUES(6,'title 7','title-7','asdfsadf adsfdsaf title 7');
INSERT INTO "news" VALUES(7,'title 8','title-8','asdfdsa adsfdsa asdfdsaf');
INSERT INTO "news" VALUES(8,'title 9','title-9','adsfsdf afadsf');

-- Table: users
DROP TABLE IF EXISTS 'users';
CREATE TABLE users ( 
    id           INTEGER         PRIMARY KEY AUTOINCREMENT
                                 NOT NULL,
    login        VARCHAR( 50 )   NOT NULL
                                 UNIQUE,
    email        VARCHAR( 100 ),
    mobile       VARCHAR( 20 ),
    sex          INT( 1 ),
    password     VARCHAR( 100 ),
    nickname     VARCHAR( 100 ),
    head_img_url VARCHAR( 200 ),
    city         VARCHAR( 20 ),
    province     VARCHAR( 20 ),
    country      VARCHAR( 20 ),
    remark       TEXT,
    cust_id      INTEGER,
    status       INT( 1 )        NOT NULL
                                 DEFAULT ( 1 ),
    create_tm    DATETIME        DEFAULT ( datetime() ),
    update_tm    DATETIME        DEFAULT ( datetime() )
);
INSERT INTO "users" VALUES(1,'admin','admin@web.com','13823456789',NULL,NULL,'Admin',NULL,NULL,NULL,NULL,NULL,NULL,1,'2014-01-07 07:32:23','2014-01-07 07:32:23');
INSERT INTO "users" VALUES(2,'webmaster',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2014-01-07 07:32:23','2014-01-07 07:32:23');
INSERT INTO "users" VALUES(10000,'user',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2014-01-07 07:32:23','2014-01-07 07:32:23');

-- Table: customers
DROP TABLE IF EXISTS 'customers';
CREATE TABLE customers ( 
    id           INTEGER         PRIMARY KEY AUTOINCREMENT,
    name         VARCHAR( 50 )   NOT NULL,
    sex          INT( 1 ),
    type         INT( 1 )        DEFAULT ( 1 ),
    password     VARCHAR,
    short_name   VARCHAR( 20 ),
    head_img_url VARCHAR( 200 ),
    mobile       VARCHAR( 20 ),
    email        VARCHAR( 100 ),
    telphone     VARCHAR( 20 ),
    fax          VARCHAR( 100 ),
    city         VARCHAR( 20 ),
    province     VARCHAR( 20 ),
    country      VARCHAR( 20 ),
    address      VARCHAR( 200 ),
    zip_code     VARCHAR( 10 ),
    remark       TEXT,
    status       INT( 1 )        DEFAULT ( 1 ),
    create_tm    DATETIME        DEFAULT ( datetime() ),
    update_tm    DATETIME        DEFAULT ( datetime() )
);
INSERT INTO "customers" VALUES(1000,'customer',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2014-01-07 07:23:24','2014-01-07 07:23:24');

-- Table: applications
DROP TABLE IF EXISTS 'applications';
CREATE TABLE applications ( 
    id         INTEGER         PRIMARY KEY AUTOINCREMENT,
    provider   VARCHAR( 20 )   NOT NULL
                               DEFAULT ( 'weixin' ),
    app_name   VARCHAR( 50 )   NOT NULL,
    app_id     VARCHAR( 50 )   NOT NULL,
    app_secret VARCHAR( 100 )  NOT NULL,
    app_gh     VARCHAR( 50 ),
    remark     TEXT,
    status     INT( 1 )        DEFAULT ( 1 ),
    create_tm  DATETIME        DEFAULT ( datetime() ),
    update_tm  DATETIME        DEFAULT ( datetime() ) 
);
INSERT INTO "applications" VALUES(1000,'weixin','apps','1','1',NULL,NULL,1,'2014-01-07 07:53:42','2014-01-07 07:53:42');

-- Table: user_binds
DROP TABLE IF EXISTS 'user_binds';
CREATE TABLE user_binds ( 
    provider       VARCHAR( 20 )  NOT NULL,
    open_id        VARCHAR( 50 )  NOT NULL,
    nickname       VARCHAR( 50 ),
    json           TEXT,
    user_id        INTEGER,
    status         INT( 1 )       DEFAULT ( 1 ),
    first_bind_tm  DATETIME       DEFAULT ( datetime() ),
    last_bind_tm   DATETIME       DEFAULT ( datetime() ),
    last_unbind_tm DATETIME
);

-- Table: orders
DROP TABLE IF EXISTS 'orders';
CREATE TABLE orders ( 
    id               INTEGER        PRIMARY KEY AUTOINCREMENT,
    user_id          INTEGER        NOT NULL,
    product_id       INTEGER        NOT NULL,
    num              INTEGER,
    total            REAL( 10, 2 ),
    addr_id          INTEGER,
    express_num      VARCHAR( 20 ),
    express_provider VARCHAR( 20 ),
    status           INT( 1 ),
    create_tm        DATETIME       DEFAULT ( datetime() ),
    update_tm        DATETIME       DEFAULT ( datetime() ) 
);

-- Table: address
DROP TABLE IF EXISTS 'address';
CREATE TABLE address ( 
    id        INTEGER         PRIMARY KEY AUTOINCREMENT,
    user_id   INTEGER,
    cust_id   INTEGER,
    address   VARCHAR( 200 ),
    zip_code  VARCHAR( 10 ),
    phone     VARCHAR( 20 ),
    recipient VARCHAR( 20 ),
    create_tm DATETIME        DEFAULT ( datetime() ),
    update_tm DATETIME        DEFAULT ( datetime() ) 
);

-- Rebase the sequence
DELETE FROM sqlite_sequence;
INSERT INTO "sqlite_sequence" VALUES('address',1000);
INSERT INTO "sqlite_sequence" VALUES('applications',1000);
INSERT INTO "sqlite_sequence" VALUES('customers',1000);
INSERT INTO "sqlite_sequence" VALUES('news',8);
INSERT INTO "sqlite_sequence" VALUES('orders',1000);
INSERT INTO "sqlite_sequence" VALUES('products',1000);
INSERT INTO "sqlite_sequence" VALUES('user_binds',1000);
INSERT INTO "sqlite_sequence" VALUES('users',10000);

-- Index: idx_applications_unique_provider_app_id
DROP INDEX IF EXISTS 'idx_applications_unique_provider_app_id';
CREATE UNIQUE INDEX idx_applications_unique_provider_app_id ON applications ( 
    provider,
    app_id 
);

-- Index: idx_user_binds_unique_provider_open_id
DROP INDEX IF EXISTS 'idx_user_binds_unique_provider_open_id';
CREATE INDEX idx_user_binds_unique_provider_open_id ON user_binds ( 
    provider,
    open_id 
);

-- COMMIT;
