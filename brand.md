# 🎨 Brand Identity & Design System Guidelines (`brand.md`)

[← Back to Main Documentation (README.md)](README.md) &bull; [Visual Design System (DESIGN.md)](DESIGN.md) &bull; [Data Design Documentation (ddd.md)](ddd.md) &bull; [Interactive Swagger API UI](resources/views/swagger.blade.php) &bull; [OpenAPI 3.0 Specification](public/openapi.json)

---

## 📑 Table of Contents
1. [Brand Overview & Core Philosophy](#1-brand-overview--core-philosophy)
2. [Brand Voice, Tone & Messaging](#2-brand-voice-tone--messaging)
3. [Logo & Emblem Identity](#3-logo--emblem-identity)
4. [Color Palette & Design Tokens](#4-color-palette--design-tokens)
   - [4.1 Primary Brand Colors (Indigo Spectrum)](#41-primary-brand-colors-indigo-spectrum)
   - [4.2 Semantic & Status Colors](#42-semantic--status-colors)
   - [4.3 Neutral Slate Palette (Surfaces & Typography)](#43-neutral-slate-palette-surfaces--typography)
   - [4.4 Workplace Type Badges & Semantic Mapping](#44-workplace-type-badges--semantic-mapping)
5. [Typography Hierarchy](#5-typography-hierarchy)
   - [5.1 Primary Typeface: Plus Jakarta Sans](#51-primary-typeface-plus-jakarta-sans)
   - [5.2 Type Scale & Hierarchy Matrix](#52-type-scale--hierarchy-matrix)
   - [5.3 Monospace / Code Typography](#53-monospace--code-typography)
6. [Component Design Standards](#6-component-design-standards)
   - [6.1 Buttons & Interactive Actions](#61-buttons--interactive-actions)
   - [6.2 Cards & Surface Containers](#62-cards--surface-containers)
   - [6.3 Search Inputs & Form Controls](#63-search-inputs--form-controls)
   - [6.4 Metric & Impact Stat Displays](#64-metric--impact-stat-displays)
7. [Iconography & Visual Motifs](#7-iconography--visual-motifs)
8. [Layout Grid, Spacing & Breakpoints](#8-layout-grid-spacing--breakpoints)
9. [Brand Asset Usage Rules (Do's & Don'ts)](#9-brand-asset-usage-rules-dos--donts)
10. [Cross-Reference Navigation](#10-cross-reference-navigation)

---

## 1. 🎯 Brand Overview & Core Philosophy

The **Alumni Tracking System** (*Mezun Takip Sistemi*) is the official institutional ecosystem connecting universities, academic faculties, and students with their global graduate community.

### 🌟 Brand Essence & Mission
* **Core Purpose:** To transform passive graduation records into a vibrant, lifelong academic and professional solidarity network.
* **Core Values:**
  1. **Trust & Authenticity (Güven ve Doğruluk):** Verified alumni profiles linked to institutional student records.
  2. **Transparency (Şeffaflık):** Mandatory salary disclosure and explicit workplace models (*Remote, Hybrid, In-Office*) across career postings.
  3. **Solidarity (Dayanışma):** Senior graduates guiding younger generations via dedicated career mentorship programs.
  4. **Modern Elegance (Modern ve Yalın Tasarım):** High-performance, accessible, responsive interfaces built on Tailwind CSS and TALL stack principles.

### 🏷️ Brand Attributes
| Attribute | Meaning in Product Design |
| :--- | :--- |
| **Prestigious & Academic** | Deep indigos, refined navy tones, clean serif/sans balances evoking academic excellence. |
| **Dynamic & Modern** | Generous whitespace, rounded-2xl cards, subtle backdrop blurs, and crisp micro-interactions. |
| **Inclusive & Warm** | Welcoming community voice, accessible contrast ratios (WCAG AA compliant), clear navigation. |
| **Transparent & Actionable**| High-visibility status tags, salary figures, and structured error/confirmation feedback. |

---

## 2. 🗣️ Brand Voice, Tone & Messaging

The brand voice speaks with institutional credibility while remaining accessible, supportive, and modern.

### Tone Spectrum
* **Welcoming, Not Distant:** Address alumni as valued members of a lifelong community, not cold database entities.
* **Professional, Not Stiff:** Use clean, contemporary phrasing; avoid overly bureaucratic academic jargon.
* **Transparent & Direct:** Clear instructions, unambiguous job requirements, and honest error reasons (powered by Guardian Middleware).

### Standard Brand Terminology
| Context | Approved Term (TR) | Approved Term (EN) | Deprecated / Avoid |
| :--- | :--- | :--- | :--- |
| **Platform Name** | Mezun Takip Sistemi | Alumni Tracking System | Mezunlar Sitesi, Eski Öğrenciler |
| **Alumni Directory**| Mezun Rehberi | Alumni Directory | Üye Listesi, Kullanıcılar |
| **Career Board** | Kariyer & İş İlanları | Career & Job Board | İlan Sayfası, Eleman Arayanlar |
| **Work Model** | Çalışma Modeli (`Hibrit`, `Uzaktan`, `Ofiste`) | Workplace Type (`Hybrid`, `Remote`, `In-Office`) | Çalışma Yeri, Lokasyon Tipi |
| **Compensation** | Şeffaf Maaş | Transparent Salary | Ücret, Para |
| **Verification** | Doğrulanmış Mezun | Verified Alumnus / Alumna | Onaylı Hesap, Fake Değil |
| **Admin Panel** | Yönetim Paneli (Filament v3) | Administration Panel | Dashboard, Kontrol Masası |

---

## 3. 🎓 Logo & Emblem Identity

The visual identity centers on the **mortarboard / graduation cap** motif combined with modern geometric framing and gradient illumination.

```text
 ┌────────────────────────────────────────────────────────┐
 │   ┌──────┐                                             │
 │   │  🎓  │   Mezun Takip Sistemi                       │
 │   └──────┘   Üniversite Kariyer & İletişim Ağı         │
 └────────────────────────────────────────────────────────┘
```

### Primary Logo Construction
* **Icon Mark:** Mortarboard (`🎓`) placed inside an `11x11` (`44px x 44px`) rounded container with a diagonal gradient:
  - Gradient: `from-indigo-600 to-indigo-800` (`#4f46e5` &rarr; `#3730a3`).
  - Corner Radius: `rounded-xl` (`12px`).
  - Shadow: Soft colored elevation (`shadow-md shadow-indigo-600/20`).
* **Wordmark Typography:**
  - **Line 1 (Title):** `font-extrabold text-xl tracking-tight text-slate-900` ("Mezun Takip Sistemi").
  - **Line 2 (Eyebrow/Sub-brand):** `text-[11px] font-semibold text-slate-500 tracking-wider uppercase` ("Üniversite Kariyer & İletişim Ağı").
* **Clearspace Rule:** Maintain minimum whitespace equal to the width of the icon mark on all four sides.
* **Minimum Sizing:**
  - Digital screens: Minimum `32px` icon height / `160px` combined logo width.
  - Print / Favicon: `16x16` or `32x32` square emblem.

---

## 4. 🎨 Color Palette & Design Tokens

The color architecture utilizes a primary **Indigo Spectrum** representing intellect and institutional dignity, balanced by functional **Semantic Accents** and a clean **Neutral Slate** scale.

### 4.1 Primary Brand Colors (Indigo Spectrum)

| Color Token | Tailwind Class | HEX Code | RGB | Purpose & Usage |
| :--- | :--- | :--- | :--- | :--- |
| **Brand 50** | `bg-indigo-50` / `bg-brand-50` | `#EEF2FF` | `238, 242, 255` | Light tinted card backgrounds, active nav pills |
| **Brand 100** | `bg-indigo-100` / `bg-brand-100`| `#E0E7FF` | `224, 231, 255` | Subtle badge borders, hover card highlights |
| **Brand 200** | `border-indigo-200` | `#C7D2FE` | `199, 210, 254` | Distinct component borders, pill outlines |
| **Brand 500** | `bg-indigo-500` | `#6366F1` | `99, 102, 241` | Accent buttons, text gradient midpoint |
| **Brand 600 (Primary)**| `bg-indigo-600` / `text-indigo-600` | `#4F46E5` | `79, 70, 229` | **Primary CTA buttons**, active tabs, brand accents |
| **Brand 700** | `bg-indigo-700` / `hover:bg-indigo-700` | `#4338CA` | `67, 56, 202` | Button hover states, emphasized text |
| **Brand 800** | `bg-indigo-800` | `#3730A3` | `55, 48, 163` | Deep gradient endpoints, footer badges |
| **Brand 900** | `bg-indigo-900` / `text-indigo-900` | `#312E81` | `49, 46, 129` | Hero section header text, high-contrast dark accents |
| **Brand 950 (Hero Base)** | `bg-slate-900` / `#0F172A` | `#0F172A` | `15, 23, 42` | Hero background surface, deep dark banners |

### 4.2 Semantic & Status Colors

| Semantic Role | Token & Tailwind | HEX Code | Application |
| :--- | :--- | :--- | :--- |
| **Success / Verified** | `emerald-500` / `bg-emerald-50` / `text-emerald-700` | `#10B981` | Remote workplace tags, verified alumni badges, healthy API status |
| **Warning / Hybrid** | `amber-500` / `bg-amber-50` / `text-amber-700` | `#F59E0B` | Hybrid workplace tags, pending reviews, event alerts |
| **Info / In-Office** | `blue-500` / `bg-blue-50` / `text-blue-700` | `#3B82F6` | In-Office workplace tags, faculty announcements, informational dialogs |
| **Error / Alert** | `rose-600` / `bg-rose-50` / `text-rose-700` | `#E11D48` | Form validation failures, 404/5xx error badges, closed job banners |
| **Community / Zirve** | `purple-600` / `bg-purple-50` / `text-purple-700` | `#9333EA` | Mentorship programs, alumni summits, student-led initiatives |

### 4.3 Neutral Slate Palette (Surfaces & Typography)

```text
 ┌────────────────────────────────────────────────────────┐
 │ Slate-50   (#F8FAFC) ── App Background Surface         │
 │ Slate-100  (#F1F5F9) ── Sub-card Backgrounds / Hover   │
 │ Slate-200  (#E2E8F0) ── Structural Borders & Dividers  │
 │ Slate-400  (#94A3B8) ── Metadata & Placeholder Text    │
 │ Slate-600  (#475569) ── Body & Paragraph Typography    │
 │ Slate-900  (#0F172A) ── Primary Headings & Dark UI     │
 └────────────────────────────────────────────────────────┘
```

### 4.4 Workplace Type Badges & Semantic Mapping
The system enforces strict, standardized color tokens for job workplace arrangements:

* **Uzaktan / Remote:**
  ```html
  <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1">
      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Uzaktan / Remote
  </span>
  ```
* **Hibrit / Hybrid:**
  ```html
  <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 flex items-center gap-1">
      <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Hibrit / Hybrid
  </span>
  ```
* **Ofiste / In-Office:**
  ```html
  <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 flex items-center gap-1">
      <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Ofiste / In-Office
  </span>
  ```

---

## 5. ✍️ Typography Hierarchy

Typography is set in **Plus Jakarta Sans**, a geometric neo-grotesque sans-serif offering clarity across both small mobile badges and large editorial headlines.

### 5.1 Primary Typeface: Plus Jakarta Sans
* **Google Fonts Import:**
  ```html
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  ```
* **CSS Family Rule:**
  ```css
  body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }
  ```

### 5.2 Type Scale & Hierarchy Matrix

| Element | Tailwind Classes | Size (px / rem) | Weight | Line Height | Usage |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Display H1** | `text-4xl sm:text-5xl lg:text-6xl` | `48px - 60px` | 800 (ExtraBold) | `1.15` | Hero banner primary statements |
| **Section H2** | `text-3xl font-extrabold` | `30px / 1.875rem` | 800 (ExtraBold) | `1.25` | Section titles (*Öne Çıkan İlanlar, Duyurular*) |
| **Card H3** | `text-xl font-bold` | `20px / 1.25rem` | 700 (Bold) | `1.35` | Job posting title, feature card headers |
| **Subheading** | `text-lg text-slate-600` | `18px / 1.125rem` | 500 (Medium) | `1.6` | Section lead paragraphs, hero subtext |
| **Body Regular**| `text-sm sm:text-base` | `14px - 16px` | 400 (Regular) | `1.65` | General content, descriptions, articles |
| **Caption / Meta**| `text-xs text-slate-500` | `12px / 0.75rem` | 500 (Medium) | `1.4` | Timestamps, author lines, fine print |
| **Pill / Badge**| `text-[10px] sm:text-xs` | `10px - 12px` | 700 (Bold) | `1` | Workplace tags, category pills, counters |

### 5.3 Monospace / Code Typography
* **Stack:** `ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace`
* **Application:** API endpoints (`/api/users`), JSON response payloads, Swagger code samples, and CLI log rows (`LoggerMiddleware` live format).

---

## 6. 🧱 Component Design Standards

All UI building blocks adhere to unified token rules for radii, elevation, and interaction states.

### 6.1 Buttons & Interactive Actions

```text
 ┌──────────────────────────┐   ┌──────────────────────────┐
 │  Primary: Indigo Solid   │   │  Secondary: Clean White  │
 │  [👥 Mezun Rehberi &rarr;]    │   │  [💼 Kariyer & İlanlar]   │
 └──────────────────────────┘   └──────────────────────────┘
```

1. **Primary Action Button (Indigo):**
   - Class: `px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/30 hover:-translate-y-0.5 transition duration-150`
   - Purpose: Main forward flow (*Başvur, Kaydet, Giriş Yap, İncele*).
2. **Secondary Neutral Button (White/Slate):**
   - Class: `px-6 py-3 bg-white hover:bg-slate-100 text-slate-900 font-bold rounded-xl border border-slate-200 shadow-sm hover:-translate-y-0.5 transition duration-150`
   - Purpose: Alternative exploration actions (*Filtreleri Temizle, İlanları Gör*).
3. **Subtle Brand Button (Light Tint):**
   - Class: `px-4 py-2 text-sm font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl border border-indigo-200 transition`
   - Purpose: Auxiliary triggers (*+ Yeni İlan Ver, Detay Gör*).

### 6.2 Cards & Surface Containers
* **Standard Card:**
  - Background: `bg-white`
  - Border: `border border-slate-200/90`
  - Radius: `rounded-2xl` (`16px`)
  - Padding: `p-6` (`24px`)
  - Hover: `hover:shadow-md hover:border-indigo-200 transition-all duration-200`
* **Glassmorphism Card (Dark Backgrounds):**
  - Background: `rgba(255, 255, 255, 0.10)` with `backdrop-blur-md`
  - Border: `border border-white/20`
  - Radius: `rounded-2xl`

### 6.3 Search Inputs & Form Controls
* **Search Bar Container:** `bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20 shadow-2xl`
* **Input Elements:** `rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm`
* **Placeholder Color:** `placeholder:text-slate-400`

### 6.4 Metric & Impact Stat Displays
* Large figures: `text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight`
* Label: `text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1`
* Icon Container: `w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl`

---

## 7. 🎭 Iconography & Visual Motifs

The system uses standard high-recognition emoji and SVG motifs to reinforce visual hierarchy:

| Motif | Symbol | Meaning | Component Placement |
| :---: | :---: | :--- | :--- |
| **Graduation** | 🎓 | University, Alumni, Platform Identity | Header logo, total alumni stats, degree badges |
| **Career / Job**| 💼 | Professional opportunities, job listings | Job cards, navigation, salary tags |
| **Employment** | 📈 | Growth, employment rate, statistics | Impact stats card (`%94.2 İstihdam`) |
| **Community** | 👥 | Alumni network, mentorship, directory | Navigation pill, directory search |
| **Campus / Dept**| 🏛️ | Academic units, departments, faculties | Department stats, institutional announcements |
| **Security / Guard**| 🛡️ | Verification, Guardian 404/5xx middleware | Footer security badge, error view headers |
| **Events / News**| 📢 / 📅 | Announcements, reunions, webinars | Announcements grid, event date badges |
| **Lightning API**| ⚡ | Swagger OpenAPI 3.0 specification | Header API button, developer footer link |

---

## 8. 📐 Layout Grid, Spacing & Breakpoints

The application enforces consistent container widths and responsive boundaries across all views:

### Container Max-Widths
* **App Maximum:** `max-w-7xl` (`1280px` / `80rem`) with responsive padding:
  - Mobile: `px-4` (`16px`)
  - Tablet: `sm:px-6` (`24px`)
  - Desktop: `lg:px-8` (`32px`)
* **Focused Forms & Reading Views:** `max-w-3xl` (`768px`) or `max-w-4xl` (`896px`)

### Responsive Breakpoints (Tailwind CSS Default)
| Breakpoint | Minimum Width | Target Layout Behavior |
| :--- | :--- | :--- |
| **`sm`** | `640px` | 2-column metric cards, inline action buttons |
| **`md`** | `768px` | 2-column job cards, side-by-side forms |
| **`lg`** | `1024px` | Full desktop navbar, 3-column features and announcements |
| **`xl`** | `1280px` | Full 4-column metric grid, maximized hero spacing |

---

## 9. 🚫 Brand Asset Usage Rules (Do's & Don'ts)

To preserve brand authority and aesthetic cohesion, follow these strict rules:

### ✅ DO:
* **Always display workplace type** with its matching semantic color badge (`Remote` &rarr; Emerald, `Hybrid` &rarr; Amber, `In-Office` &rarr; Blue).
* **Always present salary figures** with currency prefix and time interval (e.g. `₺85.000 / ay`).
* **Maintain high contrast** on dark sections (slate-900 background paired with slate-200 / slate-300 body text).
* **Use rounded-xl / rounded-2xl** radii consistently across all interactive cards and modals.
* **Keep the navigation sticky** with glassmorphism blur (`bg-white/95 backdrop-blur-md`) on all public pages.

### ❌ DON'T:
* **Never use neon, low-contrast, or unapproved colors** (e.g. lime green, bright magenta) for primary actions.
* **Never hide workplace model or salary** on job cards — transparency is a mandatory brand pillar.
* **Never stretch, distort, or recolor the graduation emblem** into unreadable color pairs.
* **Never use sharp 90-degree square borders** for public buttons; always apply at least `rounded-lg` or `rounded-xl`.
* **Never display raw database stack traces** to end users — always route through Guardian 404/5xx middleware with reference IDs.

---

## 10. 🧭 Cross-Reference Navigation

| Documentation Resource | Scope & Purpose | Link |
| :--- | :--- | :--- |
| **Main Project Documentation** | Complete project guide, Docker setup, and features | [**README.md**](README.md) |
| **Visual Design System (DESIGN.md)** | Refero-inspired visual architecture, tokens & components | [**DESIGN.md**](DESIGN.md) |
| **Data Design Document (DDD)** | ER Diagram, column dictionaries, and persistence rules | [**ddd.md**](ddd.md) / [**add.md**](add.md) |
| **Interactive Swagger API** | Live browser API testing for users and jobs | [**Swagger UI**](resources/views/swagger.blade.php) |
| **OpenAPI 3.0 Specification** | Machine-readable API schema definition | [**public/openapi.json**](public/openapi.json) |
| **Generic 404 Error View** | Guardian 404 template with dynamic reason | [**404.blade.php**](resources/views/errors/404.blade.php) |
| **Generic 500 Error View** | Guardian 5xx template with reference ID | [**500.blade.php**](resources/views/errors/500.blade.php) |
