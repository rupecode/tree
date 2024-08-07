-- Migrate to Version 1 

CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    email varchar(256) NOT NULL,
    password varchar(40) NOT NULL,
    PRIMARY KEY (id),
    INDEX ep (email, password)
)
