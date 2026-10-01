# Our Server Laravel React Inertia Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Convert the static Northstar homepage into a Laravel + React + Inertia application with MariaDB-backed homepage content and contact-message storage, while preserving `/minecraft/`.

**Architecture:** Laravel lives at `/var/www/html/our-server`; its `public/` directory is the only Nginx-exposed path. Laravel handles routes, validation, sessions, migrations, and Eloquent models; React/TypeScript pages are rendered through Inertia and bundled with Vite. The existing Minecraft page is copied into `public/minecraft/` and remains static.

**Tech Stack:** Laravel, PHP-FPM, Composer, MariaDB, React, TypeScript, Inertia, Vite, Nginx, PHPUnit/Pest as provided by the Laravel skeleton.

**Spec:** `superpowers/specs/2026-10-01-laravel-react-inertia-design.md`

## Global Constraints

- Project root: `/var/www/html/our-server`.
- Public web root: `/var/www/html/our-server/public`.
- Database: `our-server`.
- Database user: `our-server-user`.
- Preserve the current futuristic aviation homepage visual direction.
- Preserve the existing Minecraft site at `/minecraft/`; do not convert it to React.
- Keep `.env`, source code, storage, and Composer files outside the public root.
- Do not modify Minecraft server files under `/opt/minecraft`.
- Store generated database credentials only in `.env` with restrictive permissions.

## Review Focus

- Nginx must not expose Laravel source or `.env`; Task 6 tests the public-root configuration.
- The hyphenated database/user names must connect successfully; Task 2 tests migrations using the application credentials.
- Invalid contact input must not create records; Task 4 tests validation and persistence.
- Existing `/minecraft/` behavior must survive the document-root switch; Task 5 tests the copied page and assets.
- The generated hero asset must load through the compiled React page; Task 3 and Task 6 test the asset path and rendered response.

### Task 1: Provision the Laravel + React application skeleton

**Files:**
- Create/modify: Laravel skeleton files under `/var/www/html/our-server/`.
- Create: `.env` and `.env.example` entries for MariaDB and Inertia/Vite.
- Create: `package.json`, `vite.config.*`, `resources/js/app.*` as supplied by the selected Laravel React starter kit.
- Test: Laravel boot smoke test under the starter kit’s default test structure.

**Interfaces:**
- Produces a bootable Laravel application at `/var/www/html/our-server` with a Vite React/Inertia entrypoint.

- [ ] **Step 1: Confirm runtime prerequisites**

  Run `php -v`, `php -m`, `php-fpm8.3 -v` or the installed PHP-FPM equivalent, `composer --version`, `node --version`, and `npm --version`. Install only missing Laravel-required packages and extensions.

- [ ] **Step 2: Create the Laravel application in the existing project root**

  Use the official Laravel React/Inertia starter path without creating a nested `/var/www/html/our-server/our-server` directory. If the directory contains only planning/spec artifacts, scaffold into the current directory; preserve those artifacts.

- [ ] **Step 3: Configure environment defaults**

  Set `APP_URL`, `APP_ENV`, `APP_DEBUG=false`, `DB_CONNECTION=mysql`, `DB_HOST=127.0.0.1`, `DB_DATABASE=our-server`, `DB_USERNAME=our-server-user`, and the generated `DB_PASSWORD`. Keep `.env` outside `public/` and chmod it restrictively.

- [ ] **Step 4: Run the framework smoke test**

  Run `php artisan about` and the starter test command. Expected: Laravel reports its environment and the default suite passes.

### Task 2: Create the database and application schema

**Files:**
- Create: `database/migrations/*_create_site_settings_table.php`.
- Create: `database/migrations/*_create_contact_messages_table.php`.
- Create: `app/Models/SiteSetting.php`.
- Create: `app/Models/ContactMessage.php`.
- Create: `database/seeders/DatabaseSeeder.php` updates for initial homepage values.
- Test: feature/database tests for migrations, seed data, and model persistence.

**Interfaces:**
- `SiteSetting` exposes the typed homepage fields defined by the spec.
- `ContactMessage` exposes `name`, `email`, `message`, and `status` with `status` defaulting to `new`.

- [ ] **Step 1: Write failing migration/model tests**

  Add tests that run against the configured test database and assert both tables exist, the seeded homepage has the Northstar copy, and a contact message can be persisted with the default `new` status.

- [ ] **Step 2: Run the focused tests and verify they fail**

  Run `php artisan test --filter='SiteSetting|ContactMessage'`. Expected: missing-table/model failures.

- [ ] **Step 3: Implement migrations, models, casts, and seed data**

  Use typed columns for the small known homepage surface; add timestamps and indexes appropriate to contact lookup/status. Do not seed secrets or production contact data.

- [ ] **Step 4: Create MariaDB credentials and run migrations**

  Create database `our-server`, create user `our-server-user` with a generated password, grant privileges only on `our-server`, then run `php artisan migrate --seed` using the application `.env` credentials.

- [ ] **Step 5: Run focused and full tests**

  Run `php artisan test --filter='SiteSetting|ContactMessage'` and then `php artisan test`. Expected: all tests pass.

### Task 3: Port the homepage to React/Inertia

**Files:**
- Create: `app/Http/Controllers/HomeController.php`.
- Create: `resources/js/Pages/Home.tsx`.
- Create: `resources/js/Components/Hero.tsx`.
- Create: `resources/js/Components/FlightData.tsx`.
- Create: `resources/js/Components/SystemCards.tsx`.
- Create: `resources/js/Components/MissionPanel.tsx`.
- Create/modify: `resources/css/app.css` and Vite entry files.
- Copy: `public/assets/futurescape-arrival.png`, `public/assets/futurescape-hero.png`, and required existing homepage assets.
- Modify: `routes/web.php`.
- Test: feature test for `GET /` and frontend build verification.

