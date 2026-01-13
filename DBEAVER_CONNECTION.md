# Connecting to Database in DBeaver

## Connection Details

Based on your `config/database.php` file, use these settings:

### MySQL Connection Settings

- **Server Host**: `localhost` (or `127.0.0.1`)
- **Port**: `3306` (default MySQL port)
- **Database**: `divyaghar_db`
- **Username**: `root`
- **Password**: (leave empty if no password, or enter your MySQL root password)

## Step-by-Step Instructions

### 1. Open DBeaver

Launch DBeaver application on your Mac.

### 2. Create New Connection

1. Click **"New Database Connection"** button (plug icon) in the toolbar
   - Or go to: **Database** → **New Database Connection**
   - Or press: `Cmd + Shift + N`

### 3. Select MySQL

1. In the connection wizard, select **MySQL**
2. Click **Next**

### 4. Enter Connection Details

**Main Tab:**
- **Server Host**: `localhost`
- **Port**: `3306`
- **Database**: `divyaghar_db`
- **Username**: `root`
- **Password**: (enter your MySQL root password if you have one, otherwise leave blank)

**Driver Properties Tab (Optional):**
- You can leave default settings
- DBeaver will automatically download MySQL driver if needed

### 5. Test Connection

1. Click **"Test Connection"** button
2. If driver is missing, DBeaver will prompt to download it - click **Download**
3. Wait for "Connected" message

### 6. Finish

1. Click **Finish**
2. The connection will appear in the Database Navigator panel

## Alternative: Using Connection String

If you prefer to use a connection string:

```
jdbc:mysql://localhost:3306/divyaghar_db?useSSL=false&serverTimezone=UTC
```

## Troubleshooting

### "Access Denied" Error
- Make sure MySQL is running: `brew services list` (check if mysql is started)
- Verify username/password in DBeaver matches your MySQL setup
- Try connecting without specifying database first, then select it

### "Can't connect to MySQL server"
- Check if MySQL is running: `brew services start mysql`
- Verify port 3306 is correct
- Try `127.0.0.1` instead of `localhost`

### "Unknown database 'divyaghar_db'"
- Database doesn't exist yet
- Run `php setup_database.php` first to create it
- Or create it manually in DBeaver: Right-click connection → SQL Editor → Run: `CREATE DATABASE divyaghar_db;`

### Driver Issues
- DBeaver will auto-download MySQL driver
- If issues persist, go to: **Window** → **Preferences** → **Connections** → **Drivers** → **MySQL** → **Download**

## Viewing Database Structure

Once connected:

1. **Expand** the connection in Database Navigator
2. **Expand** `divyaghar_db` database
3. **Expand** "Tables" to see all tables:
   - `users` - Admin users
   - `categories` - Product categories
   - `products` - Product information
   - `product_images` - Product images
   - `orders` - Customer orders
   - `order_items` - Order line items
   - `contact_messages` - Contact form submissions
   - `cart` - Shopping cart data

## Useful DBeaver Features

### View Table Data
- Right-click table → **View Data**
- Or double-click table name

### Edit Data
- Right-click table → **Edit Data**
- Make changes and click **Save**

### Run SQL Queries
- Right-click database → **SQL Editor** → **New SQL Script**
- Or press `Ctrl + ]` (Windows/Linux) or `Cmd + ]` (Mac)

### Export Data
- Right-click table → **Export Data**
- Choose format (CSV, Excel, JSON, etc.)

## Quick SQL Queries

### View all products
```sql
SELECT * FROM products;
```

### View all categories
```sql
SELECT * FROM categories;
```

### View admin users
```sql
SELECT id, username, email, created_at FROM users;
```

### View recent orders
```sql
SELECT * FROM orders ORDER BY created_at DESC LIMIT 10;
```

## Connection Settings Summary

```
Type: MySQL
Host: localhost
Port: 3306
Database: divyaghar_db
User: root
Password: (your MySQL root password)
```

---

**Note**: Make sure MySQL server is running before connecting. Check with:
```bash
brew services list | grep mysql
```

If not running, start it with:
```bash
brew services start mysql
```

