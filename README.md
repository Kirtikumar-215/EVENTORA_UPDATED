# Eventora — Smart College Event & Fest Management

A polished college project built only with **HTML, CSS, Bootstrap, JavaScript and PHP + MySQL**. No Node.js or build step is required.

## Included
- Premium responsive landing page
- Live next-event countdown
- Event discovery + search
- Student dashboard
- Event registration
- Host event proposal workflow
- HOD/admin command center
- Event approval / rejection
- Volunteer applications + HOD approval
- Coordinator applications + HOD approval
- User directory
- Event management
- MySQL schema + seed data
- Secure password hashing and prepared statements
- Role-based PHP session access

## Stack
- PHP 8.1+
- MySQL 5.7+/8+
- Bootstrap 5.3 via CDN
- Bootstrap Icons via CDN
- Vanilla JavaScript

## Local setup (XAMPP)
1. Copy the `Eventora` folder into `htdocs`.
2. Start Apache + MySQL in XAMPP.
3. Open phpMyAdmin and import `setup.sql`.
4. Check `includes/config.php` and update DB credentials if required.
5. Open `http://localhost/Eventora/`.

## Demo HOD account
- Email: `hod@eventora.local`
- Password: `Eventora@123`

## Demo student account
- Email: `student@eventora.local`
- Password: `Eventora@123`

## Shared hosting
Upload the folder to `public_html`, create a MySQL database/user, import `setup.sql`, and update `includes/config.php`. Make sure PHP 8.1+ is selected.

## Notes
The public homepage has graceful demo content when the database is unavailable, but login/admin/user workflows require a configured MySQL database.
