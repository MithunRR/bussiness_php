
## Create the Database and Tables

CREATE DATABASE IF NOT EXISTS admin;
USE admin;

## Create the businesses table:

CREATE TABLE businesses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

**Create the ratings table:**

CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    business_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    rating DECIMAL(2,1) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (business_id) REFERENCES businesses(id)
);

_________________________________________________________

## Update Database Credentials (if needed)

host — usually `127.0.0.1`
user — usually `root`
password — `password`
database — `admin`
port — `3306`

_____________________________________________________________

## Start the Application

Open your terminal, navigate to the project folder and run:

cd C:\Users\yourname\Desktop\admin
php -S localhost:8000

url --
http://localhost:8000

_________________________________

## Project Structure
admin/
    config/
        database.php             --> Database connection
    controllers/
        BusinessController.php   --> Add, edit, delete, view functions
        RatingController.php     --> Rating submissions
    models/
        Business.php             --> Business modal 
        Rating.php               --> Rating table
    public/
        css/
            style.css            --> styles
        js/
            app.js               --> JS logic
    views/
        header.php               --> HTML header, navbar, CSS 
        footer.php               --> JS includes, closing tags
        business_list.php        --> Main page with table and modals
    index.php                    --> Entry point
    admin_backup.sql

__________________________________________________

## Technologies Used

- Core PHP
- MySQL
- jQuery
- Bootstrap 5
- Raty jQuery Plugin
