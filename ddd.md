# 📊 Data Design Document (`ddd.md` / `add.md`) — Alumni Tracking System

[← Back to Main Documentation (README.md)](README.md) &bull; [Interactive Swagger API UI](resources/views/swagger.blade.php) &bull; [OpenAPI 3.0 Specification](public/openapi.json) &bull; [add.md](add.md)

---

## 📑 Table of Contents
1. [Overview & Objectives](#1-overview--objectives)
2. [Dual-Layer Storage Architecture](#2-dual-layer-storage-architecture)
3. [Entity-Relationship Diagram (ERD)](#3-entity-relationship-diagram-erd)
4. [Data Dictionary & Table Specifications](#4-data-dictionary--table-specifications)
   - [4.1 Users (`users`)](#41-users-users)
   - [4.2 Alumni Profiles (`alumni_profiles`)](#42-alumni-profiles-alumni_profiles)
   - [4.3 Faculties (`faculties`)](#43-faculties-faculties)
   - [4.4 Departments (`departments`)](#44-departments-departments)
   - [4.5 Work Experiences (`experiences`)](#45-work-experiences-experiences)
   - [4.6 Job Postings (`job_postings`)](#46-job-postings-job_postings)
   - [4.7 Events (`events`)](#47-events-events)
   - [4.8 Announcements Entity (`announcements`)](#48-announcements-entity-announcements)
   - [4.9 Cache & Session Storage (`cache`, `sessions`)](#49-cache--session-storage-cache-sessions)
   - [4.10 Job Applications (`job_applications` / `applications`)](#410-job-applications-job_applications--applications)
5. [Data Integrity & Relationship Constraints](#5-data-integrity--relationship-constraints)
6. [State Machines & Entity Lifecycles](#6-state-machines--entity-lifecycles)
7. [Direct vs. Nested Routing Architecture](#7-direct-vs-nested-routing-architecture)
8. [Persistence Strategy & "The Forgetting Test" Verification](#8-persistence-strategy--the-forgetting-test-verification)
9. [Cross-Reference Navigation](#9-cross-reference-navigation)

---

## 1. 🎯 Overview & Objectives

This document (**`ddd.md`** / **`add.md`**) provides the formal, in-depth **Data Design Documentation (DDD)** for the **Alumni Tracking System**. It defines the logical and physical data schemas, data dictionaries, entity-relationship constraints, and caching strategies.

### Core Objectives:
- **Relational Integrity:** Establish normalized, high-performance database tables for academic entities, profiles, job listings, and institutional events.
- **Dual-Storage Compatibility:** Ensure seamless coexistence between the **MySQL 8.0** relational database and the high-speed **In-Memory / Persistent Cache** data layer.
- **Persistence Across Container Lifecycles:** Guarantee that no records are lost during container updates, deployments, or teardowns (`docker compose down` &rarr; `docker compose up`).
- **Complete Traceability:** Link data models directly with their respective Eloquent Models, In-Memory Models, HTTP Controllers, and Swagger UI specifications.

---

## 2. 🏗️ Dual-Layer Storage Architecture

The application implements a dual-layer data architecture accommodating both traditional relational database operations and decoupled rapid-prototyping in-memory workflows:

```mermaid
flowchart TD
    Client["👤 Client / Front-End / Swagger UI"]

    subgraph Controllers["Controller Layer"]
        UserCtrl["UserController / ApiUserController"]
        AnnounceCtrl["AnnouncementController / ApiAnnouncementController"]
        JobCtrl["JobPostingController / ApiJobPostingController"]
        FilamentRes["Filament Admin Resources"]
    end

    subgraph StorageLayer["Data Storage & Persistence Architecture"]
        subgraph MySQLDB["MySQL 8.0 Relational Engine"]
            UsersTable[("users")]
            ProfilesTable[("alumni_profiles")]
            FacultiesTable[("faculties")]
            DeptsTable[("departments")]
            ExpTable[("experiences")]
            JobsTable[("job_postings")]
            ApplicationsTable[("job_applications / applications")]
            EventsTable[("events")]
            CacheTable[("cache / cache_locks")]
        end

        subgraph InMemoryLayer["In-Memory Model Abstraction"]
            IM_User["InMemoryUser (Cache::forever)"]
            IM_Announce["Announcement (Cache::forever)"]
            IM_Jobs["InMemoryJobPosting (Cache::forever)"]
        end

        subgraph DockerVolume["Docker Named Storage Volume"]
            Volume[("alumni_mysql_data -> /var/lib/mysql")]
        end
    end

    Client --> Controllers
    Controllers -->|"Eloquent ORM"| MySQLDB
    Controllers -->|"CRUD Abstraction"| InMemoryLayer
    InMemoryLayer -->|"CACHE_STORE=database"| CacheTable
    MySQLDB --> Volume
```

---

## 3. 🧩 Entity-Relationship Diagram (ERD)

The relational schema and logical entities are structured around the following entity relationships:

```mermaid
erDiagram
    USERS ||--o| ALUMNI_PROFILES : "has one"
    USERS ||--o{ EXPERIENCES : "has many"
    USERS ||--o{ JOB_POSTINGS : "creates"
    USERS ||--o{ JOB_APPLICATIONS : "submits"
    JOB_POSTINGS ||--o{ JOB_APPLICATIONS : "receives"
    FACULTIES ||--o{ DEPARTMENTS : "contains"
    DEPARTMENTS ||--o{ ALUMNI_PROFILES : "graduated from"

    USERS {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at
        string password
        string remember_token
        timestamps timestamps
    }

    ALUMNI_PROFILES {
        bigint id PK
        bigint user_id FK
        bigint department_id FK
        string student_number
        smallint graduation_year
        string phone
        string current_company
        string current_position
        string city
        string country
        string linkedin_url
        string github_url
        text bio
        string cv_path
        enum status
        timestamps timestamps
    }

    FACULTIES {
        bigint id PK
        string name
        string code UK
        timestamps timestamps
    }

    DEPARTMENTS {
        bigint id PK
        bigint faculty_id FK
        string name
        string code
        timestamps timestamps
    }

    EXPERIENCES {
        bigint id PK
        bigint user_id FK
        string company_name
        string position
        string employment_type
        date start_date
        date end_date
        boolean is_current
        text description
        timestamps timestamps
    }

    JOB_POSTINGS {
        bigint id PK
        bigint user_id FK
        string title
        string company_name
        string location
        string type
        text description
        text requirements
        date application_deadline
        string contact_email
        boolean is_active
        timestamps timestamps
    }

    EVENTS {
        bigint id PK
        string title
        text description
        datetime event_date
        string location
        boolean is_online
        string meeting_link
        boolean is_active
        timestamps timestamps
    }

    ANNOUNCEMENTS {
        bigint id PK
        string title
        text content
        string category
        string author
        string target_audience
        boolean is_pinned
        string status
        timestamp published_at
        timestamps timestamps
    }

    JOB_APPLICATIONS {
        bigint id PK
        bigint job_posting_id FK
        bigint user_id FK
        text cover_letter
        string resume_path
        string status
        text notes
        timestamp applied_at
        timestamps timestamps
    }
```

---

## 4. 📖 Data Dictionary & Table Specifications

### 4.1 Users (`users`)
- **Purpose:** Core identity, credential, and authentication store for administrators, coordinators, and graduates.
- **Migration:** `0001_01_01_000000_create_users_table.php`
- **Eloquent Model:** [`app/Models/User.php`](app/Models/User.php)

| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PRIMARY KEY`, `AUTO_INCREMENT` | Unique user identifier |
| `name` | `VARCHAR(255)` | `NOT NULL` | Full name of the user |
| `email` | `VARCHAR(255)` | `NOT NULL`, `UNIQUE` | Unique email for authentication & contact |
| `email_verified_at` | `TIMESTAMP` | `NULLABLE` | Timestamp when user verified email |
| `password` | `VARCHAR(255)` | `NOT NULL` | Bcrypt/Argon2 hashed password string |
| `remember_token` | `VARCHAR(100)` | `NULLABLE` | Token for "Remember Me" session persistence |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Record creation timestamp |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Record last update timestamp |

---

### 4.2 Alumni Profiles (`alumni_profiles`)
- **Purpose:** Stores comprehensive academic and professional demographic data for graduates.
- **Migration:** `2026_09_23_073240_create_alumni_profiles_table.php`
- **Eloquent Model:** [`app/Models/AlumniProfile.php`](app/Models/AlumniProfile.php)

| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PRIMARY KEY`, `AUTO_INCREMENT` | Unique profile identifier |
| `user_id` | `BIGINT UNSIGNED` | `NOT NULL`, `FK` &rarr; `users.id`, `ON DELETE CASCADE` | Associated user identity |
| `department_id` | `BIGINT UNSIGNED` | `NULLABLE`, `FK` &rarr; `departments.id`, `ON DELETE SET NULL` | Graduating academic department |
| `student_number` | `VARCHAR(255)` | `NULLABLE` | Institution student identification number |
| `graduation_year` | `SMALLINT UNSIGNED`| `NULLABLE`, `INDEX` | Year of degree completion |
| `phone` | `VARCHAR(255)` | `NULLABLE` | Primary contact phone number |
| `current_company` | `VARCHAR(255)` | `NULLABLE`, `INDEX` | Present employer or company name |
| `current_position` | `VARCHAR(255)` | `NULLABLE` | Current professional title / role |
| `city` | `VARCHAR(255)` | `NULLABLE`, `INDEX` | Residence city |
| `country` | `VARCHAR(255)` | `DEFAULT 'Turkey'` | Residence country |
| `linkedin_url` | `VARCHAR(255)` | `NULLABLE` | Public LinkedIn profile URL |
| `github_url` | `VARCHAR(255)` | `NULLABLE` | Public GitHub developer profile URL |
| `bio` | `TEXT` | `NULLABLE` | Personal biography and career summary |
| `cv_path` | `VARCHAR(255)` | `NULLABLE` | Storage path to uploaded resume/CV |
| `status` | `ENUM('pending', 'approved', 'rejected')` | `DEFAULT 'pending'`, `INDEX` | Administrative verification state |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Profile creation timestamp |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Profile last update timestamp |

---

### 4.3 Faculties (`faculties`)
- **Purpose:** Academic divisions and faculties within the university.
- **Migration:** `2026_09_23_073223_create_faculties_table.php`
- **Eloquent Model:** [`app/Models/Faculty.php`](app/Models/Faculty.php)

| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PRIMARY KEY`, `AUTO_INCREMENT` | Unique faculty identifier |
| `name` | `VARCHAR(255)` | `NOT NULL` | Faculty full name (e.g., Mühendislik Fakültesi) |
| `code` | `VARCHAR(255)` | `NULLABLE`, `UNIQUE` | Unique short code (e.g., ENG, FEAS) |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Record creation timestamp |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Record last update timestamp |

---

### 4.4 Departments (`departments`)
- **Purpose:** Academic majors and degree programs linked to faculties.
- **Migration:** `2026_09_23_073231_create_departments_table.php`
- **Eloquent Model:** [`app/Models/Department.php`](app/Models/Department.php)

| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PRIMARY KEY`, `AUTO_INCREMENT` | Unique department identifier |
| `faculty_id` | `BIGINT UNSIGNED` | `NOT NULL`, `FK` &rarr; `faculties.id`, `ON DELETE CASCADE` | Parent faculty |
| `name` | `VARCHAR(255)` | `NOT NULL` | Department name (e.g., Bilgisayar Mühendisliği) |
| `code` | `VARCHAR(255)` | `NULLABLE` | Department code (e.g., CENG, IE) |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Record creation timestamp |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Record last update timestamp |

---

### 4.5 Work Experiences (`experiences`)
- **Purpose:** Work, internship, and historical career trajectory records for alumni.
- **Migration:** `2026_09_23_073248_create_experiences_table.php`
- **Eloquent Model:** [`app/Models/Experience.php`](app/Models/Experience.php)

| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PRIMARY KEY`, `AUTO_INCREMENT` | Unique experience record ID |
| `user_id` | `BIGINT UNSIGNED` | `NOT NULL`, `FK` &rarr; `users.id`, `ON DELETE CASCADE` | Associated alumnus |
| `company_name` | `VARCHAR(255)` | `NOT NULL` | Company / Employer name |
| `position` | `VARCHAR(255)` | `NOT NULL` | Job title or position held |
| `employment_type` | `VARCHAR(255)` | `NULLABLE` | Employment modality (Full-time, Internship) |
| `start_date` | `DATE` | `NOT NULL` | Position start date |
| `end_date` | `DATE` | `NULLABLE` | Position end date (`NULL` if current) |
| `is_current` | `BOOLEAN` | `DEFAULT FALSE` | Flag indicating current active employment |
| `description` | `TEXT` | `NULLABLE` | Key achievements and job responsibilities |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Record creation timestamp |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Record last update timestamp |

---

### 4.6 Job Postings (`job_postings`)
- **Purpose:** Career openings, internships, and job advertisements shared for alumni and students.
- **Migrations:**
  - Initial Table: [`database/migrations/2026_09_23_073258_create_job_postings_table.php`](database/migrations/2026_09_23_073258_create_job_postings_table.php)
  - Schema Extension (`contact_email`): [`database/migrations/2026_10_21_063613_add_contact_email_to_job_postings_table.php`](database/migrations/2026_10_21_063613_add_contact_email_to_job_postings_table.php)
- **Eloquent Model:** [`app/Models/JobPosting.php`](app/Models/JobPosting.php) (Primary persistence model connected to MySQL)
- **In-Memory Prototype Model:** [`app/Models/InMemoryJobPosting.php`](app/Models/InMemoryJobPosting.php) (Cached fallback prototype)
- **Model Factory:** [`database/factories/JobPostingFactory.php`](database/factories/JobPostingFactory.php) (Includes `inactive()` state)
- **Database Seeder:** [`database/seeders/DatabaseSeeder.php`](database/seeders/DatabaseSeeder.php) (Seeds standard enterprise postings + factory records)

#### Schema & Column Specifications:

| Column | Type | Constraints | Default | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PRIMARY KEY`, `AUTO_INCREMENT` | *None* | Unique job posting identifier |
| `user_id` | `BIGINT UNSIGNED` | `NOT NULL`, `FOREIGN KEY` &rarr; `users(id)`, `ON DELETE CASCADE` | *None* | Associated publisher / author user ID |
| `title` | `VARCHAR(255)` | `NOT NULL` | *None* | Position / Job title (e.g. Senior Laravel Developer) |
| `company_name` | `VARCHAR(255)` | `NOT NULL` | *None* | Hiring enterprise, startup, or institution |
| `location` | `VARCHAR(255)` | `NULLABLE` | `NULL` | Work location or modality (e.g. İstanbul, Uzaktan, Hibrit) |
| `type` | `VARCHAR(255)` | `NOT NULL` | `'Full-time'` | Employment type (`Full-time`, `Part-time`, `Remote`, `Internship`) |
| `description` | `TEXT` | `NOT NULL` | *None* | Comprehensive role description, responsibilities, and team context |
| `requirements` | `TEXT` | `NULLABLE` | `NULL` | Mandatory qualifications, required tech stack, and experience level |
| `application_deadline` | `DATE` | `NULLABLE` | `NULL` | Deadline date for application submissions (YYYY-MM-DD) |
| `contact_email` | `VARCHAR(255)` | `NULLABLE` | `NULL` | Direct inquiry & application submission email address |
| `is_active` | `BOOLEAN` | `NOT NULL` | `TRUE (1)` | Publication visibility flag (`1`: active on job board, `0`: closed) |
| `created_at` | `TIMESTAMP` | `NULLABLE` | `NULL` | Record creation timestamp |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | `NULL` | Last modification timestamp |

#### Relational Constraints & Foreign Keys:
- **`job_postings_user_id_foreign`:**
  - Foreign key constraint referencing `users.id`.
  - Configured with `ON DELETE CASCADE`. If the publishing user account is deleted, all their posted jobs are automatically purged by MySQL to preserve referential integrity.

#### Eloquent Model Configuration & Casting:
- **Mass-Assignable Fillable Attributes:**
  `['user_id', 'title', 'company_name', 'location', 'type', 'description', 'requirements', 'application_deadline', 'contact_email', 'is_active']`
- **Attribute Casting:**
  - `'application_deadline' => 'date'`
  - `'is_active' => 'boolean'`
- **Relationships:**
  - `user(): BelongsTo` &rarr; Returns the associated `App\Models\User` instance.
  - Inverse relationship: `User::jobPostings(): HasMany` &rarr; Returns all job postings authored by the user.

#### Routing & Interface Access Matrix:
- **Web MVC Views (Blade):**
  - `GET /job-postings` &rarr; `JobPostingController@index` (Catalog view with search & stats)
  - `GET /job-postings/create` &rarr; `JobPostingController@create` (Job creation form)
  - `POST /job-postings` &rarr; `JobPostingController@store` (Persists new job to MySQL)
  - `GET /job-postings/{id}` &rarr; `JobPostingController@show` (Job detail view)
  - `GET /job-postings/{id}/edit` &rarr; `JobPostingController@edit` (Modification form)
  - `PUT/PATCH /job-postings/{id}` &rarr; `JobPostingController@update` (Updates job in MySQL)
  - `DELETE /job-postings/{id}` &rarr; `JobPostingController@destroy` (Deletes job from MySQL)
- **RESTful API Endpoints (`/api/job-postings`):**
  - `GET /api/job-postings` &rarr; Lists postings with `?company=...` and `?active=1` filtering.
  - `POST /api/job-postings` &rarr; Creates posting with JSON payload and assigns `user_id`.
  - `GET /api/job-postings/{id}` &rarr; Returns single job posting with attached publisher user.
  - `PUT /api/job-postings/{id}` &rarr; Updates posting in MySQL database.
  - `DELETE /api/job-postings/{id}` &rarr; Deletes posting from MySQL database.
- **Filament Admin Panel:**
  - `/admin/job-postings` &rarr; `App\Filament\Resources\JobPostingResource` (Visual management, badge indicators, filters).

---

### 4.7 Events (`events`)
- **Purpose:** Reunions, seminars, webinars, and networking meetups for the alumni community.
- **Migration:** `2026_09_23_073306_create_events_table.php`
- **Eloquent Model:** [`app/Models/Event.php`](app/Models/Event.php)

| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PRIMARY KEY`, `AUTO_INCREMENT` | Unique event identifier |
| `title` | `VARCHAR(255)` | `NOT NULL` | Title of the event |
| `description` | `TEXT` | `NOT NULL` | Full event agenda and details |
| `event_date` | `DATETIME` | `NOT NULL` | Scheduled date and time of the event |
| `location` | `VARCHAR(255)` | `NULLABLE` | Physical venue or room |
| `is_online` | `BOOLEAN` | `DEFAULT FALSE` | Virtual/Online meeting indicator |
| `meeting_link` | `VARCHAR(255)` | `NULLABLE` | URL for Zoom, Google Meet, or Teams session |
| `is_active` | `BOOLEAN` | `DEFAULT TRUE` | Active status flag for public display |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Event creation timestamp |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Event last update timestamp |

---

### 4.8 Announcements Entity (`announcements`)
- **Purpose:** Official notices, scholarships, career calls, and administrative alerts.
- **Migration:** `2026_10_14_200304_create_announcements_table.php`
- **Model:** [`app/Models/Announcement.php`](app/Models/Announcement.php) & [`app/Models/InMemoryAnnouncement.php`](app/Models/InMemoryAnnouncement.php)
- **Storage:** Relational MySQL table `announcements` & in-memory cache abstraction.

| Attribute | Type | Values / Defaults | Description |
| :--- | :--- | :--- | :--- |
| `id` | `INT` | Auto-incremented integer | Unique announcement ID |
| `title` | `STRING` | Required | Title of the announcement |
| `content` | `STRING` | Required | Comprehensive announcement body text |
| `category` | `STRING` | `Genel`, `Etkinlik`, `Kariyer`, `Burs & Akademi` | Categorization tag |
| `author` | `STRING` | Default: `Mezunlar Ofisi` | Publishing entity or coordinator |
| `target_audience`| `STRING` | Default: `Tüm Mezunlar` | Intended group of recipients |
| `is_pinned` | `BOOLEAN`| Default: `FALSE` | Featured/Sticky notice at top of lists |
| `status` | `STRING` | `published`, `draft`, `archived` | Publication workflow state |
| `published_at` | `TIMESTAMP`| ISO 8601 String | Actual publication date |
| `created_at` | `TIMESTAMP`| ISO 8601 String | Creation timestamp |
| `updated_at` | `TIMESTAMP`| ISO 8601 String (`NULLABLE`) | Last modification timestamp |

---

### 4.9 Cache & Session Storage (`cache`, `sessions`)
- **Purpose:** Fast caching of API queries and persistent state without a direct MySQL dependency.
- **Migrations:** `0001_01_01_000001_create_cache_table.php`, `0001_01_01_000000_create_users_table.php`

```sql
CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL PRIMARY KEY,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL
);

CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL PRIMARY KEY,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL
);
```

---

### 4.10 Job Applications (`job_applications` / `applications`)
- **Purpose:** Tracks employment applications, cover notes, and resumes submitted by alumni and students for active job postings.
- **Migration:** [`database/migrations/2026_10_21_073000_create_job_applications_table.php`](database/migrations/2026_10_21_073000_create_job_applications_table.php)
- **Eloquent Models:** [`app/Models/JobApplication.php`](app/Models/JobApplication.php) & [`app/Models/Application.php`](app/Models/Application.php)
- **Model Factory:** [`database/factories/JobApplicationFactory.php`](database/factories/JobApplicationFactory.php)
- **Database Compatibility:** Features MySQL native table `job_applications` with an updatable view `applications` for universal query compatibility.

#### Schema & Column Specifications:

| Column | Type | Constraints | Default | Description |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | `PRIMARY KEY`, `AUTO_INCREMENT` | *None* | Unique job application identifier |
| `job_posting_id` | `BIGINT UNSIGNED` | `NOT NULL`, `FK` &rarr; `job_postings(id)`, `ON DELETE CASCADE` | *None* | Associated job posting identifier |
| `user_id` | `BIGINT UNSIGNED` | `NOT NULL`, `FK` &rarr; `users(id)`, `ON DELETE CASCADE` | *None* | Associated applicant user account ID |
| `cover_letter` | `TEXT` | `NULLABLE` | `NULL` | Candidate statement of interest / cover message |
| `resume_path` | `VARCHAR(255)` | `NULLABLE` | `NULL` | Uploaded CV document path or link |
| `status` | `VARCHAR(50)` | `NOT NULL` | `'pending'` | Workflow state (`pending`, `reviewed`, `shortlisted`, `accepted`, `rejected`) |
| `notes` | `TEXT` | `NULLABLE` | `NULL` | Internal evaluation / recruiter feedback |
| `applied_at` | `TIMESTAMP` | `NULLABLE` | `NULL` | Submission timestamp |
| `created_at` | `TIMESTAMP` | `NULLABLE` | `NULL` | Record creation timestamp |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | `NULL` | Record last update timestamp |

#### Relational Constraints & Composite Keys:
- **`unique_user_job_application`:** Unique compound index on `(job_posting_id, user_id)` guaranteeing that a user can submit only one application per job posting.
- **`job_applications_job_posting_id_foreign`:** Cascades on delete (`ON DELETE CASCADE`).
- **`job_applications_user_id_foreign`:** Cascades on delete (`ON DELETE CASCADE`).

#### Eloquent Model Configuration & Casting:
- **Mass-Assignable Fillable Attributes:**
  `['job_posting_id', 'user_id', 'cover_letter', 'resume_path', 'status', 'notes', 'applied_at']`
- **Attribute Casting:**
  - `'applied_at' => 'datetime'`
- **Relationships:**
  - `jobPosting(): BelongsTo` &rarr; Returns target `App\Models\JobPosting`.
  - `user(): BelongsTo` &rarr; Returns applicant `App\Models\User`.
  - `applicant(): BelongsTo` &rarr; Convenient alias for `user()`.

---

## 5. 🛡️ Data Integrity & Relationship Constraints

The database enforces strict referential integrity rules:
1. **User Deletion Cascades (`ON DELETE CASCADE`):**
   - When a record in `users` is deleted, all associated `alumni_profiles`, `experiences`, `job_postings`, and `job_applications` are automatically purged by MySQL foreign keys, preventing orphaned data.
2. **Job Posting Deletion Cascades (`ON DELETE CASCADE`):**
   - When a record in `job_postings` is deleted, all submitted `job_applications` are automatically purged.
3. **Department Protection (`ON DELETE SET NULL`):**
   - If an academic department is deleted or merged, `alumni_profiles.department_id` is automatically set to `NULL` to preserve the graduate's historical profile and contact details.
4. **Faculty Deletion Cascades (`ON DELETE CASCADE`):**
   - Deleting a faculty cascades to all departments belonging to that faculty.
4. **Targeted Performance Indexes:**
   - Indexes are established on frequently filtered columns:
     - `alumni_profiles.graduation_year`
     - `alumni_profiles.current_company`
     - `alumni_profiles.city`
     - `alumni_profiles.status`

---

## 6. 🔄 State Machines & Entity Lifecycles

### Alumni Profile Status Workflow
```mermaid
stateDiagram-v2
    [*] --> pending: Alumnus registers profile
    pending --> approved: Coordinator verifies student number & diploma
    pending --> rejected: Invalid graduation or duplicate record
    rejected --> pending: Alumnus submits corrected documentation
    approved --> [*]: Active in public alumni directory
```

### Job Posting Lifecycle
```mermaid
stateDiagram-v2
    [*] --> Active: Coordinator or Alumnus posts job
    Active --> Expired: Application deadline date reached
    Active --> Closed: Position filled / manually closed (is_active = 0)
    Closed --> Active: Re-opened by creator
    Closed --> [*]: Deleted
```

### Job Application Status Workflow
```mermaid
stateDiagram-v2
    [*] --> pending: Alumnus submits application
    pending --> reviewed: Recruiter/Poster reviews profile & CV
    reviewed --> shortlisted: Candidate advanced to interview
    reviewed --> rejected: Not matching requirements
    shortlisted --> accepted: Candidate offered position
    shortlisted --> rejected: Not selected
    accepted --> [*]: Application successful
    rejected --> [*]: Application closed
```

---

## 7. 🚦 Direct vs. Nested Routing Architecture

The HTTP routing layer is structured into **Direct (Top-Level)** and **Nested (Scoped/Hierarchical)** routes to support both decoupled catalog queries and relational parent-child data operations:

### 7.1 Direct Routes (Bağımsız Doğrudan Rotalar)
Direct routes access an entity collection or single record directly by its unique identifier:

| HTTP Method | Route URI | Controller & Action | Resource Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/users` | `UserController@index` | HTML view: All users list |
| `GET` | `/users/{id}` | `UserController@show` | HTML view: Single user detail |
| `GET` | `/api/users` | `ApiUserController@index` | JSON: All users list |
| `GET` | `/api/users/{id}` | `ApiUserController@show` | JSON: Single user detail |
| `GET` | `/job-postings` | `JobPostingController@index` | HTML view: Job catalog |
| `GET` | `/api/job-postings` | `ApiJobPostingController@index` | JSON: All job postings |
| `GET` | `/api/job-postings/{id}` | `ApiJobPostingController@show` | JSON: Single job detail |
| `GET` | `/announcements` | `AnnouncementController@index` | HTML view: Announcements |
| `GET` | `/api/announcements` | `ApiAnnouncementController@index` | JSON: Announcements list |
| `GET` | `/api/faculties` | `ApiFacultyController@index` | JSON: All university faculties |
| `GET` | `/api/faculties/{id}` | `ApiFacultyController@show` | JSON: Single faculty details |
| `GET` | `/api/departments` | `ApiDepartmentController@index` | JSON: All academic departments |
| `GET` | `/api/departments/{id}` | `ApiDepartmentController@show` | JSON: Single department details |
| `GET` | `/api/experiences/{id}` | `ApiExperienceController@show` | JSON: Single experience record |
| `PUT` | `/api/experiences/{id}` | `ApiExperienceController@update` | JSON: Update experience |
| `DELETE` | `/api/experiences/{id}` | `ApiExperienceController@destroy` | JSON: Delete experience |
| `GET` | `/api/events` | `ApiEventController@index` | JSON: All upcoming/past events |
| `POST` | `/api/events` | `ApiEventController@store` | JSON: Create a new event |
| `GET` | `/api/events/{id}` | `ApiEventController@show` | JSON: Event details |
| `GET` | `/api/applications` | `ApiJobApplicationController@index` | JSON: All job applications |
| `POST` | `/api/applications` | `ApiJobApplicationController@store` | JSON: Submit an application |
| `GET` | `/api/applications/{id}` | `ApiJobApplicationController@show` | JSON: Single application details |
| `PUT/PATCH` | `/api/applications/{id}` | `ApiJobApplicationController@update` | JSON: Update application status & notes |
| `DELETE` | `/api/applications/{id}` | `ApiJobApplicationController@destroy` | JSON: Delete / withdraw application |

---

### 7.2 Nested Routes (İç İçe / Bağımlı Rotalar)
Nested routes represent child entities scoped strictly under their parent entity identifier:

```mermaid
graph LR
    Faculty["/api/faculties/{id}"] -->|"/departments"| FacultyDepts["Departments under Faculty"]
    Dept["/api/departments/{id}"] -->|"/alumni"| DeptAlumni["Alumni of Department"]
    User["/api/users/{id}"] -->|"/profile"| UserProfile["1:1 Alumni Profile"]
    User -->|"/experiences"| UserExp["1:N Career Experiences"]
    User -->|"/job-postings"| UserJobs["1:N Authored Job Postings"]
    User -->|"/applications"| UserApps["1:N Submitted Applications"]
    Job["/api/job-postings/{id}"] -->|"/applications"| JobApps["1:N Received Applications"]
```

| HTTP Method | Route URI | Controller & Action | Relational Scope & Purpose |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/faculties/{id}/departments` | `ApiFacultyController@departments` | Lists all departments belonging to the specified faculty |
| `POST` | `/api/faculties/{id}/departments` | `ApiFacultyController@storeDepartment` | Creates a new department nested under the specified faculty |
| `GET` | `/api/departments/{id}/alumni` | `ApiDepartmentController@alumni` | Lists all alumni graduates from the specified department |
| `GET` | `/api/users/{id}/profile` | `ApiUserController@profile` | Returns the 1:1 alumni profile for the specified user |
| `PUT/PATCH` | `/api/users/{id}/profile` | `ApiUserController@updateProfile` | Updates the 1:1 alumni profile for the specified user |
| `GET` | `/api/users/{id}/experiences` | `ApiUserController@experiences` | Lists all 1:N career experiences belonging to this user |
| `POST` | `/api/users/{id}/experiences` | `ApiUserController@storeExperience` | Creates a new career experience scoped to this user |
| `GET` | `/api/users/{id}/job-postings` | `ApiUserController@jobPostings` | Lists all 1:N job postings authored by this user |
| `POST` | `/api/users/{id}/job-postings` | `ApiUserController@storeJobPosting` | Creates a new job posting authored by this user |
| `GET` | `/api/users/{id}/applications` | `ApiUserController@applications` | Lists all 1:N job applications submitted by this user |
| `POST` | `/api/users/{id}/applications` | `ApiUserController@storeApplication` | Submits a new job application on behalf of this user |
| `GET` | `/api/job-postings/{id}/applications` | `ApiJobApplicationController@forJobPosting` | Lists all candidate applications received for this job posting |
| `POST` | `/api/job-postings/{id}/applications` | `ApiJobApplicationController@storeForJobPosting` | Submits an application directly to this job posting |

---

## 8. 🧪 Persistence Strategy & "The Forgetting Test" Verification

A critical concern in containerized cloud native environments is **Data Persistence** across service lifecycles.

### Docker Volume Mapping
In `docker-compose.yml`, MySQL data is mapped to a dedicated named volume:
```yaml
volumes:
  - alumni_mysql_data:/var/lib/mysql

volumes:
  alumni_mysql_data:
    driver: local
```

### The Forgetting Test Verification
The persistence was verified via **"The Forgetting Test"**:
1. **Records Created:**
   - MySQL `events` table: Record `#3` (`Forgetting Test Reunion 2026`)
   - API Cache user `#7` (`test.forgetting@alumni.edu.tr`)
   - API Cache job `#5` (`Forgetting Test Cloud Architect`)
2. **Teardown:** `docker compose down` stopped and removed all containers and networks.
3. **Recreation:** `docker compose up -d` rebuilt and relaunched services.
4. **Verification Result:** All records were queried and verified to exist with 100% integrity:
   ```text
   id: 3 | Forgetting Test Reunion 2026 | Grand Persistence Hall | 2026-12-31 20:00:00
   AFTER UP -> User: Forgetting Test User - test.forgetting@alumni.edu.tr
   AFTER UP -> Job: Forgetting Test Cloud Architect at Docker Persistence Corp
   ```
   **Verdict:** **PASSED ✅** — Zero data loss across container teardown.

---

## 9. 🔗 Cross-Reference Navigation

- 📄 **Main Architecture & Setup:** [README.md](README.md)
- 📡 **REST API Specification:** [public/openapi.json](public/openapi.json)
- 👁️ **Live Interactive Swagger UI:** [resources/views/swagger.blade.php](resources/views/swagger.blade.php)
- 🎮 **HTTP Routes Definition:** [routes/web.php](routes/web.php)
- 🐳 **Docker Multi-Container Spec:** [docker-compose.yml](docker-compose.yml)
