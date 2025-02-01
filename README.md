<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Blog API - Laravel (DDD & Onion Architecture)

## Overview
This project is a **RESTful API** for a **blog system**, built with **Laravel** and following the **Domain-Driven Design (DDD)** principles, as well as the **Onion Architecture**. The project structure is heavily inspired by **Spatie's DDD approach**, ensuring separation of concerns and maintainability.

## Project Structure
The project is divided into three main namespaces:

### **1. App Layer (Application Layer)**
Located in `app/App/`, this layer is responsible for handling both API and CLI interactions. It consists of two main applications:

- **Blog Application (`app/App/Blog/`)**: Handles HTTP requests for the REST API.
  - **Controllers**: Manage API requests and delegate business logic to domain actions.
  - **Requests**: Handle request validation.
  - **Resources**: Transform domain data into API responses.

- **Console Application (`app/App/Console/`)**: Handles CLI-based interactions.
  - **Commands**: Define artisan commands for data manipulation and exports.
  - **Concerns**: Provide shared functionalities for console commands.

#### Example:
- `app/App/Blog/Controllers/ArticleController.php` → Handles API routes related to articles.
- `app/App/Blog/Requests/ArticleRequest.php` → Validates article input.
- `app/App/Blog/Resources/Blog/ArticleResource.php` → Formats the API response.
- `app/App/Console/Commands/ExportEntities.php` → Handles CLI export commands.
- `app/App/Console/Commands/Concerns/TransformsDataToCsv.php` → Provides CSV transformation utilities.

### **2. Domain Layer (Business Logic Layer)**
Located in `app/Domain/`, this layer contains the core business logic and domain entities.

- **Actions**: Encapsulate business operations as separate classes.
- **Data**: Define structured data objects using Laravel Data.
- **Models**: Represent domain entities and handle persistence.
- **Policies**: Manage authorization rules.

#### Example:
- `app/Domain/Blog/Actions/CreateArticle.php` → Handles article creation.
- `app/Domain/Blog/Data/ArticleData.php` → Defines article data structure.
- `app/Domain/Blog/Models/Article.php` → Represents the article entity.

### **3. Support Layer (Infrastructure & Providers)**
Located in `app/Support/`, this layer contains framework-specific implementations, service providers, and shared utilities.

- `app/Support/Providers/AppServiceProvider.php` → Registers services.
- `app/Support/Providers/FactoryServiceProvider.php` → Handles model factories.

## Design Principles
### **1. Domain-Driven Design (DDD)**
The application follows the **DDD principles**, ensuring that business logic is at the core of the system:
- **Entities**: Defined in the `Models` namespace (e.g., `Article.php`, `Author.php`).
- **Value Objects**: Encapsulated within `Data` classes.
- **Use Cases (Actions)**: Encapsulated in the `Actions` namespace.
- **Bounded Contexts**: Blog and User are treated as separate domains.

### **2. Onion Architecture**
The project adheres to **Onion Architecture**, ensuring clear separation of concerns:
- **The Domain Layer** (core business logic) has no dependencies on the framework.
- **The Application Layer** depends on the domain but not vice versa.
- **The Infrastructure Layer** provides framework-specific implementations.

## API Endpoints
The application exposes various REST API endpoints for managing articles, authors, and topics. Example:

```
GET /api/articles       # Retrieve all articles
POST /api/articles      # Create a new article
GET /api/articles/{id}  # Retrieve a specific article
PUT /api/articles/{id}  # Update an article
DELETE /api/articles/{id} # Delete an article
```

## Installation
### Prerequisites
- PHP 8.4+
- Laravel 11+
- Composer
- sqlite

### Setup
```bash
# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Run tests
composer test

# Run code style checks (pint)
composer cs

# Run static analysis (phpstan)
composer analyse

# Start the application
php artisan serve
```

## Contributing
Feel free to contribute by submitting issues or pull requests. 

## License
This project is licensed under the MIT License.

