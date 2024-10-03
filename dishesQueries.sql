--HIERARCHY VIEWS
/*
Get the data of all the main dishes in one table
*/
SELECT D.did, D.name, D.isHalal, D.isVegan, D.isVegetarian, ND.inBowl, ND.onPlate, M.hasMeat, M.hasFish, M.hasChicken
FROM dishes D, non_drinks ND, main_dishes M
WHERE D.did = ND.did AND ND.did = M.did
;
/*
Get the data of all the side dishes in one table
*/
SELECT D.did, D.name, D.isHalal, D.isVegan, D.isVegetarian, ND.inBowl, ND.onPlate, S.hasVegetables
FROM dishes D, non_drinks ND, side_dishes S
WHERE D.did = ND.did AND ND.did = S.did
;
/*
Get the data of all deserts in one table
*/
SELECT D.did, D.name, D.isHalal, D.isVegan, D.isVegetarian, ND.inBowl, ND.onPlate, DS.isCold, DS.hasFruit
FROM dishes D, non_drinks ND, desert_dishes DS
WHERE D.did = ND.did AND ND.did = DS.did
;
/*
Get the data of all drinks in one table
*/
SELECT D.did, D.name, D.isHalal, D.isVegan, D.isVegetarian, DR.isCold, DR.isHot
FROM dishes D, drinks DR
WHERE D.did = DR.did
;
/*
What are the avergae ratings of dishes?
*/
SELECT D.did, D.name, AVG( R.rating ) AS rating
FROM dishes D, rated R
WHERE D.did=R.did
GROUP BY (R.did);
/*
GET dishes whose rating is above average
*/
SELECT R.did, R.name, R.rating
FROM(
    (
    SELECT D.did, D.name, AVG( R.rating ) AS rating
    FROM dishes D, rated R
    WHERE D.did=R.did
    GROUP BY (R.did)
    ) R,
    (SELECT AVG(S.rating) AS avg_rating
    FROM ( SELECT D.did, D.name, AVG( R.rating ) AS rating
            FROM dishes D, rated R
            WHERE D.did=R.did
            GROUP BY ( R.did )
    ) AS S
    ) T
)
WHERE R.rating > T.avg_rating;

/*
GET CRITICS
we want to find all the users who are critics
*/
SELECT U.uid, U.login
FROM users U
WHERE U.isCritic = TRUE;
