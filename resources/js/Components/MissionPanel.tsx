export function MissionPanel() {
    return (
        <section className="mission" id="mission">
            <div className="wrap mission-box">
                <div>
                    <p className="eyebrow">Mission control</p>
                    <h2>Make the next move count.</h2>
                    <p>There is always another altitude to reach. Bring your curiosity, your craft, and your appetite for the unknown.</p>
                    <div className="status-strip">
                        <span>
                            Signal <strong>strong</strong>
                        </span>
                        <span>
                            Route <strong>clear</strong>
                        </span>
                    </div>
                </div>
                <div className="radar" aria-label="Radar display" />
            </div>
        </section>
    );
}
