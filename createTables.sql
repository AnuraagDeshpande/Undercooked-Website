/*
GROUP 11 ASSIGNMENT 2
*/

/*
ISA----------------------------------------------------------------------------
Here our is a hierarchy is described. We listed parent first children second.
*/

--parent class of all dishes
CREATE TABLE dishes (
did INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
name VARCHAR (100), 
isHalal BOOL, 
isVegan BOOL, 
isVegetarian BOOL, 
price FLOAT
);

--all dishes are either drinks or non drinks
CREATE TABLE drinks (
did INT PRIMARY KEY,
isCold BOOL,
isHot BOOL,
FOREIGN KEY(did) REFERENCES dishes(did)
);

CREATE TABLE non_drinks(
did INT PRIMARY KEY,
inBowl BOOL,
onPlate BOOL,
FOREIGN KEY(did) REFERENCES dishes(did)
);

--all drinks fall into one of the 3 categories: main, sides and deserts

--main dishes
CREATE TABLE main_dishes (
did INT PRIMARY KEY,
hasMeat BOOL,
hasFish BOOL,
hasChicken BOOL,
FOREIGN KEY(did) REFERENCES non_drinks(did)
);
--side dishes
CREATE TABLE side_dishes (
did INT PRIMARY KEY,
hasVegetables BOOL,
FOREIGN KEY(did) REFERENCES non_drinks(did)
);
--deserts
CREATE TABLE desert_dishes (
did INT PRIMARY KEY,
isCold BOOL,
hasFruit BOOL,
FOREIGN KEY(did) REFERENCES non_drinks(did)
);

/*
REVIEWS AND USERS
Reviews allow users to thoroughly review dishes. While also giving
users an option to only rate items. The entity sets and relationships are described below.
*/

--entity sets not part of ISA hierarchy------------------------------------------------------------------
CREATE TABLE users(
uid INT PRIMARY KEY,
isCritic BOOL,
login CHAR(20)
);

-- Table for reviews
CREATE TABLE reviews (
rid INT PRIMARY KEY,
content VARCHAR(500),
CHECK (LENGTH(content) >= 1 AND LENGTH(content) <= 500)
);

--relationships----------------------------------------------------------------

--rated = for all users
CREATE TABLE rated (
uid INT,
did INT,
rating INT,
PRIMARY KEY (uid,did),
FOREIGN KEY(did) REFERENCES dishes(did),
FOREIGN KEY(uid) REFERENCES users(uid),
CHECK (
rating >= 1 
AND rating <= 5
)
);
--has review dish->review
CREATE TABLE has_review(
did INT,
rid INT,
PRIMARY KEY (did, rid),
FOREIGN KEY (did) REFERENCES dishes(did),
FOREIGN KEY (rid) REFERENCES reviews(rid)	
);
--reviewed user->review
CREATE TABLE reviewed (
uid INT,
rid INT,
PRIMARY KEY (uid, rid),
FOREIGN KEY (uid) REFERENCES users(uid),
FOREIGN KEY (rid) REFERENCES reviews(rid)
);

/*
GOES WITH RELATION
Some dishes go better together. This is represented in this relationship
*/
CREATE TABLE goes_with( 
did1 INT,
did2 INT,
PRIMARY KEY (did1,did2),
FOREIGN KEY(did1) REFERENCES dishes(did),
FOREIGN KEY(did2) REFERENCES dishes(did),
CHECK (did1 != did2)
);
