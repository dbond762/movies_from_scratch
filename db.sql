create table actor
(
    id         int auto_increment
        primary key,
    first_name varchar(50) not null,
    last_name  varchar(50) not null
);

INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (1, 'Марлон', 'Брандо');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (2, 'Аль', 'Пачино');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (3, 'Джеймс', 'Каан');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (4, 'Роберт', 'Де Ниро');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (5, 'Роберт', 'Дюваль');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (6, 'Дайан', 'Китон');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (7, 'Джон', 'Казале');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (8, 'Ли', 'Страсберг');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (9, 'Майкл В.', 'Гаццо');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (10, 'Талия', 'Шайр');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (11, 'Энди', 'Гарсиа');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (12, 'Илай', 'Уоллак');
INSERT INTO movies_from_scratch.actor (id, first_name, last_name) VALUES (13, 'София', 'Коппола');

create table movie
(
    id     int auto_increment
        primary key,
    name   varchar(255)                                not null,
    year   int                                         not null,
    format set ('VHS', 'DVD', 'Blu-Ray') default 'DVD' not null
);

INSERT INTO movies_from_scratch.movie (id, name, year, format) VALUES (1, 'Крестный отец', 1972, 'Blu-Ray');
INSERT INTO movies_from_scratch.movie (id, name, year, format) VALUES (2, 'Крестный отец 2', 1974, 'Blu-Ray');
INSERT INTO movies_from_scratch.movie (id, name, year, format) VALUES (3, 'Крестный отец 3', 1990, 'Blu-Ray');

create table movie_actor
(
    movie_id int not null,
    actor_id int not null,
    primary key (movie_id, actor_id),
    constraint movie_actor_actor_id_fk
        foreign key (actor_id) references actor (id)
            on update cascade on delete cascade,
    constraint movie_actor_movie_id_fk
        foreign key (movie_id) references movie (id)
            on update cascade on delete cascade
);

INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (1, 1);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (1, 2);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (2, 2);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (3, 2);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (1, 3);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (2, 3);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (2, 4);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (2, 5);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (2, 6);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (3, 6);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (2, 7);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (2, 8);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (2, 9);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (2, 10);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (3, 10);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (3, 11);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (3, 12);
INSERT INTO movies_from_scratch.movie_actor (movie_id, actor_id) VALUES (3, 13);
