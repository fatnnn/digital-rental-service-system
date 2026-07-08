# Digital Rental Service System

A web-based rental management system built with **CodeIgniter 3** that helps businesses manage rental items, customers, transactions, and user access control efficiently.

## 🚀 Features

### User Management

* User authentication and login
* User account management
* User activation and deactivation
* Role-based access control

### Role Management

* Superadmin role
* Admin role

### Member Management

* Add new members
* Update member information
* Delete members
* View member records

### Rental Item Management

* Add rental items
* Edit rental items
* Delete rental items
* Stock monitoring

### Rental Transaction Management

* Create rental transactions
* Record rental dates
* Record return dates
* Track rental status

---

## 🛠 Technology Stack

### Backend

* PHP
* CodeIgniter 3
* MySQL

### Frontend

* Bootstrap
* JavaScript
* jQuery
* AJAX
* KnockoutJS

### Database

* MySQL / MariaDB

---

## 👥 User Roles

### Superadmin

The Superadmin has full access to all system features, including:

* User management
* Role management
* Member management
* Rental item management
* Rental transaction management
* System-wide monitoring and reporting

### Admin

The Admin is responsible for operational activities, including:

* Member management
* Rental item management
* Rental transaction management

---

## 🗄 Database Structure

Database Name: `digital_rental`

### Table: `roles`

Stores user role information.

| Column    | Type        |
| --------- | ----------- |
| id        | INT         |
| role_name | VARCHAR(20) |

Default Data:

| id | role_name  |
| -- | ---------- |
| 1  | Superadmin |
| 2  | Admin      |

---

### Table: `users`

Stores user account information.

| Column     | Type         |
| ---------- | ------------ |
| id         | BIGINT       |
| role_id    | INT          |
| username   | VARCHAR(100) |
| password   | VARCHAR(255) |
| active     | TINYINT      |
| created_at | TIMESTAMP    |

Relationship:

* role_id → roles.id

---

### Table: `members`

Stores rental member information.

| Column       | Type         |
| ------------ | ------------ |
| member_id    | INT          |
| name         | VARCHAR(100) |
| address      | TEXT         |
| phone_number | VARCHAR(20)  |

---

### Table: `items`

Stores rental item information.

| Column    | Type         |
| --------- | ------------ |
| item_id   | INT          |
| item_name | VARCHAR(200) |
| stock     | INT          |

---

### Table: `rentals`

Stores rental transaction data.

| Column      | Type        |
| ----------- | ----------- |
| rental_id   | INT         |
| member_id   | INT         |
| item_id     | INT         |
| rental_date | DATE        |
| return_date | DATE        |
| status      | VARCHAR(50) |

Relationships:

* member_id → members.member_id
* item_id → items.item_id

---

## 🔗 Database Relationships

```text
roles
  │
  └── users

members
  │
  └── rentals
         │
         └── items
```

---

## 📦 Installation

### 1. Clone Repository

```bash
git clone https://github.com/your-username/digital-rental-service-system.git
```

### 2. Navigate to Project Directory

```bash
cd digital-rental-service-system
```

### 3. Create Database

```sql
CREATE DATABASE digital_rental;
```

### 4. Import Database

Import the provided SQL file into MySQL:

```text
digital_rental.sql
```

You can use phpMyAdmin, MySQL Workbench, or the MySQL command line.

### 5. Configure Database Connection

Edit:

```php
application/config/database.php
```

Example:

```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'digital_rental',
    'dbdriver' => 'mysqli'
);
```

### 6. Configure Base URL

Edit:

```php
application/config/config.php
```

```php
$config['base_url'] = 'http://localhost/digital-rental-service-system/';
```

### 7. Run the Application

Open your browser and visit:

```text
http://localhost/digital-rental-service-system
```

---

## 📋 Modules

* Dashboard
* Authentication
* User Management
* Role Management
* Member Management
* Rental Item Management
* Rental Transaction Management
* Rental Status Monitoring

---

## 🎯 Project Objectives

The Digital Rental Service System aims to digitize rental business operations by:

* Organizing rental data efficiently
* Simplifying inventory management
* Improving transaction accuracy
* Enhancing security through role-based access
* Reducing manual record-keeping

---

## 📄 License

This project is licensed under the MIT License.

---

## 👨‍💻 Built With

* CodeIgniter 3
* MySQL
* Bootstrap
* JavaScript
* jQuery
* AJAX
* KnockoutJS
