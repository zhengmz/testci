-- rebuild app.db

-- BEGIN TRANSACTION;

-- Table: receive_tm
DROP TABLE IF EXISTS 'users';
CREATE TABLE users ( 
    id      VARCHAR( 20 )  PRIMARY KEY
                           UNIQUE,
    user_name VARCHAR( 50 ),
    create_tm DATETIME       DEFAULT ( datetime( 'now', 'localtime' )  ),
    last_tm   DATETIME       DEFAULT ( datetime( 'now', 'localtime' )  )
);

-- Table: actions
DROP TABLE IF EXISTS 'actions';
CREATE TABLE actions ( 
    id_from   VARCHAR( 20 ),
    id_to     VARCHAR( 20 ),
    act       INTEGER        DEFAULT ( 1 ),
    update_tm DATETIME       DEFAULT ( datetime( 'now', 'localtime' )  ),
    ip_addr   VARCHAR( 20 )
);

-- COMMIT;
