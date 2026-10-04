# Northwest England Drone Services Website Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Rebrand the public Laravel/Inertia homepage as a broad drone-services lead-generation site for Northwest England while preserving the current homepage in a dated, non-public backup.

**Architecture:** Keep the existing Laravel + Inertia + React homepage and contact endpoint. Replace the current aviation-fiction content with drone-services sections and extend the existing contact payload only where the quote-enquiry fields require it. Archive the pre-change homepage source and related assets under `docs/backups/2026-10-04-current-homepage/`, outside the Nginx document root.

**Tech Stack:** Laravel, PHP, Inertia, React, TypeScript, Vite, CSS, PHPUnit/Pest-compatible Laravel feature tests.

**Spec:** `docs/superpowers/specs/2026-10-04-drone-services-design.md`

## Global Constraints

- Serve customers across Northwest England.
- Do not publish unsupported qualifications, insurance, permissions, testimonials, prices, or completed projects.
- Preserve the current homepage before changing it.
- Keep the backup outside the public web root.
- Do not modify `/opt/minecraft` or restore Minecraft-related public content.
- Preserve rate limiting and server-side validation for enquiries.
- Keep the page responsive, accessible, and mobile usable.

## Review Focus

- Backup restore path: the dated archive must contain enough source and asset information to restore the former homepage.
- Enquiry validation: optional phone/date fields and the service/location/project fields must reject malformed input without persistence.
- Enquiry success: a valid quote request must persist and return the existing success status.
- Public copy safety: no invented credentials, insurance, prices, testimonials, or approvals may appear in rendered homepage content.
- Responsive CTA flow: quote links and form anchors must work from both desktop and mobile layouts.

---

### Task 1: Archive the existing homepage

**Files:**
- Create: `docs/backups/2026-10-04-current-homepage/README.md`
- Create: `docs/backups/2026-10-04-current-homepage/resources/js/pages/Home.tsx`
- Create: `docs/backups/2026-10-04-current-homepage/resources/js/Components/Hero.tsx`
- Create: `docs/backups/2026-10-04-current-homepage/resources/js/Components/SystemCards.tsx`
- Create: `docs/backups/2026-10-04-current-homepage/resources/js/Components/MissionPanel.tsx`
- Create: `docs/backups/2026-10-04-current-homepage/resources/css/app.css`
- Create: `docs/backups/2026-10-04-current-homepage/public/assets/` copies of homepage-specific assets

- [ ] **Step 1: Record the current homepage file map and asset references**

Run `rg` against the current homepage components and stylesheet; record the original source paths in the backup README.

- [ ] **Step 2: Copy the current homepage source and assets into the dated backup**

Keep the files as archival copies; do not add the backup directory to any public route or build entrypoint.

- [ ] **Step 3: Verify the backup is complete**

Run a comparison between each archived source file and its original, and confirm the backup path is not under `public/`.

### Task 2: Update the business content contract and seed data

**Files:**
- Modify: `database/seeders/DatabaseSeeder.php`
- Modify: `resources/js/types/site-settings.ts`
- Test: `tests/Feature/HomePageTest.php`

**Interfaces:**
- Produces the existing `SiteSettings` props with drone-service copy, CTA labels, and service-area metadata where needed.

- [ ] **Step 1: Write failing homepage assertions**

Update the feature test to assert the seeded identity and hero communicate drone services and Northwest England, and assert the page has quote CTA/service-area content.

- [ ] **Step 2: Run the focused test and verify it fails**

Run `php artisan test --filter=HomePageTest`; expected failure from the old Northstar assertions.

- [ ] **Step 3: Replace fictional aviation seed content with safe drone-service copy**

Use editable, factual-neutral values such as “Drone services across Northwest England,” “See your project from a better angle,” and “Request a quote.” Remove invented flight telemetry values from the rendered contract or repurpose the existing fields only where they remain semantically appropriate.

- [ ] **Step 4: Update TypeScript settings types**

Add exact types for any new settings used by the page; retain compatibility with the existing database row and controller response.

- [ ] **Step 5: Run the focused test and verify it passes**

Run `php artisan test --filter=HomePageTest`; expected PASS for the updated content assertions.

### Task 3: Build the drone-services homepage sections

