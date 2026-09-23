# 🎓 Alumni Tracking System

![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-v3-F59E0B?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

A modern, full-featured **Alumni Tracking System** built for universities, faculties, and educational institutions to foster sustainable relationships with graduates, monitor career progression, and cultivate an active alumni community.

---

## 🚀 About The Project

This application is built with the robust **Laravel 11** framework, a high-performance **Filament v3** administration panel, a scalable **MySQL** database, and is fully containerized using **Docker & Docker Compose** for seamless local development and deployment.

### 🌟 Key Features

- **👥 Role-Based Access Control (RBAC):**
  - **Super Admin:** Full system control, department/faculty management, access configuration.
  - **Department Coordinator:** Monitor, verify, and report alumni records belonging to their department.
  - **Alumni:** Update profiles, manage work experience, browse/post job openings, and network with peers.
- **🛡️ Alumni Verification Workflow:**
  - Student ID & graduation verification with manual or automatic administrator approval states.
- **💼 Career & Job Board:**
  - Job and internship posting board managed by alumni and institution coordinators, with direct application support.
- **🔍 Advanced Search & Filtering:**
  - Instantly search and filter graduates by graduation year, faculty, department, industry, current company, and location.
- **📊 Modern Dashboard (Filament v3):**
  - Interactive statistic widgets (total alumni, employment rate, leading industries).
  - Bulk data exports (CSV, Excel, PDF).
- **📅 Events & Announcements:**
  - Organize alumni reunions, webinars, panels, and networking meetups with RSVP tracking.
- **🐳 Dockerized Architecture:**
  - Isolated environment for PHP 8.2+, Nginx, MySQL, and Redis managed via Docker Compose.

---

## 🛠️ Tech Stack

| Layer | Technology | Description |
| :--- | :--- | :--- |
| **Containerization** | Docker & Docker Compose | Containerized application and database services |
| **Backend** | PHP 8.2+ & Laravel 11.x | Modern MVC architecture, RESTful API, Eloquent ORM |
| **Admin Panel** | Filament v3 | TALL stack powered (Tailwind, Alpine.js, Laravel, Livewire) admin UI |
| **Database** | MySQL 8.x | High-performance relational database model |
| **Styling & UI** | Tailwind CSS & Livewire | Clean, responsive, and reactive front-end interface |
| **Authorization** | Spatie Laravel-Permission / Filament Shield | Granular role and permission management |

---

## 📋 Prerequisites

Ensure you have the following installed on your host machine:

* **[Docker Desktop](https://www.docker.com/products/docker-desktop/)** (Docker Engine & Docker Compose v2+)
* **Git**

*(Optional if running locally without Docker: PHP >= 8.2, Composer >= 2.x, Node.js >= 18)*

---

## 🐳 Docker Compose Quickstart (Recommended)

Running the project with Docker ensures that all dependencies (PHP, MySQL, extensions) run in isolated containers without needing local installations.

### 1. Clone the Repository
```bash
git clone https://github.com/gamze-sueda-akpinar/alumni.git
cd alumni
```

### 2. Environment Configuration
Copy `.env.example` to create your local `.env` file:
```bash
cp .env.example .env
```

Ensure your `.env` contains the matching Docker database service configurations:
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=alumni_db
DB_USERNAME=alumni_user
DB_PASSWORD=alumni_secret
```

### 3. Build & Start Containers
Launch the application and database containers in detached mode:
```bash
docker compose up -d --build
```

### 4. Install Dependencies
Run Composer and NPM within the running application container:
```bash
docker compose exec app composer install
docker compose exec app npm install
docker compose exec app npm run build
```

### 5. Application Setup & Migrations
Generate application key, link storage, and run database migrations:
```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan storage:link
docker compose exec app php artisan migrate --seed
```

### 6. Create Filament Admin Account
Create your administrative credentials to log in to the Filament panel:
```bash
docker compose exec app php artisan make:filament-user
```
*(Enter your Name, Email, and Password when prompted)*

### 7. Access the Application
Open your browser and navigate to:
* **Public Web Portal:** `http://localhost:8000`
* **Filament Admin Panel:** `http://localhost:8000/admin`

---

## 💻 Alternative: Local Setup (Without Docker)

If you prefer to run the application directly on your local system with **PHP, Composer, Node.js, and MySQL** installed:

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment & key
cp .env.example .env
php artisan key:generate

# 3. Migrate and seed
php artisan migrate --seed
php artisan storage:link

# 4. Create admin user
php artisan make:filament-user

# 5. Build assets and start server
npm run build
php artisan serve
```

---

## 🗄️ Database Schema Overview

The database architecture is structured around key relational entities:

```text
├── users (Authentication, credentials, and core user attributes)
├── roles & permissions (RBAC permission matrix)
├── faculties (Faculties and academic units)
├── departments (Academic departments linked to faculties)
├── alumni_profiles (Graduation year, student ID, status, contact details)
├── experiences (Work and internship history)
├── job_postings (Career opportunities and requirements)
├── job_applications (Job applications submitted by alumni)
└── events (Reunions, workshops, and networking announcements)
```

---

## 📸 Screenshots

> *Screenshots will be updated as modules are finalized.*

| Filament Admin Dashboard | Alumni Directory & Search |
| :---: | :---: |
| *(Dashboard Preview)* | *(Directory Preview)* |

---

## 🤝 Contributing

Contributions are welcome!

1. Fork the repository (`Fork` button on GitHub).
2. Create your feature branch (`git checkout -b feature/AmazingFeature`).
3. Commit your changes (`git commit -m 'feat: Add some amazing feature'`).
4. Push to the branch (`git push origin feature/AmazingFeature`).
5. Open a **Pull Request**.

---

## 📄 License

This project is open-sourced under the [MIT License](LICENSE).

---

## 👤 Contact

**Gamze Şüeda Akpınar**  
* GitHub: [@gamze-sueda-akpinar](https://github.com/gamze-sueda-akpinar)  
* Project Link: [https://github.com/gamze-sueda-akpinar/alumni](https://github.com/gamze-sueda-akpinar/alumni)
