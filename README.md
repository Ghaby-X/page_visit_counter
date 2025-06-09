# Simple Page Visit Counter with LAMP Stack

This is a simple web application that counts and displays page visits using the LAMP (Linux, Apache, MySQL, PHP) stack.

## Project Architecture

![image](https://github.com/user-attachments/assets/68f8a5c0-12be-4e88-a941-845f1d4a7c4c)


## Interface

![image](https://github.com/user-attachments/assets/d420bfc7-1160-406b-a586-5a1667b4befd)


## Features

- Tracks and displays the number of page visits
- Clean, responsive user interface
- Persistent storage using MySQL database
- Environment variable configuration for security

## Requirements

- PHP 7.0 or higher
- MySQL/MariaDB
- Apache web server
- Web browser

## Installation

1. Clone this repository to your web server directory:
   ```
   git clone https://github.com/yourusername/page_visit_counter.git
   ```

2. Create a MySQL database and table:
   ```sql
   CREATE DATABASE PageVisit;
   USE PageVisit;
   CREATE TABLE page_visits (
     id INT PRIMARY KEY,
     visit_count INT DEFAULT 0
   );
   INSERT INTO page_visits (id, visit_count) VALUES (1, 0);
   ```

3. Configure your environment:
   - Copy `.env.example` to `.env`
   - Update the database connection details in `.env`

4. Access the application through your web browser <public_ip>/counter.php.

## Sample userdata script for ec2

```
#!/bin/bash

# Update package list
sudo apt-get update -y
sudo apt-get upgrade -y

# Install Apache
sudo apt-get install -y apache2
sudo systemctl enable apache2
sudo systemctl start apache2

# Allow Apache and SSH through the firewall
sudo ufw allow "Apache"
sudo ufw allow "OpenSSH"
sudo ufw --force enable

# Install MySQL client
# sudo apt-get install -y mysql-client

# Install PHP and required modules
sudo apt-get install -y php libapache2-mod-php php-mysql

# Restart Apache to load PHP
sudo systemctl restart apache2

# Clone the repository into the Apache web root
sudo git clone https://github.com/Ghaby-X/page_visit_counter.git
sudo cp -r page_visit_counter/* /var/www/html

# Create .env file in web root
sudo cat <<EOF | sudo tee /var/www/html/.env > /dev/null
DB_HOST=localhost
DB_NAME=PageVisit
DB_USER=<user>
DB_PASS=<password>
EOF


# Set proper ownership and permissions (optional but recommended)
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html

# Restart Apache again to serve the new app
sudo systemctl restart apache2


```

## Usage

Simply navigate to the page in your web browser. Each page load will increment the visit counter and display the current count.

## License

[MIT](LICENSE)
