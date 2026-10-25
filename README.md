# Library Book Management System

University web project (PHP + JS + MySQL). **Current stage: Milestone 1** (project setup, static SPA frontend, ERD draft).

## Description
A web app for managing a library: books, authors, categories, members and loans (borrowing/returning).

## Technology

The frontend is made with HTML, CSS, vanilla JavaScript and Bootstrap 5, which is loaded from a CDN. It works as a single-page application: the navigation changes the content without reloading the page. The backend will be added in the next milestones.

## Roles
- admin- full CRUD on all entities
- member- can view books and see their own loans



## Entities
Users, Authors, Categories, Books, Loans. ERD: it is added

## External API

An external API is not implemented yet.The plan is to use the Open Library API to look up book information and covers when adding a book. 
## Run the frontend locally
The SPA loads views with `fetch()`, so it needs a local web server (opening index.html directly will not work).I use the VS Code "Live Server" extension on `index.html`.