**Interfaces:**
- `HomeController::__invoke(): \Inertia\Response` renders `Home` with validated `siteSettings` props.
- `Home.tsx` consumes typed `siteSettings` props and renders the current visual structure.

- [ ] **Step 1: Write a failing homepage feature test**

  Assert `GET /` returns 200, uses the Inertia `Home` page, and includes the seeded Northstar title/hero values.

- [ ] **Step 2: Run the test and verify it fails**

  Run `php artisan test --filter=homepage`. Expected: route/controller/page does not exist.

- [ ] **Step 3: Implement the controller, route, and React components**

  Port the current homepage’s responsive layout and futurescape asset references into React/TypeScript. Keep the 15px header gutter, left-aligned hero panel, contained heading, fixed desktop background behavior, and mobile fallback.

- [ ] **Step 4: Run the homepage feature test and Vite build**

  Run `php artisan test --filter=homepage` and `npm run build`. Expected: feature test passes and Vite emits production assets under `public/build`.

### Task 4: Add the contact form and persistence flow

**Files:**
- Create: `app/Http/Controllers/ContactMessageController.php`.
- Create: `app/Http/Requests/StoreContactMessageRequest.php`.
- Modify: `resources/js/Components/MissionPanel.tsx` or a dedicated `ContactForm.tsx`.
- Modify: `routes/web.php`.
- Test: feature tests for valid submission, invalid submission, CSRF, throttling, and database persistence.

**Interfaces:**
- `StoreContactMessageRequest` validates `name`, `email`, and `message`.
- `ContactMessageController::store(StoreContactMessageRequest $request): \Illuminate\Http\RedirectResponse` creates a `ContactMessage` and redirects back with a flash status.

- [ ] **Step 1: Write failing request/feature tests**

  Assert invalid email/empty message returns validation errors and creates no row; valid input creates one `new` row; repeated submissions are throttled.

- [ ] **Step 2: Run the focused tests and verify they fail**

  Run `php artisan test --filter=contact`. Expected: missing route/controller/validation failures.

- [ ] **Step 3: Implement validation, throttling, controller, and React form state**

  Use Laravel CSRF protection and a route-level throttle. Show success and field-level errors through Inertia without exposing stored messages publicly.

- [ ] **Step 4: Run focused and full tests**

  Run `php artisan test --filter=contact` and `php artisan test`. Expected: all pass.

### Task 5: Preserve the Minecraft subpage

**Files:**
- Create: `public/minecraft/index.html` from the currently served Minecraft page.
- Copy: required Minecraft assets into `public/assets/`.
- Test: HTTP smoke checks for `/minecraft/` and the hero asset.

**Interfaces:**
- `GET /minecraft/` remains a static file request and does not enter the Laravel route fallback.

- [ ] **Step 1: Capture the current static page and asset checks**

  Verify the source page contains its existing Minecraft copy and that `/assets/our-server-hero.png` is served before switching Nginx.

- [ ] **Step 2: Copy the page and assets into Laravel’s public tree**

  Preserve root-relative asset URLs and page content exactly unless a path must change for the new public root.

- [ ] **Step 3: Run static subpage checks**

  Request `/minecraft/` and `/assets/our-server-hero.png` from a temporary local Laravel/Nginx target. Expected: 200 responses and unchanged Minecraft content.

### Task 6: Configure Nginx, PHP-FPM, permissions, and production verification

**Files:**
- Create/modify: the active Nginx site configuration for `our-server.uk` and `our-server.co.uk`.
- Create: a rollback copy of the current Nginx configuration and `/var/www/html` site reference.
- Modify: Laravel storage/cache permissions and production `.env` values.
- Test: Nginx config, HTTP routes, asset loading, database connectivity, and log checks.

**Interfaces:**
- Domains serve `/var/www/html/our-server/public`.
- PHP requests are passed to the installed PHP-FPM socket.
- Unknown application routes use Laravel’s `public/index.php`; `/minecraft/` remains static.

- [ ] **Step 1: Write down the current Nginx configuration and create rollback copies**

  Capture the active server block and preserve the current static root before changing it. Do not delete the old site.

- [ ] **Step 2: Configure the Laravel public root and PHP-FPM handler**

  Set `root /var/www/html/our-server/public`, `index index.php`, the Laravel `try_files` fallback, and the PHP-FPM `fastcgi_pass` socket. Add the existing domains to the server block.

- [ ] **Step 3: Set permissions and production caches**

  Ensure the PHP-FPM service user can write `storage/` and `bootstrap/cache/`; run `php artisan config:cache`, `route:cache`, and `view:cache` only after environment values are correct.

- [ ] **Step 4: Validate and reload Nginx**

  Run `nginx -t`, then reload Nginx. Expected: syntax test succeeds and the reload exits successfully.

- [ ] **Step 5: Run end-to-end verification**

  Request both configured domains over HTTP, `/`, `/minecraft/`, the generated hero asset, and the contact form flow. Confirm no `.env` or source files are publicly reachable and inspect Nginx/PHP-FPM logs for errors.

## Self-review

- Spec coverage: every spec section maps to Tasks 1–6; the corrected project root is used consistently.
- Step scan: each task separates failing test, implementation, and verification; deployment operations have explicit pre-change rollback steps.
- Type consistency: controller and request names are used consistently in routes, tests, and interfaces.
- Review focus: all five high-risk inputs are assigned to Tasks 2–6.
- Proportion: the plan stays at task/interface/test level and does not prescribe implementation bodies unnecessarily.