**Files:**
- Modify: `resources/js/pages/Home.tsx`
- Modify: `resources/js/Components/Hero.tsx`
- Modify: `resources/js/Components/SystemCards.tsx`
- Modify: `resources/js/Components/MissionPanel.tsx`
- Modify: `resources/css/app.css`
- Test: `tests/Feature/HomePageTest.php`

**Interfaces:**
- Consumes: `SiteSettings` from the existing `HomeController` response.
- Produces: accessible public sections for hero, services, audiences, trust/safety, service area, and quote enquiry.

- [ ] **Step 1: Add failing structural assertions**

Assert the rendered Inertia page/source includes the section IDs and visible labels for services, who-we-help, service-area, and request-quote, and no longer contains “systems nominal” or fictional sector/flight readouts.

- [ ] **Step 2: Run the focused test and verify it fails**

Run `php artisan test --filter=HomePageTest`; expected failure while the old sections remain.

- [ ] **Step 3: Implement the page sections**

Create focused component markup for the agreed service categories and audiences. Use cautious language for inspections and avoid asserting qualifications or regulatory approvals that have not been supplied.

- [ ] **Step 4: Replace the old visual labels and layout rules**

Preserve the dark cinematic style and aerial imagery, remove fictional dashboard telemetry, and add responsive layouts, visible focus states, semantic headings, and mobile-friendly CTA/form spacing.

- [ ] **Step 5: Run focused tests and a production build**

Run `php artisan test --filter=HomePageTest` and `npm run build`; expected PASS and successful Vite output.

### Task 4: Extend quote-enquiry fields safely

**Files:**
- Modify: `app/Http/Requests/StoreContactMessageRequest.php`
- Modify: `app/Http/Controllers/ContactMessageController.php` only if mapping changes are required
- Modify: `app/Models/ContactMessage.php`
- Create: migration adding nullable quote fields if the existing schema lacks them
- Modify: `resources/js/Components/MissionPanel.tsx`
- Test: `tests/Feature/ContactMessageTest.php`

**Interfaces:**
- Consumes: POST `/contact` with name, email, optional phone, service, location, optional preferred date, and message/project details.
- Produces: validated `contact_messages` records with the existing success redirect/status behavior.

- [ ] **Step 1: Write failing validation and persistence tests**

Cover required name/email/service/location/message fields, optional phone/date fields, invalid email/date input, database persistence, and existing throttling.

- [ ] **Step 2: Run the focused tests and verify the new cases fail**

Run `php artisan test --filter=ContactMessageTest`; expected failures for the new fields.

- [ ] **Step 3: Add the smallest schema/model/request changes**

Use nullable columns for optional fields, explicit validation rules, and mass-assignment entries. Keep existing clients that submit only the original fields working unless the homepage contract intentionally makes a field required.

- [ ] **Step 4: Implement the quote form**

Add accessible labels, service selection, location, optional date/phone, project details, validation errors, disabled submit state, and success feedback using the existing Inertia form pattern.

- [ ] **Step 5: Run focused tests**

Run `php artisan test --filter=ContactMessageTest`; expected PASS for validation, persistence, success, and throttling.

### Task 5: Update page-level tests and verify the full application

**Files:**
- Modify: `tests/Feature/HomePageTest.php`
- Modify: `tests/Feature/SiteContentTest.php` if seeded content assertions need alignment
- Modify: `tests/Feature/ContactMessageTest.php` if shared payload helpers need alignment

- [ ] **Step 1: Remove stale Northstar/contact-form-negative assertions**

Replace tests that encode the former homepage with assertions for the new service content and working enquiry flow.

- [ ] **Step 2: Run the full automated suite**

Run `php artisan test`; expected all tests pass.

- [ ] **Step 3: Run production build and HTTP smoke checks**

Run `npm run build`, `nginx -t`, and local requests for `/` and the quote form flow. Confirm the dated backup is not publicly reachable and that `.env`/source protection remains intact.

- [ ] **Step 4: Review the rendered page at desktop and mobile widths**

Check hierarchy, contrast, keyboard focus, CTA visibility, form usability, and that no placeholder claims appear as established facts.

- [ ] **Step 5: Commit the implementation as a focused change**

Stage only the backup, drone homepage, enquiry changes, tests, and related assets. Preserve unrelated pre-existing working-tree changes.
