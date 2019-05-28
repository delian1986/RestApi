# Hotspot: Latest News Rest API

## Solution
### ERD Diagram
![erd](https://i.imgur.com/OcxZl8p.png)

### Endpoints
| URI                                                   	| Method 	| Type 	| Description                                                                                            	| Example Request                                                                                                                                                                                                                                                	| Example Response Body                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             	|
|-------------------------------------------------------	|--------	|------	|--------------------------------------------------------------------------------------------------------	|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	|
| http://localhost/rest/article/?published={time in minutes} 	| GET    	| JSON 	| Generating a list of materials added in the last X minutes (e.g., 5, 10, or 60)                        	|                                                                                                                                                                                                                                                                	| [{     "id": 1,     "category": {         "id": 1,         "name": "Спорт"     },     "title": "Човек от треньорският щаб на Спартак Плевен наплю главният съдия",     "content": "Доктор Емил Попов ..",     "event": "среша от 3 кръг на Б група Спратак Плевен - Чардафон Габрово",     "location": "Стадион Белите орли, Плевен",     "published": "2019-05-27 20:14:34" }",     "{     "id": 2,     "category": {         "id": 2,         "name": "Политика"     },     "title": "Партия БЗЗ напусна събранието предварително",     "content": "Десете члена на БЗЗ н..",     "event": null,     "location": "Парламента",     "published": "2019-05-27 20:14:34" }]                                        	|
| http://localhost/rest/article/?deleted                     	| GET    	| JSON 	| Generating a list of materials by all incorrect information                                            	|                                                                                                                                                                                                                                                                	| [     "{     "id": 1,     "category": {         "id": 1,         "name": "Спорт"     },     "title": "Човек от треньорският щаб на Спартак Плевен наплю главният съдия",     "content": "Доктор Емил Попов от ..",     "event": "среша от 3 кръг на Б група Спратак Плевен - Чардафон Габрово",     "location": "Стадион Белите орли, Плевен",     "published": "2019-05-28 08:21:27" }",     "{     "id": 2,     "category": {         "id": 2,         "name": "Политика"     },     "title": "Партия БЗЗ напусна събранието предварително",     "content": "Десете члена на БЗЗ..",     "event": null,     "location": "Парламента",     "published": "2019-05-28 08:21:27" }" ]                               	|
| http://localhost/rest/article/{id}                         	| GET    	| JSON 	| Generating single article                                                                              	|                                                                                                                                                                                                                                                                	| {     "id": 2,     "category": {         "id": 2,         "name": "Политика"     },     "title": "Партия БЗЗ напусна събранието предварително",     "content": "Десете члена на БЗЗ ..",     "event": null,     "location": "Парламента",     "published": "2019-05-28 08:21:27" }                                                                                                                                                                                                                                                                                                                                                                                                                                	|
| http://localhost/rest/article/                             	| GET    	| JSON 	| Generating all public articles                                                                         	|                                                                                                                                                                                                                                                                	| [{      "id": 1,      "category": {          "id": 1,          "name": "Спорт"      },      "title": "Човек от треньорският щаб на Спартак Плевен наплю главният съдия",      "content": "Доктор Емил Попов от треньорскяит...",      "event": "среша от 3 кръг на Б група Спратак Плевен - Чардафон Габрово",      "location": "Стадион Белите орли, Плевен",      "published": "2019-05-27 20:14:34"  }",      "{      "id": 2,      "category": {          "id": 2,          "name": "Политика"      },      "title": "Партия БЗЗ напусна събранието предварително",      "content": "Десете члена на БЗЗ ...",      "event": null,      "location": "Парламента",      "published": "2019-05-27 20:14:34"  }] 	|
| http://localhost/rest/article/                             	| POST   	| JSON 	| Creating new articles by one or multiple JSON objects. The input must be array of objects.             	| [     {         "category": 2,         "title": "Партия БЗЗ напусна събранието предварително",         "content": "Десете члена на БЗЗ напуснаха събранието на ХДХ минути след неговият старт.",         "event": "",         "location": "Парламента"     } ] 	| {     "message": "article created" }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              	|
| https://localhost/rest/article/{id}                        	| PUT    	| JSON 	| Updating the status of the current article by id. Possible status are : 'Open','Error','Wrong','Other' 	| { 	 "status":"other" }                                                                                                                                                                                                                                          	| {     "message": "article updated" }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              	|
| https://localhost/rest/category/{id}                       	| GET    	| JSON 	| Generating a list of materials of all public entries in a selected category                            	|                                                                                                                                                                                                                                                                	| [{       "id": 1,       "category": {           "id": 1,           "name": "Спорт"       },       "title": "Човек от треньорският щаб на Спартак Плевен наплю главният съдия",       "content": "Доктор Емил Попов от ..",       "event": "среша от 3 кръг на Б група Спратак Плевен - Чардафон Габрово",       "location": "Стадион Белите орли, Плевен",       "published": "2019-05-27 20:14:34"   }]                                                                                                                                                                                                                                                                                                          	|
## Problem Description
A software product has to be implemented to facilitate the work of a team of journalists on the project "From the place of the event".
The idea is that the field team can easily and conveniently send information to the office assignment, where this information is properly processed.

### A unit of information will contain the following data:
<ul>
  <li>Category (required)</li>
  <li>Title (required)</li>
  <li>Content (required)</li>
  <li>Event (Optional)</li>
  <li>Location (optional)</li>
</ul>

> Example 1:
 Категория: Спорт
 Заглавие: Човек от треньорският щаб на Спартак Плевен наплю главният съдия
Съдържание:
Доктор Емил Попов от треньорскяит щаб на Спартак Плевен наплю главният съдия Иван Петров след като му бе забранено да влезе да укаже помощ на падналия на земята десен бек Георги Георгиев.
 - Събитие: среша от 3 кръг на Б група Спратак Плевен - Чардафон Габрово
 - Местоположение: Стадион Белите орли, Плевен
 
 > Example 2:

Категория: Политика
Заглавие: Партия БЗЗ напусна събранието предварително
Съдържание: Десете члена на БЗЗ напуснаха събранието на ХДХ минути след неговият старт.
Събътие:
Местоположение: Парламента
 
 **************************************


#### Problem 1: Establish the database

Create a table (or tables) for the needs of the project "From the place of the event".

requirements: MariaDB 10.0.35


**************************************

*************************************
#### Problem 2: Create an API

To make an API for the project as it should have the following capabilities:

- Adding a unit of information
- Adding multiple information (that is, at one time, adding from 2 to X information units similar to the example above)
- Delete unit information by one of the following criteria:
   - error
   - Misleading information
   - something else
- Generating a list of materials by different criteria
  - added in the last X minutes (e.g., 5, 10, or 60)
  - all incorrect information
  - all records
  - all entries in a selected category

There is no need for authorization to do so. That is, we accept that all users of this API have the right to use it.

Requirements: php 5.5 or later

*********************************************
