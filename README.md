# Group 11
## Members:
- Alen Kostov
- Timofei Podkorytov
- Yuri Parshin
- Anuraag Deshpande

## Files:
### SQL
- createTables.sql
- Queries.sql
- populateUsers.sql
- populateDishes.sql

We have 2 files that are directly related to the assignments so far. The creation and queries files. But we also have 2 files for populating the database with data, one for food related things, and the other for the user centered aspects.
### Documentation
- README.md
- databases-project.pdf
- databases project.docx

Here you can find the schema and the description of the project. The readme provides a more general description of the repository structure. 

## Assignments:
### Assignment 1:
The schema is in the pdf file as well as the description
### Assignment 2:
The commands to create tables are in ```createTables.sql``` file. The descriptions are there as well.
### Assignment 3:
The Query file is ```dishesQueries.sql```. In order to see that they work there are 2 files that populate the database: ```populateUsers.sql```, ```populateDishes.sql```.

### Assignment 4:
public_html folder contains all the code files like CSS and HTML. The corporate design is contained in CD.pdf file in that folder as well.

### Assignment 5:
All the relevant code can be found in the maintenance directory.

This assignment has a lof of files in it. This is due to the fact that there are many tables and relationships
into which we need to input data. Usually we have a input page, a success page and am error code that appears in case an 
action was not successful.
#### Input files for entering database data
1. try.php
2. addedDish.html
3. rate.php
4. rated.html
5. signup.pho
6. signupSuc.html
7. goesWith.html
8. goesWith.php
9. addReviews.php
10. addReviews.html
11. app.js

#### View pages
They show tables, often in joined form in order to make it easier to check for maintenance. We can see what we inputed.
1. users.php
2. dishes.php
3. ratingsData.php
4. reviewsData.php
5. goesWithData.php

#### Maintenance and variables
This page has links to all the pages listed above and is linked back by them. Global vriables such as the address of the host are in a separate file.
1. maintenance.php
2. variables.php

#### OTHER:
There were some other changes made in different files but the files listed above hold the most relevance to the assignment

### Assignment 6:
There are several new folders that contain forms, queries and result pages. There you can find 
the result and page files contain the main page of the section as well as the result page that adapts to input. 
Folders:
1. dish_queries
2. review_queried
3. user_queries

The search bar is local to page and finds the relevant data after the input is given and the button is pressed.

### Assignment 7:
We made the login page accesible. There one can register on the webiste or log in with the existing account. 

If an admin user logs in they can access the maintenance pages. Should a new non admin user log in after the admin opened a page, the php
will redirect the user to a ouch page after reloading the page. That page says that the contents of the page the user tried to access are
not for them.