--Gives back ratings for selected dish (filtered by did)
SELECT d.name, r.rid, r.content
  FROM dishes d, reviews r, has_review hr
WHERE d.did = hr.did
  AND r.rid = hr.rid
  AND d.did = 2;

--Gives back ratings for selected dish (filtered by name)
SELECT d.name, r.rid, r.content
  FROM dishes d, reviews r, has_review hr
WHERE d.did = hr.did
  AND r.rid = hr.rid
  AND d.did = 'BEEF BIFTEKI WITH TZAZIKI';

--Gives back users, their reviews and the dishes they were made on 
SELECT u.login, r.content, d.name
  FROM users u, reviews r, reviewed rv, has_review hr, dishes d
WHERE u.uid = rv.uid 
  AND rv.rid = r.rid 
  AND r.rid = hr.rid 
  AND hr.did = d.did;

--Gives Reviews of a user (filtered by uid)
SELECT d.name, r.content
  FROM users u, reviews r, reviewed rv, has_review hr, dishes d
WHERE u.uid = rv.uid
  AND rv.rid = r.rid
  AND r.rid = hr.rid
  AND hr.did = d.did
  AND u.uid = 3;

  --Gives Reviews of a user (filtered by login)
SELECT d.name, r.content
  FROM users u, reviews r, reviewed rv, has_review hr, dishes d
WHERE u.uid = rv.uid
  AND rv.rid = r.rid
  AND r.rid = hr.rid
  AND hr.did = d.did
  AND u.uid = 'Critic1';

--How many reviews did a person give? (filtered by uid)

SELECT COUNT(r.rid) AS review_count
  FROM users u, reviews r, reviewed rv, has_review hr, dishes d
WHERE u.uid = rv.uid
  AND rv.rid = r.rid
  AND r.rid = hr.rid
  AND hr.did = d.did
  AND u.uid = 4;

  --How many reviews did a person give? (filtered by login)

SELECT COUNT(r.rid) AS review_count
  FROM users u, reviews r, reviewed rv, has_review hr, dishes d
WHERE u.uid = rv.uid
  AND rv.rid = r.rid
  AND r.rid = hr.rid
  AND hr.did = d.did
  AND u.uid = 'user4';

--Gives back reviews for selected dish (filtered by did and name)
SELECT d.did, d.name, r.rid, r.content
  FROM dishes d, reviews r, has_review hr
WHERE d.did = hr.did
  AND r.rid = hr.rid
  AND d.did = 2
  AND d.name = 'BEEF BIFTEKI WITH TZAZIKI';

--Gives back users, their reviews and the dishes they were made on 
SELECT u.login, r.content, d.name
  FROM users u, reviews r, reviewed rv, has_review hr, dishes d
WHERE u.uid = rv.uid 
  AND rv.rid = r.rid 
  AND r.rid = hr.rid 
  AND hr.did = d.did;

--Gives Reviews of a user (filtered by uid and login)
SELECT d.name, r.content
  FROM users u, reviews r, reviewed rv, has_review hr, dishes d
WHERE u.uid = rv.uid
  AND rv.rid = r.rid
  AND r.rid = hr.rid
  AND hr.did = d.did
  AND u.uid = 3
  AND u.login = 'Critic1';


--How many reviews did a person give? (filtered by uid and login)

SELECT COUNT(r.rid) AS review_count
  FROM users u, reviews r, reviewed rv, has_review hr, dishes d
WHERE u.uid = rv.uid
  AND rv.rid = r.rid
  AND r.rid = hr.rid
  AND hr.did = d.did
  AND u.uid = 4
  AND u.login = 'Critic2';

--Finds all halal, vegan or vegetarian dishes that have been rated higher than 4
SELECT d.name
FROM dishes d, rated r, users u, main_dishes m
WHERE d.did = r.did
  AND r.uid = u.uid
  AND d.did = m.did
  AND r.rating > 4
  AND u.isCritic = TRUE
  AND (d.isHalal = TRUE OR d.isVegan = TRUE OR d.isVegetarian = TRUE);


--Gives the top 3 highest rated non-vegan main dishes with chicken
SELECT d.name
FROM dishes d, rated r, main_dishes md
WHERE d.did = md.did
  AND d.isVegan = FALSE
  AND (md.hasChicken = TRUE)
  AND d.did = r.did
ORDER BY (SELECT AVG(r2.rating) FROM rated r2 WHERE r2.did = d.did) DESC
LIMIT 3;


--List dishes that go well together, along with their avg rating and
--the number of times they have been paired with other dishes
SELECT d.did, COUNT(gw.did1) AS times_paired,
  (SELECT AVG(r.rating) FROM rated r WHERE r.did = d.did) AS avg_rating
FROM dishes d, goes_with gw
WHERE d.did = gw.did1 OR d.did = gw.did2
GROUP BY d.did

--Gives users who have rated halal and non halal dishes,
--the number of halal and non halal dishes they have rated
--and the difference between their ratings of halal and non halal dishes
SELECT u.uid,
    COUNT(d.did) AS halal_dishes_rated,
    (SELECT COUNT(d2.did)
     FROM rated r2, dishes d2 
     WHERE r2.uid = u.uid AND r2.did = d2.did AND d2.isHalal = FALSE
    ) AS non_halal_dishes_rated,
    (SELECT AVG(r1.rating)
     FROM rated r1, dishes d1 
     WHERE r1.uid = u.uid AND r1.did = d1.did AND d1.isHalal = TRUE
    ) - 
    (SELECT AVG(r2.rating)
     FROM rated r2, dishes d2 
     WHERE r2.uid = u.uid AND r2.did = d2.did AND d2.isHalal = FALSE
    ) AS avg_rating_difference
FROM 
    users u, rated r, dishes d
WHERE 
    r.uid = u.uid
    AND r.did = d.did
    AND d.isHalal = TRUE
GROUP BY 
    u.uid
HAVING 
    halal_dishes_rated > 0
    AND non_halal_dishes_rated > 0;
