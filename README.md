# User Balances Application

## Project Description

This project is a web application to manage user balances using the following technologies:

- **Backend**: PHP 8.4, Laravel 12
- **Database**: Postgres / MySQL
- **Frontend**: Vue 3 Inertia.js
- **Tools**: Laravel Vite for JS and CSS/SCSS

## Backend Features

- **Artisan Commands**:
    - Add users
    - Perform balance operations (credit/debit) by username with a description, ensuring the balance does not go negative.

## Setup

1. Clone the repository.
2. Run `composer install`.
3. Run `cp .env.example .env`.
4. Run `sail up -d`.
5. Run `sail artisan migrate`.
6. Run `sail artisan app:create-user`.
7. Run `sail npm i`.
8. Run `sail npm run dev`.

For queue to work, run `sail artisan queue:work`.

Now you can visit the application at [http://localhost](http://localhost).
