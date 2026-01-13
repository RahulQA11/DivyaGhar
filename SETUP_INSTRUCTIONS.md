# Database Setup Instructions

## Prerequisites

Before setting up the database, you need to have MySQL installed and running on your system.

### For macOS:

1. **Install MySQL** (if not already installed):
   ```bash
   # Using Homebrew:
   brew install mysql
   
   # Or download from: https://dev.mysql.com/downloads/mysql/
   ```

2. **Start MySQL Server**:
   ```bash
   # Using Homebrew:
   brew services start mysql
   
   # Or manually:
   mysql.server start
   ```

3. **Verify MySQL is running**:
   ```bash
   mysql -u root -e "SELECT VERSION();"
   ```

## Database Setup

Once MySQL is running, you have two options:

### Option 1: Using the PHP Setup Script (Recommended)

Run the setup script:
```bash
php setup_database.php
```

This script will:
- Create the database `divyaghar_db`
- Import all tables and schema
- Insert sample data (categories, products, admin user)

### Option 2: Manual Setup

1. **Create the database**:
   ```bash
   mysql -u root -p -e "CREATE DATABASE divyaghar_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   ```

2. **Import the schema**:
   ```bash
   mysql -u root -p divyaghar_db < database.sql
   ```

## Default Credentials

After setup, you can login to the admin panel with:
- **URL**: http://localhost:9000/admin/
- **Username**: `admin`
- **Password**: `admin123`

⚠️ **Important**: Change the admin password after first login!

## Database Configuration

If you need to change database credentials, edit `config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'divyaghar_db');
define('DB_USER', 'root');
define('DB_PASS', 'your_password');
```

## Troubleshooting

### "No such file or directory" error
- MySQL server is not running
- Start MySQL: `brew services start mysql` or `mysql.server start`

### "Access denied" error
- Wrong username/password
- Update credentials in `config/database.php`
- Or create a MySQL user with proper permissions

### "Can't connect to MySQL server"
- Check if MySQL is running: `brew services list` (for Homebrew)
- Check MySQL socket path
- Try using `127.0.0.1` instead of `localhost` in config

## Next Steps

1. ✅ Start MySQL server
2. ✅ Run `php setup_database.php`
3. ✅ Access the site at http://localhost:9000
4. ✅ Login to admin panel and change default password

