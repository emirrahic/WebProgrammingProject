# AGENTS.md

## Project
Library Book Management System: a web application for managing a library's books, authors, categories, members and loans (borrowing and returning), for librarians and library members.
Roles: admin, member. Entities: users, authors, categories, books, loans.
External API: Open Library (book info and covers), planned for Milestone 3.
Current milestone: 2 (database and DAO layer).

## Technology stack
- Frontend: HTML, CSS, vanilla JavaScript, Bootstrap 5 (CDN), single-page application (SPA). No jQuery, no frameworks.
- Backend: PHP with FlightPHP (REST API), PDO, MySQL, JWT authentication, OpenAPI/Swagger
- Local server: XAMPP

## Folder structure
- index.html: the SPA entry point, in the project root
- frontend/: css/, js/, views/ (one HTML file per view), static/ (images)
- backend/: routes/, services/, dao/ (BaseDao and one DAO class per entity), middleware/, config/ (config.example.php is committed, config.php is not), logs/, library_db.sql (database export with sample data)
- docs/: AI_LOG.md and other documentation
- .github/agents/: custom agents. .agents/skills/: skills

## Frontend rules
- Each view is in its own file in frontend/views/. index.html loads them without page reloads.
- Use Bootstrap 5 classes; avoid inline styles. Theme: black and white, mobile friendly.
- Keep the JavaScript beginner-level: plain functions and loops, no advanced concepts.
- Do not write code comments.
- Static data is only in frontend/js/data.js until the backend is connected (Milestone 4).
- Frontend code never contains PHP or SQL.

## Backend rules
- Requests go: route -> service -> DAO -> database.
- Only services call DAO classes. Routes never call DAO classes directly.
- All SQL uses PDO prepared statements.
- Routes return JSON with correct HTTP status codes.
- Every DAO class extends BaseDao and lists the columns that may be written. Table and column names come only from DAO code, never from user input.
- Database credentials are read from backend/config/config.php. Keep config.example.php in sync with it, with no real values.
- Middleware (authentication, role check, request logging, error handling) is reusable and registered in FlightPHP.

## Conventions
- PHP classes: PascalCase (UserService, UserDao). Files are named after the class.
- JavaScript and PHP variables: camelCase. Database tables and columns: snake_case, tables in plural.
- API routes: plural nouns (/books, /loans).

## Rules for AI assistants
- Only work on the current milestone and do not add extra features.
- Do not add new libraries or frameworks without asking me first.
- Do not change the database schema without asking me first.
- Never put passwords, keys or secrets in code; they belong in backend/config/config.php, which is not committed. Keep config.example.php updated instead.
- Do not edit files in backend/logs/.
- Make small changes and explain what you changed and why.
