# Collaboration Supplier

---

## Overview
This web-based project is a supplier collaboration system built with PHP. It enables streamlined communication between procurement employees and suppliers, enhancing data management for company devices and procurement workflows.

---

## Features
- Supplier registration and management.
- Dynamic dropdown fields for procurement employee selection.
- Device inventory and collaboration workflows.
- Secure session handling and authentication.

---

## Prerequisites
Ensure you have the following installed:
- **PHP 7.4+**.
- **MySQL Database**.
- A web server like **Apache** or **Nginx**.
- **phpMyAdmin** (optional for database management).

---

## Installation and Usage
1. Clone the repository:
   ```bash
   git clone https://github.com/jeremymordecai628/collaboration_supplier.git
   cd collaboration_supplier
   ```
2. Configure your database:
   - Import the `supplier_collaboration.sql` file into MySQL.
   - Update database credentials in `config.php`.

3. Deploy to your server:
   - Place files in your web server’s root directory (e.g., `/var/www/html/`).
   - Access the application via `http://localhost/collaboration_supplier`.

---

## File Structure
- **index.php**: Main entry point for the system.
- **config.php**: Database connection configuration.
- **dashboard.php**: Dashboard for managing suppliers and devices.
- **styles/**: CSS files for design.

---

## Contributing
Feel free to open issues or create pull requests for improvements. All contributions should follow standard PHP practices.

---

## License
This project is licensed under the MIT License. See the `LICENSE` file for details.

---
