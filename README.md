# MS3 Documentation (Group 11)

## 1. NoSQL Database design
### 1.1. Migration of relational design to NoSQL

### 1.2. Motivation of single steps

### 1.3. Realization of NoSQL DBMS

## 2. Data Migration
### 2.1. Overview
For the migration of our database, we used our Java tool in continuation of the work we already presented in _Milestone 2_. We created an extra application, which implements the following functions:

+ **Complete migration from a MySQL schema:** Transfers the complete set of data from MySQL to our MongoDB database. To accomplish this, we created a parser (`SQLMigrator.java`), which selects the tuples in each table and then rearranges the syntax so they can be inserted into MongoDB sequentially.

+ **Manual data entry into the MongoDB database and relevant collections:**  As in _Milestone 2_, the manual data entry window allows the user to insert data into the desired collections. However, due to the restructuring of data mentioned in Chapter 1, we were forced to adapt how the insertion is actually handled. Nonetheless, this is completely hidden from the user and the insertion screen looks identical to the one presented in _Milestone 2_. 

+ **Dropping the MongoDB database:** In case of the migration being incomplete or another error. More granular deletion can be done via the Web interface in Employee/Admin mode.

+ **Querying information regarding the database/collections:** For _Milestone 3_, we also provided the ability to view specific sets of information regarding the database, such as the database name, size as well as the number of collections and data sets within. This screen provided us with a simple opportunity to verify the correctness of our CRUD operations without having to use the mongo CLI or MongoDB Compass.

### 2.2. Initialization of the program
To run our Java application for MS3, simply download and run `executables` -> `MS3` -> `Kino_JDBC.jar`. If you wish to compile the source code yourself, the main class can be found in `MS3`-> `src` -> `ms3kinoUI` -> `StartScreen.java`.

## 3. Implementation IS (NoSQL)
For specifics on the team members responsibilities and the use case implementation, please refer to `work_distribution` -> `work_distribution.docx`. For a list of our individual contributions, please refer to `work_distribution` -> `[surname]_work_protocol.xlsx`.
