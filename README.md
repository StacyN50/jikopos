# 🔥 JikoPOS

> A modern Point of Sale (POS) and Business Management System built to streamline sales, inventory, and business operations.

---

## 📌 Table of Contents

- [📖 Overview](#-overview)
- [🚀 Features](#-features)
- [🛠 Technologies Used](#-technologies-used)
- [📂 Project Structure](#-project-structure)
- [⚙️ System Requirements](#️-system-requirements)
- [🚀 Installation Guide](#-installation-guide)
- [🗄 Database Setup](#-database-setup)
- [▶️ Running the Project](#️-running-the-project)
- [👥 User Roles](#-user-roles)
- [📸 Screenshots](#-screenshots)
- [📈 Future Improvements](#-future-improvements)
- [🤝 Contributing](#-contributing)
- [📜 License](#-license)

---

# 📖 Overview

JikoPOS is a web-based Point of Sale and Inventory Management System designed for businesses to efficiently manage:

- Sales transactions
- Inventory tracking
- Customer records
- Employee management
- Reporting and analytics

The system provides a clean and responsive user interface suitable for shops, restaurants, supermarkets, and small businesses.

---

# 🚀 Features

## 🛒 Sales Management

- Process customer sales
- Generate receipts
- Manage invoices
- Track transactions

## 📦 Inventory Management

- Add and manage products
- Track stock levels
- Low stock alerts
- Product categorization

## 👥 Customer Management

- Store customer information
- Customer purchase history
- Loyalty tracking

## 👨‍💼 Employee & User Management

- Admin and cashier roles
- User authentication
- Secure login system

## 📊 Reports & Analytics

- Daily sales reports
- Revenue tracking
- Inventory reports
- Performance analytics

## 📱 Responsive Design

- Mobile-friendly UI
- Modern dashboard interface
- Easy navigation

---

# 🛠 Technologies Used

| Technology | Purpose |
|---|---|
| HTML5 | Structure |
| CSS3 | Styling |
| Tailwind CSS | UI Design |
| JavaScript | Frontend Interactivity |
| PHP | Backend Development |
| MySQL | Database Management |
| XAMPP | Local Development Environment |

---

# 📂 Project Structure

```bash
JikoPOS/
│
├── admin/
├── cashier/
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│
├── config/
│   └── db.php
│
├── database/
│   └── jikopos.sql
│
├── includes/
├── auth/
├── index.php
├── dashboard.php
└── README.md
```

---

# ⚙️ System Requirements

Before running the project, ensure you have:

- PHP 8+
- MySQL / MariaDB
- Apache Server
- XAMPP or WAMP
- Modern Web Browser

---

# 🚀 Installation Guide

## 1️⃣ Install XAMPP

Download and install XAMPP:

👉 https://www.apachefriends.org/download.html

After installation:

- Start **Apache**
- Start **MySQL**

from the XAMPP Control Panel.

---

## 2️⃣ Clone or Download the Project

### Using Git

```bash
git clone https://github.com/your-username/jikopos.git
```

### Or Download ZIP

Download the ZIP file and extract it inside:

```bash
C:/xampp/htdocs/
```

---

## 3️⃣ Move Project to htdocs

Ensure the project folder is located here:

```bash
C:/xampp/htdocs/JikoPOS
```

---

# 🗄 Database Setup

## 1️⃣ Open phpMyAdmin

Visit:

```bash
http://localhost/phpmyadmin
```

---

## 2️⃣ Create Database

Create a new database named:

```bash
jikopos
```

---

## 3️⃣ Import SQL File

Import the provided SQL file:

```bash
database/jikopos.sql
```

Steps:

- Select the `jikopos` database
- Click **Import**
- Choose the SQL file
- Click **Go**

---

# ⚙️ Configure Database Connection

Open:

```bash
config/db.php
```

Update database credentials if needed:

```php
<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "jikopos"
);

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
?>
```

---

# ▶️ Running the Project

After setup, open your browser and visit:

```bash
http://localhost/JikoPOS
```

---

# 👥 User Roles

## 🔑 Admin

Admin can:

- Manage products
- Manage employees
- View reports
- Manage inventory
- Configure system settings

---

## 💵 Cashier

Cashier can:

- Process sales
- Generate receipts
- View transactions

---

# 📸 Screenshots

Add screenshots here:

- Login Page
- Dashboard
- Sales Screen
- Inventory Management
- Reports Page

Example:

```markdown
![Dashboard Screenshot](assets/images/dashboard.png)
```

---

# 📈 Future Improvements

Planned features:

- Barcode scanner integration
- Mpesa payment integration
- Email receipts
- Multi-branch management
- REST API support
- Advanced analytics dashboard

---

# 🤝 Contributing

Contributions are welcome.

## Contribution Steps

1. Fork the repository

2. Create a new branch

```bash
git checkout -b feature-name
```

3. Commit changes

```bash
git commit -m "Added new feature"
```

4. Push changes

```bash
git push origin feature-name
```

5. Open a Pull Request

---

# 🔒 Security Notes

- Never expose database credentials publicly
- Use strong admin passwords
- Sanitize user inputs
- Enable HTTPS in production

---

# 📜 License

This project is licensed under the MIT License.

---

<div align="center">

## 🔥 JikoPOS

### Smart POS & Inventory Management System

Made with ❤️ by Stacy Nafula

</div>
