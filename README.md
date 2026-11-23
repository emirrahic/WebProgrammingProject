# Library Book Management System

University web project (PHP + JS + MySQL). **Current stage: Milestone 3** (business logic, REST API, OpenAPI documentation and external API, on top of the database and the static SPA frontend).

## Description
A web app for managing a library: books, authors, categories, members and loans (borrowing/returning).

## Technology

The frontend is made with HTML, CSS, vanilla JavaScript and Bootstrap 5, which is loaded from a CDN. It works as a single-page application: the navigation changes the content without reloading the page. The backend is a PHP REST API built with FlightPHP, PDO and MySQL.

## Roles
- admin- full CRUD on all entities
- member- can view books and see their own loans



## Entities
Users, Authors, Categories, Books, Loans. ERD: it is added

## External API

The project uses the Open Library API to look up book information and covers. The backend endpoint is `GET /external/books?q=title`, which returns up to 5 results with title, author, first publish year, ISBN and cover URL. The request has a 5 second timeout. If Open Library is not available, the failure is written to `backend/logs/error.log` and the endpoint returns a friendly message with status 503, so the rest of the application keeps working. Open Library does not need an API key, so the config file only holds its URL and the timeout. The frontend feature that shows this data is connected in a later milestone. 
## Run the frontend locally
The SPA loads views with `fetch()`, so it needs a local web server (opening index.html directly will not work).I use the VS Code "Live Server" extension on `index.html`.

## Database schema (Milestone 2)

The database is called `library_db` and has five tables. The whole schema with sample data is in `backend/library_db.sql`.

| Table | Columns |
|---|---|
| users | id (PK), name, email (unique), password_hash, role (admin or member) |
| authors | id (PK), name, country |
| categories | id (PK), name, description |
| books | id (PK), title, isbn, copies, author_id (FK to authors), category_id (FK to categories) |
| loans | id (PK), user_id (FK to users), book_id (FK to books), loan_date, due_date, return_date, status (borrowed or returned) |

An author can write many books and a category can group many books. A user can have many loans and a book can be in many loans, so loans connect users and books.

![ERD](Er%20diagram.png)

## DAO layer (Milestone 2)

`backend/dao/BaseDao.php` has the reusable methods getAll, getById, insert, update and delete, all using PDO prepared statements. Each entity has its own class that extends it: UserDao, AuthorDao, CategoryDao, BookDao and LoanDao. The database credentials are read from `backend/config/config.php`, which is not committed. `backend/config/config.example.php` is the template.

## Test accounts

| Role | Email | Password |
|---|---|---|
| admin | admin@example.com | admin123 |
| member | amar@example.com | member123 |

The login itself will be implemented in a later milestone.

## Run the database locally

1. Start Apache and MySQL in XAMPP.
2. Open phpMyAdmin, click Import and import `backend/library_db.sql`. It creates the database `library_db` with the tables and sample data.
3. Copy `backend/config/config.example.php` to `backend/config/config.php` and enter your own MySQL username and password.

## Business logic and REST API (Milestone 3)

Each entity has a service in `backend/services/` that extends `BaseService`. The services hold the validation rules and are the only layer that calls the DAO classes. The routes in `backend/routes/` only call the services and return JSON.

Validation rules include:
- required fields and maximum lengths
- a valid email and a role of admin or member for users, with the password stored as a hash and never returned
- copies of a book must be a whole number of 0 or more, and the author and category must exist
- a loan needs an existing user and book, valid dates, a due date that is not before the loan date, and a book can only be borrowed while a copy is available

Every entity has these endpoints: `GET /authors`, `GET /authors/{id}`, `POST /authors`, `PUT /authors/{id}` and `DELETE /authors/{id}`, and the same for `/categories`, `/users`, `/books` and `/loans`. They return 200 for success, 201 when a record is created, 400 for invalid data, 404 when a record is not found and 500 for server errors. Status codes 401 and 403 are added with authentication and authorization in a later milestone.

## Run the API locally

1. Install Composer from getcomposer.org.
2. Open a terminal in the `backend` folder and run `composer install`. This downloads FlightPHP into the `vendor` folder, which is not committed.
3. Make sure `backend/config/config.php` exists (see above). You can add `open_library_url` and `api_timeout` from `config.example.php`.
4. Open `http://localhost/WebProgrammingProject-main/backend/authors` in the browser. It should show the authors as JSON.

## API documentation

The API is documented in `backend/openapi.json`. The Swagger page is at `http://localhost/WebProgrammingProject-main/backend/swagger/`. If your project folder has a different name, change the `servers` url in `openapi.json`.
