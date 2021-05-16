The simple user API
===============

Problem
-------

“Write a simple API (using the Symfony Framework) to display a list of users, create new users, and change or delete an existing user. The aim is to exchange the data source (e.g. a database, an XML file, ...) for users without having to touch the code that uses the data source and returns the response. Please provide documentation on how to use the API.”

Setup
-----

Just clone the this and then:
1. docker-compose build  <to run some commands and make the first migration>
2. docker-compose up
3. test http://localhost/api

If it does not work? maybe it's because the migrations was not made in the FPM Dockerfile

1. run 'docker ps' and get the FPM-PHP container number
2. run 'docker exec -it <container> sh'
3. php bin/console doctrine:migrations:migrate (inside FPM container)
4. php bin/console doctrine:fixtures:load (inside FPM container)

I don't know why FPM Dockerfile sometimes simply does not run the command with the first migration and the DB is not ready on start up :(

How does this thing works?
--------------------------

Under /tests/ dir there is ApiTests.php and in /tests/data/ a .xml file that can be used

1. GET = http://localhost/api to get the in XML a list of the users in DB
2. POST = http://localhost/api/create to create, in this case I post my XML data as raw Body (I'm using Postman for requests) and I use the sample below
3. PUT = http://localhost/api/update to update, using the xml
4. DELETE = http://localhost/api/delete to delete, also using the sample below

```
<?xml version="1.0" encoding="UTF-8"?>
<api>
    <content>
        <id>1</id>
        <name>Bruno</name>
        <email>bruno@bruno.com</email>
        <password>pass</password>
        <city>Berlin</city>
    </content>
    <content>
        <id>2</id>
        <name>Admin</name>
        <email>admin@admin.io</email>
        <password>pass</password>
        <city>Berlin</city>
    </content>
</api>
```

What's missing?
--------------------------

1. Security: Make an API key athentication or use some sort of token
2. Change the sql primary keys to an id that uses a mix(hash) of email and name
3. Install API Platform https://symfony.com/projects/apiplatform