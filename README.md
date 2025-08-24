# guesthouse
A PHP-based guesthouse booking site where travelers search live room availability by dates, budget, capacity, and amenities. Clean UI, secure auth, wishlist and bookings history, and an admin dashboard for managing rooms, prices, and blackout dates. Mobile-friendly, fast, and built with MySQL.

How to use

Install XAMPP (Apache + MySQL) and copy the project folder to htdocs/guesthouse.

Start Apache & MySQL; open phpMyAdmin.

Create a database (e.g., guesthouse) and import guesthouse.sql.

Set DB credentials in config/db.php (or .env if used):

  $DB_HOST='localhost';
  $DB_NAME='guesthouse';
  $DB_USER='root';
  $DB_PASS='';


Visit http://localhost/guesthouse.

Register/Login → choose dates → filter by budget/guests/amenities → view rooms → book.

(Optional) Admin panel: manage rooms, prices, and availability (use seeded admin or create one in DB).
