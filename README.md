# Sanskriti - Cultural Heritage Platform

A comprehensive web application dedicated to promoting and preserving India's rich cultural heritage through traditional crafts, cultural sites, and state-wise exploration.

## 🌟 Overview

Sanskriti is a web platform that showcases India's diverse cultural heritage by featuring:
- Traditional handicrafts and artisanal products from various states
- Cultural sites and monuments
- State-wise exploration of heritage
- E-commerce functionality for purchasing authentic cultural products
- User-friendly interface for exploring India's cultural diversity

## 🏛️ Features

### For Users
- **Cultural Exploration**: Browse cultural sites and monuments by state
- **Product Marketplace**: Purchase authentic traditional crafts and handicrafts
- **State-wise Navigation**: Explore different states and their cultural offerings
- **Shopping Cart**: Add products to cart and place orders
- **User Dashboard**: Manage personal information and orders

### For Retailers
- **Inventory Management**: Add, update, and manage product listings
- **Order Management**: Track and process customer orders
- **Dashboard**: View sales analytics and product performance

### For Administrators
- **Product Management**: Approve and manage retailer product submissions
- **User Management**: Oversee user accounts and activities
- **System Administration**: Maintain platform functionality

## 🛠️ Technical Stack

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL 

## 📁 Project Structure

```
Sanskriti/
├── Frontend Components
│   ├── homepage.php/css          # Landing page
│   ├── state.php/css             # State exploration
│   ├── mart.php/css/js           # Product marketplace
│   └── login.php/css             # User authentication
├── User Management
│   ├── register.php/css          # User registration
│   ├── user_dashboard.php/css    # User profile management
│   └── cart.php/css              # Shopping cart
├── Retailer Panel
│   ├── retailer_dashboard.php/css # Retailer management
│   ├── retailer_inventory.php/css # Inventory management
│   └── addProduct.php/css        # Product addition
├── Admin Panel
│   ├── Admin_dashboard.php/css   # Administrative controls
│   └── Product management        # Product approval system
├── Core Functionality
│   ├── db_connection.php         # Database connection
│   ├── Various action files      # Backend processing
│   └── Common components         # Header, footer
└── Assets
    ├── cultural_sites/           # Cultural site images
    ├── products/                 # Product images
    ├── state/                    # State representation images
    └── videos/                   # Promotional content
```

## 🚀 Installation & Setup

1. **Prerequisites**
   - XAMPP/WAMP/LAMP server
   - PHP 7.4 or higher
   - MySQL 5.7 or higher

2. **Database Setup**
   - Create a MySQL database named 'sanskriti'
   - Update database credentials in `db_connection.php`
   - Execute the SQL schema provided in the Database Schema section below
   - Populate initial data for States and Admin tables

3. **File Deployment**
   - Copy all files to your web server directory
   - Ensure proper file permissions
   - Configure web server to serve PHP files

4. **Configuration**
   - Update database connection settings
   - Configure file upload paths for product images
   - Set up proper directory permissions for asset uploads

##  Key Features Implementation

- **State-wise Exploration**: Dynamic content loading based on selected state
- **Product Management**: Complete CRUD operations for products
- **User Authentication**: Secure login/registration system
- **Shopping Cart**: Session-based cart management
- **Order Processing**: End-to-end order management system
- **Image Management**: Organized asset structure for cultural content

## 🗄️ Database Schema

The Sanskriti platform uses a MySQL database with the following structure:

### Database ER Diagram
![Database Schema](assets/schema/db_schema.jpg)
*Complete Entity-Relationship diagram showing all tables and their relationships*

### Core Tables

#### 1. **Users Table**
```sql
CREATE TABLE Users (
    ID varchar(10) PRIMARY KEY,
    Password varchar(255),
    Phone varchar(20),
    Email varchar(255),
    Name varchar(255),
    Street varchar(255),
    City varchar(255),
    State varchar(255),
    Pincode varchar(10),
    UserType enum('Customer','Retailer')
);
```

#### 2. **States Table**
```sql
CREATE TABLE States (
    ID varchar(10) PRIMARY KEY,
    Name varchar(255),
    Image varchar(255),
    About text,
    Lang varchar(255),
    Dance_Forms varchar(255),
    Cuisine varchar(255),
    Clothing varchar(255)
);
```

