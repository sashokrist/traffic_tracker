<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 📈 Website Traffic Tracker

A Laravel-based tracking system for logging website visits, resolving visitor location, exporting reports, and sending scheduled email summaries.

---

## 🚀 Features

- Logs visits with IP and timestamp
- Fetches geo-location info via external API (`ip-api.com`)
- Tracks visits via embedded JS snippet
- Sends scheduled email reports with Excel attachment
- Web UI for filtering and exporting reports
- Dashboard blade with dark mode toggle and table/card view switch
- Caching and logging support
- Clean service-based Laravel architecture
- Swagger API documentation

---

## 🛠 Installation

```bash
clone SSH:
git clone git@github.com:sashokrist/traffic_tracker.git
clone HTPPS:
git clone https://github.com/sashokrist/traffic_tracker.git
cd website-traffic-tracker
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan storage:link
```

---

## 🔧 .env Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Web Traffic Tracker"

GEO_API_URL=http://ip-api.com/json/
```

---

## ✅ Requirements

- PHP 8.1+
- Laravel 10+
- MySQL / MariaDB
- Node.js (optional for assets)
- Mail server (Mailtrap recommended)

---

## 💡 Usage

Embed the tracking script into any webpage:

```html
<script src="http://your-domain/js/tracker.js" defer></script>
```

Each page load sends a request to:

```http
GET /api/track?page={current_url}
```

---

## 🧩 Trait: `GeneratesVisitReport`

Handles:

- Excel report generation
- Storage in `storage/app/reports`
- Shared by mail/export controller

---

## 🖥 Web UI + Dashboard Blade

- Access at: `/dashboard`
- Features:
    - Filter visits by date
    - Export as Excel
    - Email reports
    - ✅ Toggle dark/light theme (stored in localStorage)
    - ✅ Switch between table view and card view

---

## 🧭 UI Diagram

```text
[HTML Page]
   |
[tracker.js fetch /api/track]
   |
[VisitTrackingController] → [TrackVisitRequest]
   |
[VisitTrackingService]
   ├── [GeoLocatorInterface → GeoIPService]
   ├── [Visit::create()]
   └── [LoggingService → Log + SyncLog]
```

---

## 🌐 Web Behavior

- Validates `page` query param
- Skips private/local IPs for geo lookup
- Sends `204 No Content` if valid

---

## 🗂 Routes

### web.php

```php
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visits/export', [VisitExportController::class, 'export'])->name('visits.export');
    Route::get('/visits/download/{filename}', [VisitExportController::class, 'download'])->name('visits.download');
});
```

### api.php

```php
Route::get('/track', [VisitController::class, 'track']);
```

---

## 🔐 Authentication

- Protects admin UI routes with `auth` middleware

---

## 🧹 Scheduled Cleanup

Command to remove visits older than 30 days:

```bash
php artisan visits:cleanup
```

Or customize days:

```bash
php artisan visits:cleanup 60
```

---

---

## 🧩 Service & Interface Architecture

This project uses a clean, decoupled Laravel architecture with proper use of interfaces, services, and traits.

### ✅ Interface Binding

- `GeoLocatorInterface` defines a contract for resolving geo-location from an IP.
- `GeoIPService` implements the interface and uses `ip-api.com` to fetch location data.
- Can be swapped easily with another provider via Laravel's service container.

### 🧰 Services

| Service              | Responsibility                                       |
|----------------------|------------------------------------------------------|
| `VisitTrackingService` | Core visit tracking logic (IP, geo lookup, logging)  |
| `GeoIPService`         | Fetches geo-location data from an external API       |
| `LoggingService`       | Logs to both Laravel log and SyncLog table           |
| `VisitReportService`   | Provides aggregated unique and raw visit reports     |

### 🧪 Traits

| Trait                   | Responsibility                              |
|-------------------------|---------------------------------------------|
| `GeneratesVisitReport` | Generates and stores Excel visit reports     |

---

## 📊 Dashboard Blade UI

The `/dashboard` view offers:

- 📆 Date filter via datepickers
- 🌗 Toggle between light and dark mode
- 📋 Table view (default) for compact data display
- 🧾 Card view for mobile-friendly summary display
- 📤 Export button to trigger email with Excel report

UI preferences (like dark mode and card view) are stored in localStorage for persistence.

---

## 🧠 Additional Notes

- **Tracker Logic**: `tracker.js` was optimized to use `fetch()` instead of appending an image tag.
- **Validation**: `TrackVisitRequest` ensures the `page` param is present and valid.
- **Security**: All dashboard routes are protected by `auth` middleware.
- **Test Coverage**: Includes unit tests for visit logging, reporting, and caching.
- **Command**: `php artisan visits:cleanup` removes visits older than 30 days (or custom).

---

## 📌 Summary: Flow Diagram

```text
[HTML Page]
   |
[tracker.js fetch /api/track]
   |
[VisitTrackingController] → [TrackVisitRequest]
   |
[VisitTrackingService]
   ├── resolveGeo()
   ├── Visit::create()
   └── LoggingService
