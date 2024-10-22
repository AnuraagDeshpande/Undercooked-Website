--HIERARCHY VIEWS
/*
Get the data of all the main dishes in one table
*/
CREATE VIEW mains_combined AS
SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, ND.inBowl, ND.onPlate, M.hasMeat, M.hasFish, M.hasChicken
FROM dishes D, non_drinks ND, main_dishes M
WHERE D.did = ND.did AND ND.did = M.did
;
/*
Get the data of all the side dishes in one table
*/
CREATE VIEW sides_combined AS
SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, ND.inBowl, ND.onPlate, S.hasVegetables
FROM dishes D, non_drinks ND, side_dishes S
WHERE D.did = ND.did AND ND.did = S.did
;
/*
Get the data of all deserts in one table
*/
CREATE VIEW deserts_combined AS
SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, ND.inBowl, ND.onPlate, DS.isCold, DS.hasFruit
FROM dishes D, non_drinks ND, desert_dishes DS
WHERE D.did = ND.did AND ND.did = DS.did
;
/*
Get the data of all drinks in one table
*/
CREATE VIEW drinks_combined AS
SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, DR.isCold, DR.isHot
FROM dishes D, drinks DR
WHERE D.did = DR.did
;

/*
OTHERS:
*/
/*
What are the avergae ratings of dishes?
*/
CREATE VIEW dish_ratings AS
SELECT D.did, D.name, AVG( R.rating ) AS rating
FROM dishes D, rated R
WHERE D.did=R.did
GROUP BY (R.did);

--Gives back users, their reviews and the dishes they were made on 
CREATE VIEW user_reviews AS
SELECT u.login, u.isCritic, r.content, d.name, u.uid, d.did, r.rid
  FROM users u, reviews r, reviewed rv, has_review hr, dishes d
WHERE u.uid = rv.uid 
  AND rv.rid = r.rid 
  AND r.rid = hr.rid 
  AND hr.did = d.did;

--Gives back ratings of a user
CREATE VIEW user_ratings AS
SELECT u.login, r.rating, d.name, u.uid, d.did, r.rid
FROM users u, rated r, dishes d
WHERE u.uid=r.uid AND r.did=d.did;