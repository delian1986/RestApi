CREATE DATABASE events CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE events;

CREATE TABLE category
(
    id   INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE article
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT          NOT NULL,
    title       VARCHAR(255) NOT NULL,
    content     TEXT         NOT NULL,
    event       VARCHAR(255) NULL,
    location    VARCHAR(255) NULL,
    published   DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_article_category
        FOREIGN KEY (category_id) REFERENCES category (id)
);

CREATE TABLE status
(
    id   INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE article_status
(
    article_id INT NOT NULL,
    CONSTRAINT fk_article_status
        FOREIGN KEY (article_id) REFERENCES article (id),
    status_id  INT NOT NULL,
    CONSTRAINT fk_status_article
        FOREIGN KEY (status_id) REFERENCES status (id)
);

DELIMITER  $$
CREATE TRIGGER `tr_article_after_insert` AFTER INSERT ON `article` FOR EACH ROW
BEGIN
    DECLARE open_status_id INT;
    SET open_status_id = (SELECT id FROM status WHERE name='Open' );
    INSERT INTO article_status (article_id,status_id)
    VALUES (new.id,open_status_id);
END $$
DELIMITER ;

INSERT INTO status(name)
VALUES ('Open'),
       ('Error'),
       ('Wrong'),
       ('Other');

INSERT INTO category(name)
VALUES ('Спорт'),
       ('Политика');

INSERT INTO article(category_id, title, content, event, location)
VALUES (1,
        'Човек от треньорският щаб на Спартак Плевен наплю главният съдия',
        'Доктор Емил Попов от треньорскяит щаб на Спартак Плевен наплю главният съдия Иван Петров след като му бе забранено да влезе да укаже помощ на падналия на земята десен бек Георги Георгиев.',
        'среша от 3 кръг на Б група Спратак Плевен - Чардафон Габрово',
        'Стадион Белите орли, Плевен'),
       (2,
        'Партия БЗЗ напусна събранието предварително',
        'Десете члена на БЗЗ напуснаха събранието на ХДХ минути след неговият старт.',
        NULL,
        'Парламента');





