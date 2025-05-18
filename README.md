# Customer & Invoice Management System

A simple yet powerful customer and invoice management portal built with Laravel, Laravel Breeze authentication, Blade templates, and JavaScript.

## Features

- **User Authentication**: Secure admin login with Laravel Breeze
- **Dashboard**: Overview of key metrics (total customers and invoices)
- **Customer Management**:
  - Add new customers with name, phone, email, and address details
  - View all customers in a table format
  - Edit customer information
- **Invoice Management**:
  - Create invoices linked to specific customers
  - View all invoices with customer name, date, amount, and status
  - Edit invoice details
  - Track payment status (Paid/Unpaid/Cancelled)

## Tech Stack

- **Backend**: Laravel 10.x
- **Authentication**: Laravel Breeze
- **Frontend**: 
  - Blade Templates
  - JavaScript
  - CSS
- **Database**: MySQL

## Installation

1. Clone the repository
```bash
git clone https://github.com/jinuvarghese-cmd/customer-invoice-management.git
cd customer-invoice-management
```

2. Install PHP dependencies
```bash
composer install
```

3. Create and configure your .env file
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Configure your database in the .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

6. Run migrations
```bash
php artisan migrate --seed
```

7. Install frontend dependencies and build assets
```bash
npm install
npm run dev
```

8. Start the development server
```bash
php artisan serve
```

9. Acess the url - http://127.0.0.1:8000

10. Login using these credentials -
```bash
user - admin@eallisto.com
password - password
php artisan serve
```


