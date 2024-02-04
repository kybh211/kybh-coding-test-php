## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

### RUN migrate && seed
```
bin/cake migrations migrate

bin/cake migrations seed --seed UsersSeed
bin/cake migrations seed --seed ArticlesSeed
```

### Authentication

TODO: pls summarize how to check "Authentication" behavior
```
Use plugin api-token-authenticator to check authentication api
- Use package "rrd108/api-token-authenticator" to authentication
- Add field token for User table
- To authenticate the token, add the "token" parameter to the header when calling the API.
- Use the login API to obtain the token.
- Actions such as "view," "index," and "login" do not require authentication.
```

### Article Management

TODO: pls summarize how to check "Article Management" behavior
```
- Create a model and controller for articles.
- Utilize the viewClasses function within the ArticlesController.
- Add the JSON extension and the Article resource to the routes.
- Authenticate the "add" and "edit" API based on the configuration settings for authentication.
- Make the "view" and "index" API public, not requiring authentication.
- Implement additional checks for author conditions in the "edit" and "delete" API.
```

### Like Feature

TODO: pls summarize how to check "Like Feature" bahavior
```
- Create a "likes" table.
- Add the "total_like" field to the "articles" table to count the total number of likes for each article.
- Use the "CounterCache" behavior to update the number of likes for an article.
- Create a "like" action in the "ArticlesController."
- When calling the like API, check for authentication conditions and whether the article has already been liked. If not, like the article.
```


LOGIN info:
```
email: "admin@vti.com.vn"
password: "123456'
```
```
AUTHENTICATION
header param
Token:"key-from-login-api"
```
USER API
```
POST: http://localhost:34251/users/login.json
body {"email": "admin@vti.com.vn", "password": "123456"}
GET: http://localhost:34251/users/logout.json
POST: http://localhost:34251/users.json
body {"email": "email@email.com", "password": "password"}
```
ARTICLES API
```

GET: http://localhost:34251/articles.json
POST: http://localhost:34251/articles.json
body {"title": "title", "body": "body"}
PUT: http://localhost:34251/articles/{id}.json
ody {"title": "title", "body": "body"}
DELETE: http://localhost:34251/articles/{id}.json
GET: http://localhost:34251/articles/like/{id}.json
```