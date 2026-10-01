# Task 1 brief — Provision the Laravel + React application skeleton

Read this first — it is the exact task requirements.

## Project context

Work directly in `/var/www/html/our-server`. This directory is not a Git repository. Preserve the approved planning/spec artifacts. Do not modify `/opt/minecraft`.

## Requirements

- Create or complete a Laravel application in the current directory; never create `/var/www/html/our-server/our-server`.
- Use the official Laravel React/Inertia starter path.
- Public root must eventually be `/var/www/html/our-server/public`.
- React/TypeScript must be bundled by Vite and rendered through Inertia.
- Configure `.env`/`.env.example` for MariaDB using database `our-server` and user `our-server-user`; use a generated password only in `.env`.
- Set `APP_URL`, `APP_ENV`, `APP_DEBUG=false`, `DB_CONNECTION=mysql`, `DB_HOST=127.0.0.1`, `DB_DATABASE=our-server`, and `DB_USERNAME=our-server-user`.
- Keep `.env` outside `public/` and use restrictive permissions.

## Steps

1. Inspect/install missing PHP, PHP-FPM, Composer, Node/npm, and Laravel-required extensions.
2. Scaffold the Laravel React/Inertia application in this directory without overwriting the spec/plan artifacts.
3. Configure environment defaults and generate a secure application database password if no password exists yet.
4. Run `php artisan about` and the starter test command; report exact results.

## Report

Write the full implementation report to `superpowers/sdd/2026-10-01-laravel-react-inertia-plan/task-1-report.md`. Return only status, changed paths, one-line test summary, and concerns.
