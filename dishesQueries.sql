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
Get the dishes whose rating is above average
*/
SELECT S.did, S.name, S.rating
FROM 
(
    SELECT *, AVG(rating) OVER() AS avg_rating--im not sure how this works but it does
    FROM ( SELECT D.did, D.name, AVG( R.rating ) AS rating
        FROM dishes D, rated R
        WHERE D.did=R.did
        GROUP BY ( R.did ) 
    ) AR
) AS S
WHERE rating > avg_rating;
