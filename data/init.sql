CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE
);

INSERT INTO "user" (username, email, created_at)  VALUES ('unex', 'patati@patata.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('caillou', 'caillou@rocher.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('viteira', 'vivi@taira.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('césar', 'jule@cesar.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('gengis', 'gengis@khan.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('adolf', 'adolf@ensiie.de', NOW());


CREATE TABLE "post" (
    id SERIAL PRIMARY KEY,
    content VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    author_id BIGINT
);

INSERT INTO "post" (content, created_at, author_id)  VALUES ('hello', NOW(), 1);
INSERT INTO "post" (content, created_at, author_id)  VALUES ('world', NOW(), 1);
INSERT INTO "post" (content, created_at, author_id)  VALUES ('Someone is up to go out? #COVID-19', NOW(), 3);
INSERT INTO "post" (content, created_at, author_id)  VALUES ('I m hosting a homeless girl #COupleVID-19', NOW(), 6);

CREATE TABLE "comment" (
    id SERIAL PRIMARY KEY,
    content VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    author_id BIGINT,
    post_id BIGINT
);

INSERT INTO "comment" (content, created_at, author_id, post_id)  VALUES ('Not going out with someone coming from Wuhan LoL', NOW(), 6, 3);
INSERT INTO "comment" (content, created_at, author_id, post_id)  VALUES ('None should have to live with you in a bunker', NOW(), 3, 4);