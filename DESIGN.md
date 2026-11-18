# 🎨 Design System & Visual Architecture (`DESIGN.md`)
> **An Editorial Academic Zine meets Modern Community Platform**  
> Synthesizing inspiration from leading design systems on [Refero Design](https://refero.design) into the official visual language of the **Alumni Tracking System** (*Mezun Takip Sistemi*).

[← Back to Main Documentation (README.md)](README.md) &bull; [Brand Guidelines (brand.md)](brand.md) &bull; [Data Design (ddd.md)](ddd.md) &bull; [Swagger API UI](resources/views/swagger.blade.php)

---

## 📑 Table of Contents
1. [Design Philosophy & Aesthetic Direction](#1-design-philosophy--aesthetic-direction)
2. [The 6 Refero Design References & Synthesis](#2-the-6-refero-design-references--synthesis)
   - [2.1 Fictional — Sticker-Bombed Display & Decals](#21-fictional--sticker-bombed-display--decals)
   - [2.2 Family — Storybook Parchment & Hairline Structure](#22-family--storybook-parchment--hairline-structure)
   - [2.3 Fable — Literary Editorial & Band-Driven Rhythm](#23-fable--literary-editorial--band-driven-rhythm)
   - [2.4 SuperHi — Art-Room Paper-Cuts & Capsule UI](#24-superhi--art-room-paper-cuts--capsule-ui)
   - [2.5 TOMO — Analog Zine & Zero-Elevation Flatness](#25-tomo--analog-zine--zero-elevation-flatness)
   - [2.6 MindMarket — Warm Cream Paper & Compressed Grotesque](#26-mindmarket--warm-cream-paper--compressed-grotesque)
3. [Unified Color Architecture & Design Tokens](#3-unified-color-architecture--design-tokens)
   - [3.1 Canvas & Surface Tokens (The Warm Paper Shift)](#31-canvas--surface-tokens-the-warm-paper-shift)
   - [3.2 Primary Academic & Brand Inks](#32-primary-academic--brand-inks)
   - [3.3 Semantic Accents & Sticker Colors](#33-semantic-accents--sticker-colors)
   - [3.4 Workplace Model Tokens (Remote, Hybrid, In-Office)](#34-workplace-model-tokens-remote-hybrid-in-office)
4. [Typography Engine (The Dual-Axis System)](#4-typography-engine-the-dual-axis-system)
   - [4.1 Display Engine: High-Contrast Editorial Serif](#41-display-engine-high-contrast-editorial-serif)
   - [4.2 Utility Engine: Geometric Grotesque & Neo-Sans](#42-utility-engine-geometric-grotesque--neo-sans)
   - [4.3 Monospace Accent: Technical Micro-Copy](#43-monospace-accent-technical-micro-copy)
   - [4.4 Complete Type Hierarchy Scale](#44-complete-type-hierarchy-scale)
5. [Elevation, Shapes & The "Anti-Shadow" Philosophy](#5-elevation-shapes--the-anti-shadow-philosophy)
   - [5.1 Tonal Layering vs. Muddy Shadows](#51-tonal-layering-vs-muddy-shadows)
   - [5.2 Hairline Inset Borders](#52-hairline-inset-borders)
   - [5.3 Corner Radii Hierarchy](#53-corner-radii-hierarchy)
6. [Component Blueprints & Patterns](#6-component-blueprints--patterns)
   - [6.1 Sticky Capsule Navigation](#61-sticky-capsule-navigation)
   - [6.2 Hero Section with Sticker Shouts](#62-hero-section-with-sticker-shouts)
   - [6.3 Job Posting Card with Transparent Salary Pill](#63-job-posting-card-with-transparent-salary-pill)
   - [6.4 Impact Metrics & Storybook Counters](#64-impact-metrics--storybook-counters)
   - [6.5 Announcements & Marquee Banners](#65-announcements--marquee-banners)
7. [Tailwind CSS Configuration (`tailwind.config.js`)](#7-tailwind-css-configuration-tailwindconfigjs)
8. [Developer Implementation Guide](#8-developer-implementation-guide)
9. [Reference Links & Provenance](#9-reference-links--provenance)

---

## 1. 🎯 Design Philosophy & Aesthetic Direction

Most academic and corporate alumni systems suffer from the **"Sterile SaaS Trap"**: cold, generic white backgrounds (`#ffffff`), harsh box shadows, uninspired default bootstrap layouts, and clinical data grids.

This design system deliberately breaks out of that mold by fusing **academic heritage** with the vitality of **independent print publications, modern zines, and playful editorial web experiences**.

### 🌟 Core Aesthetic Pillars:
1. **Warm Parchment Canvas (Sıcak Kağıt Zemin):** Surfaces feel like tactile book paper (`#fbf9f4` / `#f5f1e4`), eliminating digital eye fatigue and invoking university libraries and published alumni magazines.
2. **Editorial Typographic Contrast (Yazımsal Tipografi Kontrastı):** A commanding dual-engine typography — high-contrast literary serif headlines paired with ultra-clean, tightly-tracked geometric sans-serif for interface clarity.
3. **Sticker & Decal Micro-Interactions (Çıkartma ve Etiket Sistemi):** Crucial data points — such as transparent salary numbers, verified graduate badges, and workplace models (*Remote, Hybrid, In-Office*) — behave like colorful die-cut stickers placed freely on the page.
4. **Hairline Precision over Blurry Shadows (Gölgesiz İnce Çizgi Mimarisi):** Depth is created through subtle 1px hairline borders and tonal stepping (`canvas` &rarr; `surface` &rarr; `card`) rather than heavy, artificial drop-shadows.

---

## 2. 🔗 The 6 Refero Design References & Synthesis

This design system is directly informed by 6 curated visual reference architectures from [Refero Design](https://styles.refero.design):

```text
 ┌────────────────────────────────────────────────────────────────────────┐
 │                      REFERO INSPIRATION MATRIX                         │
 ├───────────────────┬────────────────────────────────────────────────────┤
 │ 1. Fictional      │ Sticker-bombed tabletop, saturated decals, pills   │
 │ 2. Family         │ Cream parchment, hairline inset borders, warmth    │
 │ 3. Fable          │ Literary reading nook, tight serifs, color bands   │
 │ 4. SuperHi        │ Paper-cut shapes, capsule buttons, monospace tags  │
 │ 5. TOMO           │ Analog zine, zero-elevation flatness, marquee tape │
 │ 6. MindMarket     │ Warm storybook paper, compressed type, fresh green │
 └───────────────────┴────────────────────────────────────────────────────┘
```

---

### 2.1 Fictional — Sticker-Bombed Display & Decals
* **Source:** [`styles.refero.design/style/af2e0bc4-ef1c-4365-a25d-00b691218431`](https://styles.refero.design/style/af2e0bc4-ef1c-4365-a25d-00b691218431)
* **Core Metaphor:** *"Sticker-bombed tabletop — vivid decals scattered across a warm cream surface, held down by chunky rounded type."*
* **Key Patterns Adopted:**
  - **Cream Blush Canvas (`#ffe9ce` / `#fbf5ed`):** A friendly, warm off-white that replaces sterile cold grey.
  - **Die-cut Decal Badges:** Saturated color blocks acting as badges (e.g. Electric Violet `#8a53ff`, Coral Blaze `#fd4b38`, Sunburst Yellow `#ffd80c`).
  - **Rotated Shouts (-8° to 12°):** Subtle rotation on featured pills (*"Yeni İlan"*, *"Popüler"*, *"Zirve"*).
  - **The 2px Solid Ring Depth:** Replacing fuzzy shadows with an intentional 2px colored ring (`rgb(251, 215, 12) 0px 0px 0px 2px`) around active controls.

---

### 2.2 Family — Storybook Parchment & Hairline Structure
* **Source:** [`styles.refero.design/style/1bcae895-2245-4d33-aa43-1c1e80719554`](https://styles.refero.design/style/1bcae895-2245-4d33-aa43-1c1e80719554)
* **Core Metaphor:** *"Storybook spread on cream parchment — generous whitespace and vivid accents punctuating a monochrome layout."*
* **Key Patterns Adopted:**
  - **Tonal Layering:** `Cream Canvas (#fbfaf9)` base paired with `Stone Surface (#f2f0ed)` for card containers. Depth is established through 1-step tone shifts, not drop-shadows.
  - **Restrained Chrome:** Interface borders remain ultra-thin (`1px solid #e5d5c3`), allowing content and typography to take center stage.
  - **Warm Ink Typography:** Text is rendered in `Ink Black (#121212)` and `Body Brown (#474645)` rather than harsh digital `#000000` or cool slate.

---

### 2.3 Fable — Literary Editorial & Band-Driven Rhythm
* **Source:** [`styles.refero.design/style/ab650279-aa18-43e5-a998-34190d7bedc7`](https://styles.refero.design/style/ab650279-aa18-43e5-a998-34190d7bedc7)
* **Core Metaphor:** *"A literary reading nook with cream paper and ink — the book is the art."*
* **Key Patterns Adopted:**
  - **Literary Serif Headlines:** Editorial display type (Fraunces / Lora / Playfair Display) set at near-black weights with ultra-tight line-heights (`0.86 – 0.94`), creating a prestigious academic book cover feel.
  - **Full-Bleed Colored Section Bands:** Deep botanical green (`#064c37`) and cerulean sky (`#43a1d7`) bands alternating with cream paper to establish strong vertical pacing.
  - **Stadium Pill Buttons:** Pill shapes with `60px` border-radius in two contrasting tones (Dark on cream, Pure White on color).

---

### 2.4 SuperHi — Art-Room Paper-Cuts & Capsule UI
* **Source:** [`styles.refero.design/style/90b8631c-4e2c-407e-86a3-d2bff456dc93`](https://styles.refero.design/style/90b8631c-4e2c-407e-86a3-d2bff456dc93)
* **Core Metaphor:** *"Paper-cut shapes scattered across a pale-blue classroom wall."*
* **Key Patterns Adopted:**
  - **Chunky Capsule Buttons:** Primary actions styled as rounded capsules (`rounded-full`) with right arrow glyphs (`&rarr;` / `svg`).
  - **Subtle Tinted Canvas:** Chalk Blue (`#f0f6ff`) and Frost Blue (`#e1edff`) used in tech-focused sections to prevent a clinical feeling.
  - **Monospace Micro-Copy:** Martian Mono / JetBrains Mono used sparingly for timestamps, API parameters, salary numbers, and technical meta-tags.

---

### 2.5 TOMO — Analog Zine & Zero-Elevation Flatness
* **Source:** [`styles.refero.design/style/6f148ff6-ae72-496a-a21d-84d7779825ff`](https://styles.refero.design/style/6f148ff6-ae72-496a-a21d-84d7779825ff)
* **Core Metaphor:** *"Torn zine pages taped to a fridge — flat, warm, and unapologetically analog."*
* **Key Patterns Adopted:**
  - **Zero-Elevation Flatness:** Explicit refusal of neumorphism, floating cards, and heavy blur shadows. Surfaces are genuinely flat and grounded.
  - **Marquee & Ribbon Banners:** Continuous text ribbons and ticker tapes (`Tomo Red #ff6347` / `Indigo Tape #312e81`) for announcements and live campus news.
  - **Razor-Thin Hairlines:** `1px` dark ink borders defining table cells and section boundaries.

---

### 2.6 MindMarket — Warm Cream Paper & Compressed Grotesque
* **Source:** [`styles.refero.design/style/9130ad37-bf80-458f-b808-ac0ef6a8d1e9`](https://styles.refero.design/style/9130ad37-bf80-458f-b808-ac0ef6a8d1e9)
* **Core Metaphor:** *"Warm storybook on cream paper — friendly editorial canvas with oversized compressed type and fresh botanical green."*
* **Key Patterns Adopted:**
  - **Compressed Display Tracking:** Grotesque type scaled to `53px – 144px` with aggressive negative letter spacing (`-0.04em` to `-0.06em`) and line-height compression (`0.95 – 1.15`).
  - **Fresh Grass Anchor (`#8ed462`):** A lively natural green used for verified checks, active job status, and success outlines.
  - **Generous 50–64px Container Radii:** Large, friendly corner curves on hero containers and primary modules.

---

## 3. 🎨 Unified Color Architecture & Design Tokens

Combining the best elements of the 6 references yields a proprietary, balanced palette for the **Alumni Tracking System**:

```text
 ┌────────────────────────────────────────────────────────────────────────┐
 │                     ALUMNI UNIFIED COLOR SCALE                         │
 ├────────────────────┬───────────┬───────────────────────────────────────┤
 │ Paper Cream Canvas │  #FBF8F3  │ Warm archival background (Fable/Family)│
 │ Stone Surface Tone │  #F2EFE9  │ Card background & insets (Family)     │
 │ Academic Navy      │  #0F172A  │ Deep authority ink & hero base (Super)│
 │ Royal Indigo CTA   │  #4F46E5  │ Primary interactive focus (Alumni)    │
 │ Fable Forest Band  │  #064C37  │ Editorial band background (Fable)     │
 │ Remote Emerald     │  #10B981  │ Uzaktan / Remote tag (MindMarket)     │
 │ Hybrid Amber       │  #F59E0B  │ Hibrit / Hybrid tag (Fictional)       │
 │ In-Office Cerulean │  #3B82F6  │ Ofiste / In-Office tag (Fable)        │
 │ Decal Coral        │  #FD4B38  │ Urgent shouts & alert states (TOMO)   │
 └────────────────────┴───────────┴───────────────────────────────────────┘
```

### 3.1 Canvas & Surface Tokens (The Warm Paper Shift)

| Token Name | HEX Code | CSS Variable | Source Reference | Role & Application |
| :--- | :--- | :--- | :--- | :--- |
| **Canvas Cream** | `#FBF8F3` | `--alumni-canvas` | Fable & Family | Default page background replacing cold `#ffffff` |
| **Surface Stone** | `#F2EFE9` | `--alumni-surface` | Family & MindMarket | Card background, secondary panels, inactive tabs |
| **Card Pure White**| `#FFFFFF` | `--alumni-card-lift` | SuperHi & TOMO | Elevated card surfaces, search bar container |
| **Hairline Stone** | `#E5DFD5` | `--alumni-hairline` | Family & TOMO | 1px clean architectural border for cards and grids |
| **Forest Band** | `#064C37` | `--alumni-band-dark` | Fable | Full-bleed editorial dark band for alumni spotlight |

### 3.2 Primary Academic & Brand Inks

| Token Name | HEX Code | CSS Variable | Source Reference | Role & Application |
| :--- | :--- | :--- | :--- | :--- |
| **Ink Near-Black**| `#121218` | `--alumni-ink` | SuperHi & Family | Primary headings, display titles, card borders |
| **Charcoal Body** | `#373634` | `--alumni-body` | Family & Fable | Body text, job descriptions, editorial prose |
| **Muted Slate** | `#6B6A68` | `--alumni-muted` | Family & MindMarket | Timestamps, author names, secondary helper text |
| **Royal Indigo** | `#4F46E5` | `--alumni-primary` | SuperHi (Electric Iris) | Primary action buttons, brand logo, active links |
| **Deep Indigo** | `#312E81` | `--alumni-indigo-dark` | Fictional | Dark navigation bars, header accents, footer base |

### 3.3 Semantic Accents & Sticker Colors

| Token Name | HEX Code | Tailwind Utility | Source Reference | Application |
| :--- | :--- | :--- | :--- | :--- |
| **Emerald Decal** | `#10B981` | `bg-emerald-500` | MindMarket (`#8ed462`) | Verified alumni check, positive confirmation |
| **Amber Burst** | `#F59E0B` | `bg-amber-500` | Fictional (`#ffd80c`) | Pending approvals, important announcements |
| **Cerulean Sky** | `#3B82F6` | `bg-blue-500` | Fable (`#43a1d7`) | Academic announcements, faculty units |
| **Coral Blaze** | `#FD4B38` | `bg-rose-500` | TOMO & Fictional | Urgent deadlines, 404/5xx error badges |
| **Plum Violet** | `#8A53FF` | `bg-purple-500` | Fictional (`#8a53ff`) | Mentorship badges, annual summit banners |

### 3.4 Workplace Model Tokens (Remote, Hybrid, In-Office)
The domain rules enforce mandatory workplace type categorization with distinct sticker badges:

```html
<!-- 1. Uzaktan / Remote: Fresh Emerald Pill -->
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
    Uzaktan / Remote
</span>

<!-- 2. Hibrit / Hybrid: Warm Amber Pill -->
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200">
    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
    Hibrit / Hybrid
</span>

<!-- 3. Ofiste / In-Office: Architectural Blue Pill -->
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-900 border border-blue-200">
    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
    Ofiste / In-Office
</span>
```

---

## 4. ✍️ Typography Engine (The Dual-Axis System)

To blend university gravitas with contemporary digital precision, the system uses a **Dual-Axis Typographic Hierarchy**:

```text
 ┌────────────────────────────────────────────────────────┐
 │  DISPLAY AXIS: Literary Academic Serif (Fable / TOMO)  │
 │  "Mezunlarımızla Geleceğe Güçlü Bir Bağ Kuruyoruz"     │
 ├────────────────────────────────────────────────────────┤
 │  UTILITY AXIS: Geometric Neo-Grotesque (MindMarket)    │
 │  Plus Jakarta Sans / Inter at -0.02em letter spacing   │
 ├────────────────────────────────────────────────────────┤
 │  CODE AXIS: Martian / JetBrains Mono (SuperHi)         │
 │  ₺85.000 / ay  •  GET /api/users  •  ERR-8F29C4B1      │
 └────────────────────────────────────────────────────────┘
```

### 4.1 Display Engine: High-Contrast Editorial Serif
* **Primary Choices:** **Fraunces** or **Lora** / **Playfair Display** (Google Fonts).
* **Characteristics:** High stroke contrast, warm terminals, compressed line-heights (`0.88 – 1.05`), slightly negative tracking.
* **Role:** Hero main titles, magazine-style quote cards, and commemorative announcement headers.

### 4.2 Utility Engine: Geometric Grotesque & Neo-Sans
* **Primary Choice:** **Plus Jakarta Sans** (Google Fonts) with **Inter** fallback.
* **Characteristics:** High x-height, open apertures, readable at micro-scales, negative tracking on headings (`-0.03em`).
* **Role:** Navigation links, search inputs, card titles, button labels, and body descriptions.

### 4.3 Monospace Accent: Technical Micro-Copy
* **Primary Choice:** **JetBrains Mono** or **Martian Mono** (Google Fonts).
* **Role:** Salary numbers, reference tracking codes (`reference_id`), API HTTP routes, and date stamps.

### 4.4 Complete Type Hierarchy Scale

| Role | Family | Weight | Size | Line Height | Tracking | Token |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **Hero Display** | Serif (Fraunces / Lora) | 700 / 800 | `54px – 68px` | `1.05` | `-0.025em` | `--font-display-hero` |
| **Section H2** | Serif or Grotesque | 800 | `32px – 40px` | `1.15` | `-0.020em` | `--font-heading-lg` |
| **Card H3** | Grotesque (Jakarta Sans)| 700 | `20px – 24px` | `1.30` | `-0.015em` | `--font-heading-md` |
| **Lead Subheading**| Grotesque | 500 | `18px – 20px` | `1.55` | `-0.010em` | `--font-subheading` |
| **Body Regular** | Grotesque | 400 | `15px – 16px` | `1.65` | `0em` | `--font-body` |
| **Small Caption** | Grotesque | 500 | `13px – 14px` | `1.40` | `+0.010em` | `--font-caption` |
| **Badge / Decal** | Grotesque / Mono | 700 | `11px – 12px` | `1.00` | `+0.020em` | `--font-badge` |
| **Technical Data**| Monospace | 600 | `13px – 15px` | `1.20` | `0em` | `--font-mono-data` |

---

## 5. 🧱 Elevation, Shapes & The "Anti-Shadow" Philosophy

Inspired by **TOMO** and **Family**, this design system replaces excessive blurry drop-shadows with structural craftsmanship.

### 5.1 Tonal Layering vs. Muddy Shadows
Instead of layering multiple heavy `box-shadow: 0 20px 25px rgba(0,0,0,0.15)` effects:
* **Level 0 (Canvas):** `#FBF8F3` (Warm paper)
* **Level 1 (Sub-panel):** `#F2EFE9` (Stone surface)
* **Level 2 (Active Card):** `#FFFFFF` (Pure white lift)
* **Level 3 (Dark Accent Band):** `#064C37` or `#0F172A` (Full-bleed solid field)

### 5.2 Hairline Inset Borders
* Every card and container is framed with a crisp **1px hairline border**:
  - Light mode: `border border-[#E5DFD5]` (Warm Stone Hairline).
  - Dark mode / Band: `border border-white/15`.
* For active focus states (inspired by **Fictional**):
  - A crisp 2px solid ring replaces the blur:
    ```css
    box-shadow: 0 0 0 2px #4F46E5; /* Indigo ring */
    ```

### 5.3 Corner Radii Hierarchy
* **Tags & Decals:** `rounded-lg` (`8px`) or `rounded-xl` (`12px`).
* **Standard Cards:** `rounded-2xl` (`18px – 24px`) for job postings and announcement items.
* **Hero & Feature Containers:** `rounded-3xl` (`28px – 36px`).
* **Pills & Action Capsules:** `rounded-full` (`9999px`) for stadium buttons and status badges.

---

## 6. 🧩 Component Blueprints & Patterns

### 6.1 Sticky Capsule Navigation
```html
<header class="sticky top-0 z-50 bg-[#FBF8F3]/90 backdrop-blur-md border-b border-[#E5DFD5]">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <!-- Logo with Academic Indigo Tile -->
        <a href="/main" class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-2xl shadow-sm">
                🎓
            </div>
            <div>
                <span class="font-extrabold text-lg text-[#121218] tracking-tight block leading-tight">Mezun Takip Sistemi</span>
                <span class="text-[11px] font-semibold text-[#6B6A68] tracking-wider uppercase">Üniversite Mezunlar Ağı</span>
            </div>
        </a>

        <!-- Capsule Navigation Links -->
        <nav class="hidden md:flex items-center gap-1 bg-[#F2EFE9] p-1.5 rounded-full border border-[#E5DFD5]">
            <a href="/main" class="px-4 py-2 rounded-full text-xs font-bold text-white bg-indigo-600 shadow-sm">Ana Sayfa</a>
            <a href="/users" class="px-4 py-2 rounded-full text-xs font-semibold text-[#373634] hover:text-indigo-600 transition">Mezunlar</a>
            <a href="/job-postings" class="px-4 py-2 rounded-full text-xs font-semibold text-[#373634] hover:text-indigo-600 transition">İş İlanları</a>
            <a href="/announcements" class="px-4 py-2 rounded-full text-xs font-semibold text-[#373634] hover:text-indigo-600 transition">Duyurular</a>
        </nav>

        <!-- CTA Capsule Button -->
        <a href="/admin" class="px-5 py-2.5 rounded-full text-xs font-bold text-white bg-[#121218] hover:bg-indigo-600 transition">
            Yönetim Paneli &rarr;
        </a>
    </div>
</header>
```

### 6.2 Hero Section with Sticker Shouts
* **Background:** Deep slate/navy field (`#0F172A`) or full-bleed cream canvas with floating sticker shouts.
* **Title:** Large literary serif typography with high-contrast leading.
* **Decal Shout:** Rotated `-4°` pill badge (`"✨ 2026 Mezun Zirvesi Kayıtları Açıldı"`).

### 6.3 Job Posting Card with Transparent Salary Pill
```html
<div class="bg-white rounded-2xl border border-[#E5DFD5] p-6 flex flex-col justify-between hover:border-indigo-400 transition-all duration-200">
    <div>
        <!-- Badges Header -->
        <div class="flex items-center justify-between gap-2 mb-3">
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                ● Uzaktan / Remote
            </span>
            <span class="font-mono text-xs text-[#6B6A68]">2 gün önce</span>
        </div>
        <h3 class="text-xl font-bold text-[#121218] hover:text-indigo-600 transition mb-1">
            Senior Backend Engineer (PHP / Laravel)
        </h3>
        <p class="text-sm font-semibold text-[#373634] mb-4">🏢 Trendyol Tech &bull; 📍 İstanbul</p>
    </div>

    <!-- Salary Pill & Action -->
    <div class="pt-4 border-t border-[#E5DFD5]/60 flex items-center justify-between">
        <div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#6B6A68] block">Şeffaf Maaş</span>
            <span class="font-mono text-base font-extrabold text-emerald-600">₺85.000 <span class="text-xs text-[#6B6A68] font-sans">/ ay</span></span>
        </div>
        <a href="/job-postings/1" class="px-4 py-2 rounded-full text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition">
            Hemen Başvur &rarr;
        </a>
    </div>
</div>
```

---

## 7. ⚙️ Tailwind CSS Configuration (`tailwind.config.js`)

To easily adopt this design architecture across all Laravel Blade views, configure `tailwind.config.js` with the tokens below:

```javascript
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        canvas: {
          cream: '#FBF8F3', // Warm paper canvas
          stone: '#F2EFE9', // Inset panels & sub-surfaces
          hairline: '#E5DFD5', // Clean architectural borders
        },
        ink: {
          black: '#121218', // Primary display text & borders
          body: '#373634',  // Warm readable body text
          muted: '#6B6A68', // Helper text & timestamps
        },
        academic: {
          navy: '#0F172A',  // Deep authoritative header surfaces
          forest: '#064C37',// Fable-inspired botanical band
          indigo: '#4F46E5',// Primary CTA interactive ink
        },
        sticker: {
          emerald: '#10B981',// Remote / verified
          amber: '#F59E0B',  // Hybrid / warning
          sky: '#3B82F6',    // In-Office / info
          coral: '#FD4B38',  // Urgent / 404/5xx alerts
          violet: '#8A53FF', // Mentorship / summit
        }
      },
      fontFamily: {
        serif: ['Fraunces', 'Lora', 'Playfair Display', 'serif'],
        sans: ['Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif'],
        mono: ['JetBrains Mono', 'Martian Mono', 'monospace'],
      },
      boxShadow: {
        'ring-yellow': '0 0 0 2px #FFD80C',
        'ring-indigo': '0 0 0 2px #4F46E5',
      },
      borderRadius: {
        'card': '20px',
        'capsule': '9999px',
      }
    },
  },
  plugins: [],
}
```

---

## 8. 🛠️ Developer Implementation Guide

When developing new pages, Blade components, or admin screens in the Alumni Tracking System, adhere to this checklist:

1. **Avoid `#FFFFFF` as the main page canvas:** Always use `bg-canvas-cream` (`#FBF8F3`) for public web views. Reserve pure white `#FFFFFF` for lifted cards and input boxes.
2. **Mandatory Salary & Workplace Transparency:** Never display a job card without its workplace sticker badge (`Remote`, `Hybrid`, `In-Office`) and transparent numeric salary (`₺XX.XXX / ay`).
3. **Use Hairline Inset Borders:** Use `border border-canvas-hairline` (`#E5DFD5`) rather than applying heavy box-shadows.
4. **Capsule Radius on CTAs:** All primary action buttons should use `rounded-full` with an explicit arrow indicator (`&rarr;`).
5. **Guardian Error Formatting:** All error views and JSON payloads must continue to be routed through `Guardian404Middleware` and `Guardian5xxMiddleware` preserving the human-readable `reason` and `reference_id`.

---

## 9. 🔗 Reference Links & Provenance

This design specification is directly linked to the following live Refero Design references:

| Style Reference | Theme & Description | Refero URL |
| :--- | :--- | :--- |
| **Fictional** | Sticker-bombed tabletop, cream blush canvas, saturated decal blocks | [`styles.refero.design/style/af2e0bc4-ef1c-4365-a25d-00b691218431`](https://styles.refero.design/style/af2e0bc4-ef1c-4365-a25d-00b691218431) |
| **Family** | Storybook spread on cream parchment, hairline borders, primary markers | [`styles.refero.design/style/1bcae895-2245-4d33-aa43-1c1e80719554`](https://styles.refero.design/style/1bcae895-2245-4d33-aa43-1c1e80719554) |
| **Fable** | Literary reading nook, editorial serif headlines, botanical color bands | [`styles.refero.design/style/ab650279-aa18-43e5-a998-34190d7bedc7`](https://styles.refero.design/style/ab650279-aa18-43e5-a998-34190d7bedc7) |
| **SuperHi** | Art-room paper-cuts, chalk blue canvas, chunky capsule buttons | [`styles.refero.design/style/90b8631c-4e2c-407e-86a3-d2bff456dc93`](https://styles.refero.design/style/90b8631c-4e2c-407e-86a3-d2bff456dc93) |
| **TOMO** | Analog zine taped to a fridge, zero elevation, marquee ribbons | [`styles.refero.design/style/6f148ff6-ae72-496a-a21d-84d7779825ff`](https://styles.refero.design/style/6f148ff6-ae72-496a-a21d-84d7779825ff) |
| **MindMarket** | Warm cream storybook, compressed grotesque type, fresh grass accent | [`styles.refero.design/style/9130ad37-bf80-458f-b808-ac0ef6a8d1e9`](https://styles.refero.design/style/9130ad37-bf80-458f-b808-ac0ef6a8d1e9) |
