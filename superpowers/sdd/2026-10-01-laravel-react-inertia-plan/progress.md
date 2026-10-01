# SDD ledger — plan: docs/superpowers/plans/2026-10-01-laravel-react-inertia-plan.md

## Environment ruling

Ruling: Work in the approved project directory because `/var/www/html/our-server` is not a Git repository and no isolated worktree can be created — the user explicitly approved this project root; the cost is that task changes cannot be isolated or committed by Git.

## Preflight scan

| Scope | What was checked | Finding / ruling |
|---|---|---|
| Task 1 ↔ Task 2 | Laravel skeleton feeds migrations/models | Compatible; Task 1 creates the app, Task 2 adds schema. |
| Task 1 ↔ Task 3 | Starter Vite/Inertia entrypoint feeds React page | Compatible; Task 3 modifies the starter entrypoint. |
| Task 1 ↔ Task 6 | Laravel root/public path feeds Nginx | Compatible; all paths use `/var/www/html/our-server` and `/var/www/html/our-server/public`. |
| Task 2 ↔ Task 3 | `SiteSetting` props feed `Home.tsx` | Compatible; typed homepage fields are the shared interface. |
| Task 2 ↔ Task 4 | `ContactMessage` model feeds contact controller | Compatible; status defaults to `new`. |
| Task 3 ↔ Task 4 | `MissionPanel` may receive contact form | Compatible; Task 4 may extract a dedicated `ContactForm.tsx`. |
| Task 3 ↔ Task 5 | React public assets and static Minecraft assets share `public/assets` | Compatible; preserve root-relative URLs. |
| Task 5 ↔ Task 6 | Static `/minecraft/` must survive Nginx root switch | Compatible; static directory is under Laravel `public`. |
| Task 1 | Its files, tests, and interfaces agree | Compatible; scaffolding precedes all application code. |
| Task 2 | Its files, tests, and interfaces agree | Compatible; migrations/models/seeds are tested together. |
| Task 3 | Its files, tests, and interfaces agree | Compatible; controller, page components, route, and build are grouped. |
| Task 4 | Its files, tests, and interfaces agree | Compatible; request/controller/form/tests share the named contract. |
| Task 5 | Its files, tests, and interfaces agree | Compatible; static copy and HTTP checks share the same paths. |
| Task 6 | Its files, tests, and interfaces agree | Compatible; rollback precedes Nginx mutation. |

## Rulings

Ruling: Use the existing `superpowers/specs` and `docs/superpowers/plans` artifacts in this non-Git tree — the current folder already contains the approved spec under `superpowers/specs`, while the user specifically requested the application itself remain at this folder root.

Task 1: Ruling: Use Laravel 12 for the application scaffold — the official `laravel/react-starter-kit` package available from Composer requires Laravel `^12.0`, while the initial Laravel 13 scaffold cannot resolve that package; the cost is using the previous Laravel major while retaining the approved React/Inertia architecture.

## Task status

Task 1: complete (no Git commit; tests: `php artisan test --compact --colors=never` → 27 passed, 64 assertions; build: `npm run build` → `public/build/manifest.json` present)
Task 2: complete (no Git commit; tests: `php artisan test --filter=SiteContentTest` → 2 passed, 4 assertions; MariaDB connectivity: `our-server-user` → `our-server`, 1 seeded settings row)
Task 3: complete (no Git commit; tests: `php artisan test --filter=HomePageTest` → 1 passed, 14 assertions; build: `npm run build` → `public/build/manifest.json` present)
Task 4: complete (no Git commit; contact success status is rendered through Inertia; focused contact/home tests: 5 passed, 35 assertions; build manifest present)
Task 5: complete (no Git commit; static copy matches `/var/www/html/minecraft/index.html`; local public-root checks for `/minecraft/` and `/assets/our-server-hero.png` passed)
Task 6: complete (no Git commit; Nginx root switched to `/var/www/html/our-server/public` with rollback backup; PHP-FPM active; `nginx -t` passed; full suite: 34 passed, 103 assertions; production build passed; live `/`, `/minecraft/`, asset, and source-protection checks passed)

## Final review

Self-review completed after implementation because the earlier subagent review attempts were unresponsive and the user approved native execution. Verified the full test suite, production Vite build, cached configuration, Nginx syntax, live homepage, static Minecraft subpage, asset delivery, and blocked access to `.env`/source files.
