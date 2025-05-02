# Pension Management System

A simple, responsive pension management system where users can register, log in, and view their pension details using a unique One ID.

## Features

- 🔐 User Registration & Login with One ID
- 📋 Dashboard displaying pension details
- 💰 Pension Calculator
- 📊 Pensioners List View
- 🎨 Responsive UI with Tailwind CSS
- ⚡ Interactive Frontend using JavaScript

## Tech Stack

- Frontend: HTML, Tailwind CSS, JavaScript
- Backend: PHP
- Database: MySQL

## Setup Instructions

1. Make sure you have XAMPP installed with PHP and MySQL.

2. Clone this repository to your XAMPP's htdocs directory:
   ```
   cd /xampp/htdocs
   git clone [repository-url] newpp
   ```

3. Create the database and tables:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import the `database.sql` file

4. Configure the database connection:
   - Open `config.php`
   - Update the database credentials if needed (default uses root with no password)

5. Start XAMPP's Apache and MySQL services

6. Access the application:
   - Open your browser and navigate to: http://localhost/newpp

## Default Test Account

- One ID: ONE123456
- Password: password123

## Security Features

- Password hashing using PHP's password_hash()
- SQL injection prevention using prepared statements
- Session-based authentication
- Input validation and sanitization

## License

This project is licensed under the MIT License.