```
![flow diagram.png](flow%20diagram.png)
---

## 💾 Caching

- Uses `Cache::remember()` with daily TTL
- Caches grouped unique visits by date

---

## ✅ Functional Requirements

- Track visits via JS
- Record geo data
- Export to Excel
- Email reports
- Clean, modular Laravel structure

---

## 🛠 Technical Requirements

- Service-based architecture
- Geo via interface abstraction
- Logging via LoggingService
- Optional queueing for mail

---

## 🔐 Swagger API documentation

```bash
php artisan l5-swagger:generate
```
Visit:

http://localhost:8000/api/documentation#/Visits/trackVisit

---

## 🧪 Testing

```bash
php artisan l5-swagger:generate
php artisan test --filter=VisitReportServiceTest
```

---

## 🌐 `public/test-visit.html` Page

This file is a test page that loads the `tracker.js` script to simulate a real visit.

### ⚙️ How It Works

- Page loads and triggers `tracker.js`
- Makes request like:
  ```http
  GET /api/track?page=http://your-laravel-app/test-visit.html
  ```
- Logs IP, timestamp, and page URL to the database
- Geo-location resolved if public IP

### ✅ How to Use It

1. Run the Laravel server:
   ```bash
   php artisan serve
   ```
2. Visit:
   ```
   http://127.0.0.1:8000/test-visit.html
   ```
3. Check logs and database entries under the `visits` table.

---

## 🌐 Tracked Pages Overview

The following raw PHP pages are tracked using the `tracker.js` script embedded in each page. These pages generate **unique visits** stored in the Laravel backend.

### 🧩 `site/spare-part.php`

- A standalone PHP page used to list or display spare parts.
- Includes the `tracker.js` script to log visits.
- Tracks visitors' IP, location, and timestamp.

### 🛒 `cart.php`

- Represents the shopping cart page.
- Once loaded, it triggers the tracker and stores visit data.
- Useful for analyzing how often users visit the cart without checkout.

### 📄 `about.php`

- Static page with information about the business or website.
- Visit tracking helps determine interest in company background or mission.
- Same tracking mechanism as all other pages.

### ✅ How It Works

All these pages include:

```html
<script src="http://your-domain/js/tracker.js" defer></script>

```
On page load, the script sends a request like:

```http
GET /api/track?page=http://your-domain/site/spare-part.php

GET /api/track?page=http://your-domain/cart.php

GET /api/track?page=http://your-domain/about.php
``` 
The Laravel backend logs:

IP address

Page URL

Country, region, city, ISP (if available)

Timestamp

Data is then visible in the admin dashboard (/dashboard) and included in email reports.

## 🔗 Related Files Overview

| File                          | Purpose                              |
|-------------------------------|--------------------------------------|
| `public/js/tracker.js`        | Tracking client                      |
| `VisitController`             | API handler for `/track`             |
| `VisitTrackingService`        | Main logic (IP, geo, log)            |
| `GeoIPService`                | Geo lookup provider                  |
| `LoggingService`              | Logs data consistently               |
| `VisitExportController`       | Handles Excel download and mail      |
| `VisitReportMail`             | Sends email with attached report     |
| `VisitReportService`          | Aggregates report data               |
| `GeneratesVisitReport`        | Trait for Excel creation             |
| `Visit`                       | Eloquent model for visits            |

---
## 📂 Design patterns used in this project

1. Service Pattern (VisitTrackingService, LoggingService)
Purpose:
Encapsulates business logic into dedicated service classes instead of placing it in controllers or models.

How it's used:

VisitController delegates the core logic to VisitTrackingService, which:

Retrieves and parses IP and location data

Stores visit records into the database

LoggingService provides a reusable way to log events, making the logic cleaner and easier to test.

✅ Why it's important:

Keeps controllers lightweight and focused on request handling, improves testability and separation of concerns.

2. Dependency Injection (via Constructor Injection)
Purpose:
Promotes loose coupling by injecting dependencies (e.g., services) instead of hardcoding them.

How it's used:

VisitController receives VisitTrackingService and LoggingService via its constructor.

You rely on Laravel's IoC container to resolve and inject dependencies automatically.

✅ Why it's important:

Makes your components interchangeable, mockable in tests, and easier to extend or replace.

3. DTO-like Behavior using Form Request Classes (TrackVisitRequest)
Purpose:
Separates validation logic and acts like a Data Transfer Object (DTO).

How it's used:

You use TrackVisitRequest to encapsulate and validate the incoming request to /track.

✅ Why it's important:

Moves validation out of the controller, ensures clean data input, and centralizes request validation logic.

✅ Summary

Pattern	Role in Your Project

Service Pattern	Core logic in VisitTrackingService & LoggingService

Dependency Injection	Promotes decoupled, testable code

Form Request / DTO	Validates and encapsulates request data cleanly

![design diagram.png](design%20diagram.png)

---

## 🧪 Database Tables

Run "php artisan migrate" to create the necessary tables:

- `visits`: stores IP, page URL, ip_address, country, region, isp, visited_at,
- `logs`: used for logging tracker and background jobs, user_id, status, message
- `users`: used for stores user data, name, email, email_verified_at, password, remember_token

Run sql query to create the database and tables:

```sql

-- Create the database

CREATE DATABASE IF NOT EXISTS website_traffic_tracker
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE website_traffic_tracker;

CREATE TABLE `users` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`email` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`email_verified_at` TIMESTAMP NULL DEFAULT NULL,
`password` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`remember_token` VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`created_at` TIMESTAMP NULL DEFAULT NULL,
`updated_at` TIMESTAMP NULL DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `visits` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
`page_url` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`ip_address` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`country` VARCHAR(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`region` VARCHAR(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`city` VARCHAR(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`isp` VARCHAR(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`visited_at` TIMESTAMP NOT NULL,
`created_at` TIMESTAMP NULL DEFAULT NULL,
`updated_at` TIMESTAMP NULL DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `logs` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
`user_name` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`user_id` VARCHAR(45) COLLATE utf8mb4_unicode_ci NOT NULL,
`status` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`message` TEXT COLLATE utf8mb4_unicode_ci,
`created_at` TIMESTAMP NULL DEFAULT NULL,
`updated_at` TIMESTAMP NULL DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


---

## 📩 Contact

Built by Alexander Keremidarov. Contributions welcome.
