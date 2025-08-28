# Laravel 11 User & Roles API

This repository contains a Laravel 11 application designed to manage **users** and their associated **roles**.  
The project demonstrates how to set up a **RESTful API** where users can be created with multiple roles (e.g., Author, Editor, Subscriber, Administrator), validated, and fetched from the database with optional filters.

---

## 📋 Requirements

Before you begin, make sure the following software is installed on your machine:

- **PHP 8.2 or higher**  
  Laravel 11 requires modern PHP features such as enums and attributes, which are only available in PHP 8+.  

- **Composer**  
  This is the dependency manager for PHP that installs Laravel’s core packages and libraries.  

- **MySQL or MariaDB**  
  Used as the database engine to persist users, roles, and their relationships.  

- **Node.js & NPM (optional, for frontend)**  
  If you plan to build a React frontend to consume this API, you’ll need Node.js v18+ for React 18.  

---

## ⚙️ Installation Steps

1. **Clone the repository**  
   ```bash
   git clone https://github.com/gopalsharma01/laravel-user-roles.git
   cd laravel-user-roles
   ```

2. **Install PHP dependencies**  
   ```bash
   composer install
   ```

3. **Environment configuration**  
   ```bash
   cp .env.example .env
   ```
   Update `.env` with your database details.

   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=
   DB_USERNAME=
   DB_PASSWORD=
   ```

4. **Add API KEY in .env**
   ```bash
   API_KEY=
   ```
   same value use in frontend react

5. **Generate an application key**  
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations**  
   ```bash
   php artisan migrate
   ```

---

## 🚀 Running the Application

Start the Laravel development server:  
```bash
php artisan serve
```

The app will be available at:  
```
http://127.0.0.1:8000
```

---

## 📌 API Endpoints

### ➤ Create a User
- **Route:** `POST /api/users`  
- **Body Example:**
  ```json
  {
    "full_name": "Mark Jerks",
    "email": "mark@example.com",
    "roles": [1, 3]
  }
  ```

### ➤ Get All Users
- **Route:** `GET /api/users`  

### ➤ Get All Roles
- **Route:** `GET /api/roles`  

### ➤ Get Users by Role
- **Route:** `GET /api/users?role=2`  

---

## ✅ Roles Available

- **Author**  
- **Editor**  
- **Subscriber**  
- **Administrator**  

---

## 🔒 Notes on Security

- All inputs are validated.  
- Many-to-many relationships are managed via Eloquent `belongsToMany`.  
- Future security can be added via Laravel Sanctum, Passport, or JWT.  

---

## 🏁 Summary

This README walks you through setting up a Laravel 11 project, configuring the environment, running migrations, serving the app, and testing API endpoints.
