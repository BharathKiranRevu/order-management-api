# Order Management System REST API

## Overview
This is a **REST API** for a basic Order Management System built using **CodeIgniter 4**.  
It includes modules for **User Authentication**, **Product Management**, **Order Creation**, and **Order Listing**.

The project demonstrates real-world backend skills in:

- MVC structure
- Validation
- Database queries and relationships
- Migrations and seeders
- Clean coding and error handling

---

## Features

- **User Authentication** (session-based)
- **Product CRUD** with validation
- **Order Creation** with stock management and total calculation
- **Order Listing** with user info and items
- **Database migrations and seeders**
- **JSON error responses**

**Bonus Features (if implemented):**

- Product search and filters
- Order cancel with stock rollback
- Pagination for products and orders
- Basic Role-Based Access Control (admin/user)

---

## Requirements

- PHP 8.x
- MySQL 5.7+
- Composer
- CodeIgniter 4

---

## Installation

1. **Clone the repository**

```bash
git clone https://github.com/BharathKiranRevu/order-management-api.git
cd order-management-api


# Install dependencies

-- composer install

# Set up environment

Copy the .env file

cp env .env  

- database.default.hostname = localhost
database.default.database = your_db_name
database.default.username = root
database.default.password = 

#Run Migrations and Seeders

php spark migrate
php spark db:seed TestSeeder

#Start the server

php spark serve

#API will be available at: 

#http://localhost:8080

#Thank You !!