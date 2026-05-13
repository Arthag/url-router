#####################
## Setup
#####################
The project is prepared as Docker Container.

1. Clone the sources from https://github.com/Arthag/url-router.git

2. In docker-compose.yaml a mysql-DB is prepared, if you want to use it fill this fields in your .evn:
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=your_db_name
DB_ROOT_PASSWORD=your_root_pw
DB_USERNAME=your_user
DB_PASSWORD=

If you want to use an external DB or another one adapt the docker-compose.yaml

3. Run the migration for database/migrations/2026_05_13_094535_create_urls_table.php

4. Build and start the Docker Project

#####################
## Short explanation
#####################
I decided to keep it small and simple, so there is just:
- UrlRouterController
- UrlRoutes (Model)
- UrlRoutesService

This creates a simple Service with the logic bundled in the Service.
One Controller which handles the HTTP Requests with just 4 Functions (create,redirect,deactivate,statistic).
The Model is just to define the writeable fields and have eloquent functions.

More decisions:
- a "deactivated" field in the DB is not needed, valid_to is enough to handle deactivation and make it possible to give a valid_to for new Slugs
- if there is a doublicate Long-Url the existing one is updated.
- Apache was preconfigured in the official Laravel-Project, for better performance it should be changed to NGINX(Reason: time saving)
- I kept the default Migrations for Users,Cache,Jobs. They're not used for now, but they will help if the project growing in future.
- A small mysql-DB is used in the stack, for better performance it should be replaced by MariaDB (SQLite/mySQL was required to use)
- Send an email after 100 clicks is prepared in DB table, but was skipped because lack of time.

Some final words:
For this project 120 mins was estimated, not sure if it's possible to do it complete in this time. 
There are some security issues which I ignored because lack of time, eg. at the moment just a simple post is needed to deactivate a Slug. The forwarding can be used for Phishing, because it's possible to redirect to a long evil URL from a trusty URL where this Service runs.


#####################
## Functions:
#####################
### Overview ###
- Create
- Redirect
- Deact
- Statistic

### Create ###
Creates or Updates a Slug for an URL Redirect

# Example 

Request:
Invoke-RestMethod -Method POST -Uri "http://localhost:9002/api/create" -ContentType "application/json" -Body '{"target_url":"https://google.de"}'
Response: 
id            : 1
target_url    : https://google.de
slug          : mcG-1
click_counter : 0
valid_to      :
created_at    : 2026-05-13T11:21:05.000000Z
updated_at    : 2026-05-13T12:00:12.000000Z



### Redirect (r) ###
Redirects a tiny URL to the belonging long URL

# Example
Request:
http://localhost:9002/api/r/mcG-3

Response: 
The external Webpage, eg. https://google.de

### Deact
Deactivates a Slug by setting the valid_to = now()

# Example
Request: 
Invoke-RestMethod -Method POST -Uri "http://localhost:9002/api/deact" -ContentType "application/json" -Body '{"slug":"UXR-1"}'

Response:
slug  valid_to
----  --------
UXR-1 2026-05-13 12:51:49


### Statistic ###
Get Statistics for a Slug-Url

# Example
Request:
http://localhost:9002/api/statistic/UXR-1

Response:
[{"id":1,"target_url":"https:\/\/google.de","slug":"UXR-1","click_counter":1,"valid_to":null,"created_at":"2026-05-13T11:21:05.000000Z","updated_at":"2026-05-13T12:01:03.000000Z"}]

