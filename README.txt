FIRTUNA — PERSONAL PORTFOLIO WEBSITE
===================================

PROJECT CONTENTS
- index.html                 Portfolio page
- style.css                  Responsive dark theme and animations
- script.js                  Mobile navigation, scroll reveal, contact form
- assets/hemen-profile.jpg Profile portrait image (illustrative generated image)
- php/db.php                 PDO database connection settings
- php/contact.php            Validates and saves contact messages securely
- database.sql               Creates the database and messages table

HOW TO VIEW THE WEBSITE
1. Open index.html in a browser to preview the portfolio.
2. For the PHP/MySQL contact form, use a local PHP server such as XAMPP.
3. Copy the hemen_portfolio folder into your XAMPP htdocs folder.
4. Start Apache and MySQL from the XAMPP Control Panel.
5. Open phpMyAdmin (usually http://localhost/phpmyadmin).
6. Import database.sql, or open it in the SQL tab and run it.
7. If your MySQL username/password differs, edit php/db.php.
8. Visit http://localhost/hemen_portfolio/ in your browser.
9. Submit a test message. It will be saved in the messages table.

DATABASE NOTES
This project uses PHP PDO with prepared statements. The uploaded study notes
cover PHP/MySQL connections, creating databases and tables, inserting and
selecting records, and prepared statements. This project applies those ideas
using PDO and a parameterized INSERT statement for the contact form.

CUSTOMIZATION
- Change the profile image by replacing assets/hemen-profile.jpg.
- Edit the About text and skills in index.html.
- The email address is set to hemenh29@gimal.com as provided.
- Skill progress bars are illustrative, not measured proficiency scores.

IMPORTANT
The website is dark-mode by default and responsive on mobile, tablet, and desktop.
The contact form requires PHP and MySQL; opening index.html directly will not
run the PHP backend. The email link works with a mail app configured on the device.
