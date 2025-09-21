# Survey System (PHP + MySQL)

Minimal survey system with roles, Likert questions, dashboard, CSV export, light/dark theme, and micro-animations.

## Prerequisites
- PHP 8+
- MySQL 8+

## Configure DB
The app is preconfigured for:
- Host: localhost
- DB: questionn1_survey_system
- User: questionn1_survey_system
- Pass: Boss.1212

Edit `app/config/config.php` if needed.

## Initialize data
- Create tables (phpMyAdmin or MySQL CLI):
	- Open phpMyAdmin, select your database, go to the Import tab.
	- Import `database/schema.sql`.
	- Alternatively via CLI: `mysql -u <user> -p <db> < database/schema.sql`.
- Seed the survey/questions and default admin:

Run in a terminal (Windows bash):

```bash
php app/seed/seed.php
```

This seeds:
- Admin: username `admin` password `Admin@1234`
- One active survey with sections and questions per the content you gave.

## Run the app
From the workspace folder:

```bash
php -S localhost:8080 -t public
```

Open http://localhost:8080

## Features
- Roles: admin, teacher, committee have dashboard access; expert/anonymous can submit.
- CSRF protection, PDO prepared statements, password hashing.
- Dashboard with averages, median, stddev; bar and radar charts on canvas; polling every 15s.
- CSV export (admin only) with UTF-8 BOM for Excel.
- Light/Dark theme toggle with icon swap and localStorage.
- Responsive UI, micro-animations, toast messages; dropdowns visible in dark mode.

## Notes
- Adjust styling in `assets/css/styles.css` and behavior in `assets/js/app.js`.
- For production, put `public/` behind a proper web server and secure `app/`.
# test
