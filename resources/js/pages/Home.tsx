import { Head } from '@inertiajs/react';
import { Hero } from '../Components/Hero';
import { MissionPanel } from '../Components/MissionPanel';
import { SystemCards } from '../Components/SystemCards';
import type { SiteSettings } from '../types/site-settings';

export default function Home({ siteSettings }: { siteSettings: SiteSettings }) {
    return (
        <>
            <Head title={siteSettings.site_name} />
            <header>
                <div className="wrap">
                    <nav aria-label="Main navigation">
                        <a className="brand" href="/" aria-label={`${siteSettings.site_name} home`}>
                            <span className="brand-mark">✦</span> {siteSettings.site_name}
                        </a>
                        <div className="nav-meta">
                            <span className="signal">systems nominal</span>
                            <span>Sector 07 · UTC 04:18</span>
                        </div>
                    </nav>
                </div>
            </header>
            <main>
                <Hero settings={siteSettings} />
                <SystemCards />
                <MissionPanel />
            </main>
            <footer>
                <div className="wrap">{siteSettings.footer_text}</div>
            </footer>
        </>
    );
}
