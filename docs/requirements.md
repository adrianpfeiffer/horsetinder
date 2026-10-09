# Project Requirements (University Assignment)

## A. Code management

- You **use git**, and link your repository to a publicly accessible Git repo (aka **GitHub**)
- You use as much as possible **atomic commits** that group small functional increments

## B. Application

- Your implementation is **in line with the application description** that you submitted.
- Your application data structure is an implementation of the data structure in your description. If your idea goes really broad, it's ok to have only a subset implemented

### Model

- **At least 3 models** (including the `User` model)
- Implement **at least one 1-N relationship** (but more is recommended)
- For every model, you have a `Model`, a `Migration` and a `Factory`
- In your app, your factories are called in the `DatabaseSeeder`

### Routes/controllers

- Every route is linked to a controller function
- You implement for **at least one model a full CRUD** (all 7 methods)
- You validate every input coming from a user
- Your forms give feedback to the user if invalid input was submitted

### Authentication

- A **user can login** and/or register for an account
- You use the info from the logged in user at least once in a view
- You use the info from the logged in user at least once in a controller (authorisation and/or business logic)

### Views

- You make use of a layout for the common elements
- You have the necessary views for the functionality needed in your app
- You will **not be evaluated on the esthetical qualities** of your designs *(but yes please, a bit of design is always nicer)*

### Seeded data

- Seed everything that is needed in your DatabaseSeeder.
- Additionally, seed a dummy admin user (admin@admin.com) with `password` as the password

## How the application will be evaluated/tested

- The web app will be installed locally on the evaluator's computer
- They will run `php artisan migrate:fresh --seed` to get fake data (unless explicitly instructed otherwise)
- They will visit the welcome page - this needs to contain something relevant to the application
- They will visit the other routes; logged-in routes will be visited as the admin@admin.com user

## How the project will be defended

- Bring your computer, with the code editor (IDE) and a browser open on the project
- 15 minute chat about the application:
    - May be asked to find a specific functionality and explain it
    - May be asked to make a small live change to the code and show the result
    - …
