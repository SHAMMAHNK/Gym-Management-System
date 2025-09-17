# Gym Management System

A web-based gym management system built with PHP, MySQL, HTML, CSS, and JavaScript.

## Features

- User registration and login
- Membership management
- Class booking
- Dashboard for members
- Responsive design

## Prerequisites

- XAMPP (or any web server with PHP and MySQL support)
- Web browser

## Installation and Setup

### 1. Install XAMPP

Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/).

### 2. Clone or Download the Project

Place the project files in `C:\xampp\htdocs\Gym-Management-System\` (or your XAMPP htdocs directory).

### 3. Start XAMPP

- Open XAMPP Control Panel
- Start Apache and MySQL services

### 4. Create the Database

- Open your browser and go to `http://localhost/phpmyadmin/`
- Create a new database named `gym`
- Import the `gym_database.sql` file:
  - Select the `gym` database
  - Go to the "Import" tab
  - Choose the `gym_database.sql` file
  - Click "Go"

### 5. Configure Database Connection

The database connection is already configured in `connect.php`:
- Host: localhost
- Port: 3307 (change to 3306 if using default MySQL port)
- Database: gym
- Username: root
- Password: (empty)

If your MySQL setup is different, update the variables in `connect.php`.

### 6. Access the Application

Open your browser and go to `http://localhost/Gym-Management-System/`

## Usage

### Signup
- Go to `signup.html`
- Fill in the registration form
- Submit to create an account

### Login
- Go to `login.html`
- Enter your email and password
- Login to access the dashboard

## What We Implemented

### Fixed Login Functionality
- **login.php**: Rewrote the login handler to properly authenticate users
  - Uses prepared statements for security
  - Verifies passwords with `password_verify()`
  - Starts sessions on successful login
  - Redirects to dashboard
- **login.html**: Updated form action to point to `login.php`

### Maintained Signup Functionality
- **register.php**: Form-based signup (existing, working)
- **signup.php**: JSON API signup (fixed include path to use `connect.php`)
- Both use secure password hashing with `password_hash()`

### Database
- **gym_database.sql**: Complete SQL schema for the `users` table
  - Includes all necessary fields for user data
  - Sample user for testing

### Architecture
- PHP backend with MySQL database
- HTML/CSS/JS frontend
- Session-based authentication
- Prepared statements for SQL security

## File Structure

```
Gym-Management-System/
├── index.html          # Home page
├── login.html          # Login page
├── login.php           # Login handler
├── signup.html         # Signup page
├── register.php        # Signup handler (form)
├── signup.php          # Signup handler (JSON API)
├── dashboard.html      # User dashboard
├── connect.php         # Database connection
├── gym_database.sql    # Database schema
└── [other HTML files]  # Additional pages
```

## Troubleshooting

- **Database connection errors**: Check MySQL port and credentials in `connect.php`
- **Signup/login not working**: Ensure the database is created and tables are imported
- **Page not loading**: Make sure Apache is running in XAMPP

## Security Notes

- Passwords are hashed using PHP's `password_hash()` and `password_verify()`
- SQL injection prevention with prepared statements
- Input validation on forms

## Contributing

Feel free to improve the code and add new features!
