# Laravel Project

## Introduction
This is a Laravel-based project that provides [brief description of the project].

## Requirements
Ensure you have the following installed before setting up the project:
- PHP 8.x
- Composer
- MySQL or PostgreSQL
- Node.js & npm (if using frontend assets)
- Laravel 10+
- Git

## Installation Guide

### Step 1: Clone the Repository
```sh
git clone https://github.com/your-repo/project.git
cd project
```

### Step 2: Install Dependencies
Run the following command to install PHP dependencies:
```sh
composer install
```
If the project uses npm dependencies, install them as well:
```sh
npm install
```

### Step 3: Set Up Environment
Copy the `.env.example` file and configure your environment variables:
```sh
cp .env.example .env
```
Generate the application key:
```sh
php artisan key:generate
```

### Step 4: Configure Database
Update the `.env` file with your database credentials, then run:
```sh
php artisan migrate --seed
```


### Step 6: Run the Application
Start the Laravel development server:
```sh
php artisan serve
```
If using Vite for frontend assets:
```sh
npm run dev
```
Now, visit `http://127.0.0.1:8000` in your browser.

## Default login credential
```sh
email: admin@gmail.com
password: 12345678
```

Optimize Application
```sh
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Additional Commands

- **Clear Cache**:
  ```sh
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  ```
## License
This project is licensed under the [MIT License](LICENSE).
