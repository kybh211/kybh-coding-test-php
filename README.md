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

Set up the sample:

```
bin/cake migrations seed --seed UsersSeed
```
```
bin/cake migrations seed --seed ArticlesSeed
```

### Accessing the Application

The homepage should now be accessible at http://localhost:34251

## How to check

- Use POSTMAN to check API

### Authentication

User account:

```
email: "admin@vti.com.vn"
password: "123456"
```
```
email: "user@vti.com.vn"
password: "123456"
```

Logout API

```
GET: http://localhost:34251/users/logout.json
```

Login to get token

```
POST: http://localhost:34251/users/login.json
    body {"email": "admin@vti.com.vn", "password": "123456"}
```

#### Get the token from login API to setup Authorization in Postman

<img src="https://img001.prntscr.com/file/img001/4gH8J4fMQ3KSl43J-SZZsg.png" alt="Authentication setup" style="width:800px;"/>

### Article Management

1. ### Getting list articles

```
GET: http://localhost:34251/articles.json

Response: articles array
```

2. ###  Get article

```
GET: http://localhost:34251/articles/1.json

Response: articles object
```


3. ###  Create an article

- Case 1: login user

```
POST: http://localhost:34251/articles.json
    body {"title": "create test article", "body": "create test article"}
    
    Response: "created".
```

- Case 2: Guest user ( logout first )

```
POST: http://localhost:34251/articles.json
    body {"title": "Not authenticated user Title", "body": "Not authenticated user Body"}
    
    Response: "Authentication is required to continue",
```
- 
- Case 3: no body

```
POST: http://localhost:34251/articles.json

Response: "Error."
```

4. ###  Edit an article

- Case 1: login user and the writer (login by user 'admin@vti.com.vn')

```
PUT: http://localhost:34251/articles/1.json
    {"title": "Update article", "body": "Update article"}
    
    Response: "Updated"
```

- Case 2: login user and NOT the writer (login by user 'user@vti.com.vn').

```
PUT: http://localhost:34251/articles/1.json
    {"title": "updated other writer title", "body": "updated other writer body"}
    
    Response: "Unauthorized,
```

- Case 3: Guest user ( require logout )

```
PUT: http://localhost:34251/articles/1.json
    {"title": "guest title", "body": "Guest body"}
    
    Response: "Authentication is required to continue",
```

5. ###  Delete an article

- Case 1: login user and the writer (require login by user 'user@vti.com.vn')

```
DELETE: http://localhost:34251/articles/2.json

Response: "Deleted"
```

- Case 2: login user and NOT the writer (require login by user 'admin@vti.com.vn').

```
DELETE: http://localhost:34251/articles/2.json

Response: "Unauthorized",
```

- Case 3: Guest user ( require logout )

```
DELETE: http://localhost:34251/articles/1.json

Response: "Authentication is required to continue",
```

### Like Feature

1. ###  Like an article

- Case 1: login user (require login)

```
GET: http://localhost:34251/articles/like/1.json

Response: "Liked successfully."
```

- Case 2: login user & liked article (require login)

```
GET: http://localhost:34251/articles/like/1.json

Response: "You liked it before."
```

- Case 3: guest user

```
GET: http://localhost:34251/articles/like/1.json

Response: "Authentication is required to continue"
```

2. ###  Like count

- Case 1: detail article

```
GET: http://localhost:34251/articles/1.json

Response: an article object with "total_like" field
```

- Case 2: list article

```
GET: http://localhost:34251/articles.json

Response: an array of articles object with "total_like" field
```