#### 3. **Products Table**
```sql
CREATE TABLE Products (
    ID varchar(10) PRIMARY KEY,
    Name varchar(255),
    Description text,
    Image varchar(255),
    Price decimal(10,2),
    Quantity int(11),
    StateID varchar(10),
    RID varchar(10),
    FOREIGN KEY (StateID) REFERENCES States(ID),
    FOREIGN KEY (RID) REFERENCES Retailer(RID)
);
```

#### 4. **Retailer Table**
```sql
CREATE TABLE Retailer (
    RID varchar(15) PRIMARY KEY,
    GST char(15),
    Status enum('Pending','Approved')
);
```

#### 5. **Pending Products Table**
```sql
CREATE TABLE pendingProducts (
    ID varchar(10) PRIMARY KEY,
    Name varchar(255),
    Description text,
    Image varchar(255),
    Price decimal(10,2),
    Quantity int(11),
    StateID varchar(10),
    RID varchar(15),
    FOREIGN KEY (StateID) REFERENCES States(ID),
    FOREIGN KEY (RID) REFERENCES Retailer(RID)
);
```

#### 6. **Cultural Sites Table**
```sql
CREATE TABLE Cultural_Site (
    ID varchar(10) PRIMARY KEY,
    Name varchar(255),
    Description text,
    Image varchar(255),
    Location varchar(255),
    StateID varchar(10),
    FOREIGN KEY (StateID) REFERENCES States(ID)
);
```

#### 7. **Cart Table**
```sql
CREATE TABLE Cart (
    ProductID varchar(10),
    CustID varchar(10),
    Quantity int(11),
    FOREIGN KEY (ProductID) REFERENCES Products(ID),
    FOREIGN KEY (CustID) REFERENCES Users(ID)
);
```

#### 8. **Orders Table**
```sql
CREATE TABLE Order (
    ID varchar(10) PRIMARY KEY,
    CustID varchar(10),
    Date date,
    Time time,
    Address text,
    FOREIGN KEY (CustID) REFERENCES Users(ID)
);
```

#### 9. **Products in Order Table**
```sql
CREATE TABLE Products_in_Order (
    OrderID varchar(10),
    ProductID varchar(10),
    Qty int(11),
    FOREIGN KEY (OrderID) REFERENCES Order(ID),
    FOREIGN KEY (ProductID) REFERENCES Products(ID)
);
```

#### 10. **Admin Table**
```sql
CREATE TABLE Admin (
    AdminID varchar(10) PRIMARY KEY,
    Name varchar(255),
    Password varchar(255),
    Email varchar(255),
    DateCreated timestamp
);
```

### Database Relationships

- **Users** can be either Customers or Retailers (UserType field)
- **Retailers** have additional information (GST, approval status)
- **Products** belong to specific states and are managed by retailers
- **Pending Products** await admin approval before moving to Products table
- **Cultural Sites** are associated with specific states
- **Cart** maintains user's selected products before checkout
- **Orders** track completed purchases with associated products
- **States** contain cultural information and serve as geographical categories

### Key Features of the Schema

1. **User Management**: Supports both customers and retailers in single table
2. **Product Approval Workflow**: Separate pending products table for admin review
3. **Geographic Organization**: State-based categorization for cultural content
4. **E-commerce Functionality**: Complete cart and order management
5. **Cultural Heritage**: Dedicated cultural sites linked to states
6. **Administrative Control**: Admin table for platform management

### Sample Data Population

To get started with the platform, you'll need to populate:
- States table with Indian states and cultural information
- Cultural_Site table with heritage sites for each state
- Admin table with administrative users
- Initial retailer registrations through the application

## 💡 Usage

### For End Users
1. Browse the homepage to explore cultural heritage
2. Navigate to specific states to discover local culture
3. Visit the marketplace to purchase authentic products
4. Create an account to manage orders and profile

### For Retailers
1. Register as a retailer
2. Access the retailer dashboard
3. Add products to your inventory
4. Manage orders and customer interactions

### For Administrators
1. Access the admin dashboard
2. Approve retailer product submissions
3. Manage user accounts and system settings
4. Monitor platform activity

## 🎯 Future Enhancements

- Integration with payment gateways
- Mobile-responsive design improvements
- Advanced search and filtering options
- Multi-language support
- Social media integration
- Enhanced admin analytics dashboard

## 🤝 Contributing

This project aims to preserve and promote India's cultural heritage. Contributions are welcome in the form of:
- Additional cultural sites and information
- New state coverage
- Product listings from artisans
- UI/UX improvements
- Bug fixes and feature enhancements



