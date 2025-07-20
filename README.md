
# Scandiweb Project — Backend 🚀

Repository for the **PHP GraphQL backend** supporting the Scandiweb Full‑Stack Developer test task.

---

## 🧠 Overview

This backend provides a GraphQL API to support product listing, categories, attributes, and order creation. It is built with:

- **PHP 7.4+ / 8.1+**  
- **MySQL 5.6+**  
- **No frameworks** (no Laravel/Symfony)  
- **OOP, PSR‑1/12/4 compliant**  
- **GraphQL** schema with queries, types, and mutations  

---

## 📦 Installation & Setup

1. Clone this repo:
   ```bash
   git clone https://github.com/gbazera/scandiweb_project_backend.git
   cd scandiweb_project_backend
   ```

2. Install dependencies via Composer:
   ```bash
   composer install
   ```

3. Copy the `.env.example` to `.env`, then configure:
   ```dotenv
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=scandiweb
   DB_USERNAME=root
   DB_PASSWORD=<password>
   ```

4. Create the MySQL database and import product data.

5. Run the app (using the built-in PHP server):
   ```bash
   php -S localhost:8080 -t public
   ```

6. Access the GraphQL playground at:
   ```
   http://localhost:8080/graphql
   ```

---

## 🔍 API Endpoints

### **GraphQL Queries**
- `categories`: lists `all`, `clothes`, `tech`
- `products(category: String!)`: fetch products in a category
- `product(id: String!)`: fetch detailed product by ID

### **Mutations**
- `createOrder(input: OrderInput!)`: place an order  
   - Args: `total`, `items` (list of products with `product_id`, `quantity`, `price`, `attributes`)

---

## 🧩 Architecture & Design Decisions

- **Models**:
  - `Category`, `Product`, `Attribute`, etc.
  - Implemented via abstract classes and subclasses — no `switch` or `if` to differentiate types

- **GraphQL Layer**:
  - Uses a lightweight, custom schema loader & resolver system (no Laravel)
  - Explicit separation of concerns: types, resolvers, etc.

- **Order Persistence**:
  - Orders stored in `orders` table with serialized attributes

---

## 🤝 Credits

Developed by **gbazera** for the Scandiweb Junior Full‑Stack Developer test task.

---
