# FoodHub — Online Food Ordering Platform

A complete food ordering system built with **Laravel 11** for the **Rhombix Technologies Web Development Internship — Task 2**.

## 🚀 Features

### 👤 User Side
- 🔐 Register / Login
- 🏠 Home page with featured items
- 🍽️ Browse menu with search & category filter
- 📄 Item detail page with quantity selector
- 🛒 Add to Cart (AJAX — no page reload)
- 📦 Cart with quantity update & remove
- 💳 Checkout with COD / Easypaisa
- ✅ Order confirmation
- 📋 My Orders (with real-time status)

### 🛡️ Admin Panel
- 📊 Dashboard (orders, revenue, items, customers)
- 📂 Categories CRUD
- 🍽️ Menu Items CRUD (with image upload)
- 📦 Orders Management (status update)
- 👥 Users Management

### 🔧 Technical
- REST APIs (AJAX cart updates)
- Toast notifications
- Form validation
- Responsive design
- Role-based access (Admin / User)

## 🛠️ Tech Stack

| Component | Technology |
|-----------|-----------|
| Framework | Laravel 11 |
| Language | PHP 8.2 |
| Database | MySQL |
| Frontend | Blade + Tailwind CSS (CDN) |
| Authentication | Laravel Breeze |
| Roles | Spatie Laravel Permission |

## ⚙️ Installation

```bash
git clone https://github.com/YOUR_USERNAME/RhombixTechnologies_Tasks.git
cd RhombixTechnologies_Tasks
composer install
npm install
cp .env.example .env
php artisan key:generate

# Configure database in .env
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve