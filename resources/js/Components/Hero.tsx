import type { SiteSettings } from '../types/site-settings';

export function Hero({ settings }: { settings: SiteSettings }) {
    return (
        <section className="hero">
            <div className="wrap hero-content">
                <p className="eyebrow">{settings.hero_eyebrow}</p>
                <h1>{settings.hero_title}</h1>
                <p className="hero-copy">{settings.hero_copy}</p>
                <div className="actions">
                    <a className="button" href={settings.primary_cta_url}>{settings.primary_cta_label}</a>
                    <a className="text-link" href={settings.secondary_cta_anchor}>{settings.secondary_cta_label}</a>
                </div>
            </div>
            <aside className="flight-data" aria-label="Flight data">
                <div>{settings.altitude_label}<strong>{settings.altitude_value}</strong></div>
                <div>{settings.velocity_label}<strong className="accent">{settings.velocity_value}</strong></div>
                <div>{settings.heading_label}<strong>{settings.heading_value}</strong></div>
            </aside>
        </section>
    );
}
