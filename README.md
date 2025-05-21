# ZAYAS Simple E-commerce Website

A simple e-commerce website for ZAYAS clothing store, built with PHP following the MVC architecture pattern.

**Developed by: ZAYNAB AITADDI and ASMAE DAOUAD**

## 📝 Project Overview

ZAYAS Simple is a lightweight e-commerce platform specifically designed for clothing retail, with a focus on Islamic fashion items like abayas, dresses, and hijabs. The application follows the Model-View-Controller (MVC) architecture pattern to ensure maintainable and scalable code structure.

## ✨ Features

- **User Authentication**
  - Register, login, and logout functionality
  - Password reset capability
  - User account management

- **Product Management**
  - Browse products with filtering options
  - Detailed product view
  - Image gallery

- **Shopping Experience**
  - Shopping cart functionality
  - Wishlist management
  - Order processing and tracking

- **Delivery System**
  - Delivery personnel portal
  - Dashboard with delivery statistics
  - Delivery status updates

- **Order Status System**
  - Comprehensive order status tracking
  - Multiple status options (Pending, Assigned, In-Transit, etc.)
  - Status flow management

- **Responsive Design**
  - Mobile-friendly interface
  - Bootstrap 5 integration

## 🗄️ Database Structure

- **`users`** - User information and authentication
- **`products`** - Product details
- **`orders`** - Order information
- **`order_items`** - Items in each order
- **`wishlist`** - User wishlist items
- **`delivery`** - Delivery information
- **`cart`** - Shopping cart items
- **`password_reset_tokens`** - Password reset functionality

## 🚀 Setup Instructions

### Automatic Setup
1. Place the project in your web server's document root (e.g., `xampp/htdocs/ZAYAS_simple`)
2. Ensure your MySQL server is running (e.g., through XAMPP control panel)
3. Navigate to `http://localhost/ZAYAS_simple/setup.php` in your web browser
4. Click on "Set Up Database" to create the database, tables, and sample data
5. Once setup is complete, click on "Go to Website" to access the application
6. Alternatively, access the website directly at `http://localhost/ZAYAS_simple`

### Manual Configuration
If you need to manually configure the database:
- Configure database connection in `config/Database.php`
- Default configuration:
  - Host: localhost
  - Username: root
  - Password: (empty)
  - Database: zayas_simple
- You can also run the SQL scripts directly from the provided SQL file

## 💻 Technologies Used

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**:
  - HTML
  - CSS
  - JavaScript (minimal)
  - Bootstrap 5

## 📊 Order Status System

### Order Statuses

The system uses the following order statuses:

1. **Pending** - Order placed but not yet assigned to delivery personnel
2. **Assigned** - Order assigned to a delivery person but not yet in transit
3. **In-Transit** - Order is on the way to the customer
4. **Delivered** - Order successfully delivered to the customer
5. **Cancelled** - Order cancelled before customer receipt
6. **Returned** - Order returned after delivery

### Status Flow

**Typical Flow**:
```
Pending → Assigned → In-Transit → Delivered
```

**Alternative Flows**:
```
Pending → Cancelled
Pending → Assigned → Cancelled
Pending → Assigned → In-Transit → Cancelled
Pending → Assigned → In-Transit → Delivered → Returned
```

### Implementation Details

- Status stored in `orders` table in the `status` column
- Delivery status stored in `delivery` table in the `delivery_status` column
- Both columns use ENUM data types with the values: 'pending', 'assigned', 'in_transit', 'delivered', 'cancelled', 'returned'

### Database Update Script

To update an existing database to use the new status system:

```sql
-- Update orders table to use the new status values
ALTER TABLE orders 
MODIFY COLUMN status ENUM('pending', 'assigned', 'in_transit', 'delivered', 'cancelled', 'returned') DEFAULT 'pending';

-- Update delivery table to use the new status values
ALTER TABLE delivery
MODIFY COLUMN delivery_status ENUM('pending', 'assigned', 'in_transit', 'delivered', 'cancelled', 'returned') DEFAULT 'pending';

-- Update any existing 'processing' status to 'assigned'
UPDATE orders SET status = 'assigned' WHERE status = 'processing';

-- Update any existing 'shipped' status to 'in_transit'
UPDATE orders SET status = 'in_transit' WHERE status = 'shipped';
```

## 🚚 Delivery System

### Features

- Delivery personnel login portal
- Dashboard with delivery statistics
- View and manage assigned deliveries
- Update delivery status
- Profile management

### Setup

1. Ensure the main ZAYAS e-commerce system is set up and running
2. Update the database schema by running the commands in `setup.sql`
3. Create delivery personnel accounts by setting `is_delivery = 1` in the users table
4. Assign deliveries to personnel using the admin interface

### Usage

1. Delivery personnel login at `/delivery/login.php`
2. After login, they are redirected to their dashboard
3. They can view and manage assigned deliveries
4. They can update delivery status as needed

### Delivery Status Flow

**Typical Flow**:
```
Assigned → In-Transit → Delivered
```

**Alternative Flow**:
```
Assigned → In-Transit → Delivered → Returned
```

**Note**: Delivery personnel cannot cancel orders. Cancellations can only be done by administrators.

### Integration with Admin System

- Admin assigns deliveries to delivery personnel
- Delivery personnel update delivery status
- Admin can view all deliveries and their status
- Status changes are synchronized between delivery and admin systems

## 👤 Default Accounts

### Admin Account
- Email: admin@zayas.com
- Password: 123456

---

© 2025 ZAYAS Simple E-commerce