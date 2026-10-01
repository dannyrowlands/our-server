# Our Server Laravel + React Design

## Status

Approved — 2026-10-01

## Goal

Convert the current static `our-server.uk` / `our-server.co.uk` website into a Laravel application with a React frontend, while preserving the current futuristic aviation homepage and the existing Minecraft site at `/minecraft`.

The application will use MariaDB with:

- Database: `our-server`
- Application database user: `our-server-user`

The first backend scope is intentionally small: editable homepage content/settings and contact-message storage.

## Recommended architecture

Use Laravel as the full-stack application and React through Inertia rather than a separately deployed React SPA and API.

```text
Browser
  ├── /                 Laravel route → Inertia React homepage
  ├── /contact         Laravel validation → contact message record
  └── /minecraft/      Static preserved Minecraft page

Laravel
  ├── routes/web.php
  ├── controllers and form requests
  ├── Eloquent models and migrations
  ├── Inertia page props
  └── Vite-built React/TypeScript frontend

MariaDB
  └── our-server database, owned by our-server-user
```

This keeps routing, validation, sessions, and database access in Laravel while allowing the UI to remain fully React-based. It avoids introducing a separate API authentication and CORS boundary that the current single-site scope does not need.

## Application structure

The Laravel project will live at `/var/www/html/our-server`. Nginx will serve only `/var/www/html/our-server/public`.

Expected application areas:

- `resources/js/Pages/Home.tsx` — current Northstar/futurescape homepage.
- `resources/js/Components/` — reusable hero, telemetry, system cards, mission panel, and contact form components.
- `app/Http/Controllers/` — homepage and contact endpoints.
- `app/Http/Requests/` — contact validation.
- `app/Models/` — homepage settings/content and contact messages.
- `database/migrations/` — schema migrations.
- `public/assets/` — existing futurescape and other homepage assets.
- `public/minecraft/` — preserved static Minecraft page and its asset references.

The current design will be ported into React/TypeScript without intentionally changing its visual direction. The existing `/minecraft` page will not be converted as part of this scope.

## Data model

### `site_settings`

Stores editable singleton-style homepage values, such as:

- site name and tagline
- hero eyebrow, title, and body copy
- telemetry labels and values
- CTA labels and destinations
- footer text

The model will use a stable key/value or typed-column approach rather than embedding content in React source. The initial implementation should prefer typed columns for the small, known homepage surface; this keeps validation and admin editing straightforward.

### `contact_messages`

Stores contact submissions:

- `id`
- `name`
- `email`
- `message`
- `status` (`new`, `read`, or `archived`)
- timestamps

The public form will validate input server-side, apply basic rate limiting, and return a success/error state through Inertia. No public message listing will be exposed.

## Database and credentials

MariaDB will contain a database named `our-server` and a dedicated user named `our-server-user`, granted access only to that database.

The generated password will be stored only in the Laravel `.env` file with restrictive filesystem permissions. It will not be committed, placed under `public/`, or printed in logs. Existing MariaDB system databases will not be modified beyond the required application database/user grants.

## Web server and deployment

Nginx currently serves `/var/www/html` for `our-server.uk` and `our-server.co.uk`. The deployment will:

1. Install the PHP runtime, required Laravel extensions, Composer, and Node/npm tooling if absent.
2. Create or complete the Laravel application under `/var/www/html/our-server`.
3. Configure `.env` for production-style settings and MariaDB.
4. Run migrations and build the React/Vite assets.
5. Copy the existing static Minecraft page to `public/minecraft/` and preserve its asset paths.
6. Update Nginx so the domains point to `/var/www/html/our-server/public` and route requests through Laravel’s `public/index.php`.
7. Reload Nginx and verify both the root site and `/minecraft/`.

The existing `/var/www/html` site will be preserved until the new application is verified, then retired from active serving by the Nginx root change. No Minecraft server files under `/opt/minecraft` will be altered.

## Security and operational requirements

- Nginx must expose only Laravel’s `public` directory.
- `.env`, source code, storage, and Composer files must remain outside the public root.
- Contact input must use CSRF protection, server-side validation, and throttling.
- Storage and cache directories must be writable by the PHP-FPM service user.
- The database user must have application-database privileges only.
- Production errors must not expose stack traces or database credentials.
- Before changing the active Nginx root, preserve a rollback copy of the current Nginx configuration and static site path.

## Verification plan

Before claiming completion, verify:

- PHP, Composer, Node, and PHP-FPM are installed and usable.
- Laravel boots successfully with the configured environment.
- Migrations complete and the application can connect using `our-server-user`.
- The React/Vite production build completes successfully.
- `GET /` renders the Northstar homepage.
- The homepage loads its generated futurescape assets.
- The contact form rejects invalid input and persists valid messages.
- `GET /minecraft/` still serves the original Minecraft page.
- Nginx configuration passes `nginx -t` and reloads successfully.
- Both configured domains return successful HTTP responses from the new public root.

## Out of scope

- User accounts or an administrative dashboard, unless needed to edit content in a follow-up.
- Converting the Minecraft page into React.
- Public JSON API endpoints for third-party clients.
- Email delivery for contact messages; storage comes first and delivery can be added separately.
- Changes to the Minecraft server, plugins, worlds, or game configuration.
