--USERS
INSERT INTO users VALUES (1, FALSE, "user1");
INSERT INTO users VALUES (2, FALSE, "user2");
INSERT INTO users VALUES (3, TRUE, "critic1");
INSERT INTO users VALUES (4, TRUE, "critic2");
INSERT INTO users VALUES (5, FALSE, "user3");
--RATED
INSERT INTO rated VALUES (1,1,4);
INSERT INTO rated VALUES (1,7,5);
INSERT INTO rated VALUES (1,10,1);
INSERT INTO rated VALUES (1,16,5);
INSERT INTO rated VALUES (1,3,3);

INSERT INTO rated VALUES (2,1,3);
INSERT INTO rated VALUES (2,7,4);
INSERT INTO rated VALUES (2,11,5);
INSERT INTO rated VALUES (2,16,4);
INSERT INTO rated VALUES (2,15,5);

INSERT INTO rated VALUES (3,1,5);
INSERT INTO rated VALUES (3,10,2);
INSERT INTO rated VALUES (3,7,3);
INSERT INTO rated VALUES (3,15,3);
INSERT INTO rated VALUES (3,14,5);

INSERT INTO rated VALUES (4,7,4);
INSERT INTO rated VALUES (4,10,4);
INSERT INTO rated VALUES (4,15,3);
--REVIEWS
INSERT INTO reviews VALUES(1,"nice crust and taste");
INSERT INTO reviews VALUES(2,"too sweet");
INSERT INTO reviews VALUES(3,"my favourite dish");
INSERT INTO reviews VALUES(4,"I don't like it");
INSERT INTO reviews VALUES(5,"I want to come back for more");
INSERT INTO reviews VALUES(6,"Nice dish");

--contents of has_review linking the dishes with reviews
INSERT into has_review VALUES (7,1);
INSERT into has_review VALUES (15,2);
INSERT into has_review VALUES (4,3);
INSERT into has_review VALUES (2,4);
INSERT into has_review VALUES (12,5);
INSERT into has_review VALUES (10,6);

--contents of reviewed linking the users with reviews
INSERT into reviewed VALUES (1,4);
INSERT into reviewed VALUES (2,3);
INSERT into reviewed VALUES (3,6);
INSERT into reviewed VALUES (4,2);
INSERT into reviewed VALUES (5,5);
INSERT into reviewed VALUES (2,1);