-- Migrate to Version 3

CREATE TABLE tree
(
    id int NOT NULL AUTO_INCREMENT,
    parent int NOT NULL,
    name VARCHAR(256),
    description TEXT,
    PRIMARY KEY (id),
    INDEX p (parent)
)
