## About

#####################
## Functions:
#####################



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

