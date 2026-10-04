# Northwest England Drone Services Website

## Goal

Reposition the existing Laravel/Inertia website as a professional drone-services business serving customers across Northwest England, while preserving the current homepage in a clearly labelled backup before any homepage changes are made.

## Audience and positioning

The website should serve a broad customer base without sounding vague:

- Homeowners and property sellers
- Estate agents and property professionals
- Builders, roofers, developers, and construction teams
- Businesses needing promotional aerial imagery
- Farmers, landowners, and rural businesses
- Event organisers and private clients

Primary positioning:

> Professional drone photography, video and inspection services across Northwest England.

The site should avoid making unsupported claims about regulated surveying, mapping, permissions, or qualifications. Those can be added only when the business details are confirmed.

## Homepage experience

The homepage should be a lead-generation landing page with the following sections:

1. **Hero** — A confident aerial-services headline, concise supporting copy, service-area statement, and prominent “Request a quote” call to action.
2. **Services** — A practical service grid covering property imagery, roof/building inspections, construction progress, land and rural work, commercial/promotional video, and events.
3. **Who we help** — Short audience-focused explanations for homeowners, agents, builders, businesses, farmers, and event organisers.
4. **Why use us** — Trust-oriented content for safety, professionalism, image quality, clear communication, weather-aware scheduling, insurance, and qualifications. Only confirmed credentials should be stated as facts.
5. **Service area** — Northwest England, with examples such as Greater Manchester, Merseyside, Lancashire, Cheshire, and Cumbria. The copy should invite customers to enquire if they are nearby.
6. **Enquiry form** — Collect name, email, phone (optional), service type, location, preferred date (optional), and project details. Submission should use the existing contact flow and remain rate-limited and validated.
7. **Footer** — Business identity, service area, contact details when supplied, and appropriate privacy/legal links.

## Visual direction

Preserve the existing dark, cinematic, technical visual language and aerial imagery, but remove fictional or irrelevant system language such as “systems nominal,” sector readouts, and invented flight telemetry. Replace it with real business information and service-led labels.

The page must remain responsive, accessible, fast-loading, and usable on mobile. Calls to action should be visually obvious without making the page feel aggressive or generic.

## Content and business-data assumptions

Until the owner supplies final business details, use clearly editable placeholder content for:

- Business name
- Phone number and email address
- Pilot name and credentials
- Insurance wording
- Exact service radius and travel fees
- Portfolio imagery and case studies

Do not publish invented qualifications, insurance coverage, approvals, prices, customer testimonials, or completed projects.

## Backup requirement

Before changing the homepage, create a dated backup under:

`docs/backups/2026-10-04-current-homepage/`

The backup should contain the current homepage source and the directly related homepage assets/content needed to restore the previous presentation, with a README describing the original file locations and restoration notes. The backup is archival and must not be served publicly by Nginx.

## Technical approach

- Continue using the existing Laravel + Inertia + React + TypeScript stack.
- Reuse the existing `SiteSetting` model for editable identity, hero, CTA, and footer values where practical.
- Keep the existing contact endpoint as the enquiry transport unless a new field requires a focused schema/validation change.
- Keep the authenticated dashboard separate from the public marketing homepage.
- Do not modify `/opt/minecraft` or restore any Minecraft-related public route/content as part of this work.

## Success criteria

- The homepage clearly communicates drone services in Northwest England within a few seconds.
- A visitor can understand the main services and intended customer types.
- A visitor can submit a useful quote enquiry from a phone or desktop.
- The current homepage can be restored from the dated backup.
- No unsupported business claims are presented as facts.
- Existing automated tests, production build, and live HTTP checks continue to pass.
