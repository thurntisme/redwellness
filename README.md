# RedWellness

A comprehensive wellness tracking web application built with PHP and Tailwind CSS. Monitor your nutrition, hydration, workouts, and daily wellness habits — all in one beautiful dashboard.

## Features

- **Dashboard** - Overview of daily progress with charts and quick actions
- **Nutrition Tracking** - Log meals, track calories, and monitor macros
- **Hydration Monitor** - Track water intake with progress rings
- **Workout Manager** - Plan weekly workouts and track exercises
- **Morning Routines** - Build healthy morning habits
- **User Authentication** - Registration, login, and password reset

## Requirements

- PHP 8.0+
- SQLite (default) or MySQL
- Web server (Apache, Nginx, or PHP built-in server)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/daily-wellness-tracker.git
cd daily-wellness-tracker
```

2. Start the PHP built-in server:
```bash
php -S localhost:8000
```

3. Open in browser:
```
http://localhost:8000
```

## Database Setup

The project uses SQLite by default. The database file is stored in `data/redwellness.db`.

### Run Migrations

```bash
# Apply all pending migrations
php db/migrate.php

# Check migration status
php db/migrate.php --status

# Drop all tables and re-run migrations
php db/migrate.php --fresh
```

## Project Structure

```
daily-wellness-tracker/
├── data/                    # SQLite database storage
├── db/
│   ├── migrate.php          # Migration runner
│   └── migrations/          # Database migrations
├── inc/
│   └── db.php               # Database configuration
├── partials/
│   ├── header.php           # App header (with nav)
│   ├── footer.php           # App footer (with bottom nav)
│   ├── header-landing.php   # Landing page header
│   └── footer-landing.php   # Landing page footer
├── index.php                # Landing page
├── app.php                  # Dashboard
├── login.php                # Login page
├── register.php             # Registration page
├── nutrition.php            # Nutrition tracker
├── water.php                # Hydration tracker
├── workout.php              # Workout manager
├── exercise.php             # Exercise detail page
└── profile.php              # User profile settings
```

## Pages

| Page | Description |
|------|-------------|
| `index.php` | Landing page with features |
| `app.php` | Main dashboard |
| `login.php` | User login |
| `register.php` | User registration |
| `nutrition.php` | Nutrition tracking |
| `water.php` | Water intake tracking |
| `workout.php` | Workout planning |
| `exercise.php` | Exercise details |
| `profile.php` | Profile settings |

## Design System

Built with a custom Material Design 3 inspired theme:

- **Primary**: Electric Crimson (#b71422)
- **Tertiary**: Vital Teal (#006764)
- **Typography**: Inter + Space Grotesk
- **Icons**: Material Symbols Outlined

## Tech Stack

- **Frontend**: Tailwind CSS, Chart.js
- **Backend**: PHP
- **Database**: SQLite (default)
- **Fonts**: Google Fonts
- **Icons**: Material Symbols

## License

MIT License
