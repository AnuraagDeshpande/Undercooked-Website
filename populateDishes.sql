/*
In this file the data into the dish centered part of the table is inserted
for testing.
*/
--MAIN DISHES
INSERT INTO dishes VALUES (1,"PORK STEAK WITH PEPPER SAUCE", FALSE, FALSE, FALSE, 5.20);
INSERT INTO non_drinks VALUES (1, FALSE, TRUE);
INSERT INTO main_dishes VALUES (1, TRUE, FALSE, FALSE);

INSERT INTO dishes VALUES (2,"BEEF BIFTEKI WITH TZAZIKI", TRUE, FALSE, FALSE, 5.20);
INSERT INTO non_drinks VALUES (2, FALSE, TRUE);
INSERT INTO main_dishes VALUES (2, TRUE, FALSE, FALSE);

INSERT INTO dishes VALUES (3,"PUMPKIN-POTATO WRAP", TRUE, TRUE, TRUE, 5.70);
INSERT INTO non_drinks VALUES (3, FALSE, TRUE);
INSERT INTO main_dishes VALUES (3, FALSE, FALSE, FALSE);

INSERT INTO dishes VALUES (4,"CHICKEN RAGOUT TOMATO RICOTTA", TRUE, FALSE, TRUE, 5.70);
INSERT INTO non_drinks VALUES (4, FALSE, TRUE);
INSERT INTO main_dishes VALUES (4, FALSE, FALSE, TRUE);
--SIDES
INSERT INTO dishes VALUES (5,"TOMATO RICE", TRUE, TRUE, TRUE, 1.50);
INSERT INTO non_drinks VALUES (5, TRUE, FALSE);
INSERT INTO side_dishes VALUES (5, FALSE);

INSERT INTO dishes VALUES (6,"MALLORQUIN POTATOES", TRUE, TRUE, TRUE, 1.50);
INSERT INTO non_drinks VALUES (6, TRUE, FALSE);
INSERT INTO side_dishes VALUES (6, TRUE);

INSERT INTO dishes VALUES (7,"WEDGES", TRUE, TRUE, TRUE, 1.50);
INSERT INTO non_drinks VALUES (7, TRUE, FALSE);
INSERT INTO side_dishes VALUES (7, TRUE);

INSERT INTO dishes VALUES (8,"HERB POTATOS", TRUE, TRUE, TRUE, 1.50);
INSERT INTO non_drinks VALUES (8, TRUE, FALSE);
INSERT INTO side_dishes VALUES (8, TRUE);
--DESERTS
INSERT INTO dishes VALUES (9,"YOGURT WITH HONEY & ALMONDS", TRUE, FALSE, TRUE, 1.80);
INSERT INTO non_drinks VALUES (9, TRUE, FALSE);
INSERT INTO desert_dishes VALUES (9, FALSE, FALSE);

INSERT INTO dishes VALUES (10,"FRUIT SALAD", TRUE, TRUE, TRUE, 1.80);
INSERT INTO non_drinks VALUES (10, TRUE, FALSE);
INSERT INTO desert_dishes VALUES (10, FALSE, TRUE);

INSERT INTO dishes VALUES (11,"CHERRY CURD", TRUE, TRUE, TRUE, 1.80);
INSERT INTO non_drinks VALUES (11, TRUE, FALSE);
INSERT INTO desert_dishes VALUES (11, FALSE, TRUE);

INSERT INTO dishes VALUES (12,"ORANGE CAKE", TRUE, FALSE, TRUE, 3.50);
INSERT INTO non_drinks VALUES (12, TRUE, FALSE);
INSERT INTO desert_dishes VALUES (12, FALSE, TRUE);
--DRINKS
INSERT INTO dishes VALUES (13,"ORANGE JUICE", TRUE, TRUE, TRUE, 1.70);
INSERT INTO drinks VALUES (13, TRUE, FALSE);

INSERT INTO dishes VALUES (14,"TEA", TRUE, TRUE, TRUE, 1.70);
INSERT INTO drinks VALUES (14, FALSE, TRUE);

INSERT INTO dishes VALUES (15,"COCA COLA", TRUE, TRUE, TRUE, 2.00);
INSERT INTO drinks VALUES (15, TRUE, FALSE);

INSERT INTO dishes VALUES (16,"CAPRI SUN", TRUE, TRUE, TRUE, 1.20);
INSERT INTO drinks VALUES (16, TRUE, FALSE);

--GOES_WITH
INSERT into goes_with VALUES (1,15);
INSERT into goes_with VALUES (5,12);
INSERT into goes_with VALUES (7,15);
INSERT into goes_with VALUES (3,15);
INSERT into goes_with VALUES (3,16);
INSERT into goes_with VALUES (8,10);