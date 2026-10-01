import { useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';

export function MissionPanel({ status }: { status?: string }) {
    const form = useForm({ name: '', email: '', message: '' });

    function submit(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();
        form.post('/contact', { preserveScroll: true, onSuccess: () => form.reset() });
    }

    return (
        <section className="mission" id="mission">
            <div className="wrap mission-box">
                <div>
                    <p className="eyebrow">Mission control</p>
                    <h2>Make the next move count.</h2>
                    <p>There is always another altitude to reach. Bring your curiosity, your craft, and your appetite for the unknown.</p>
                    <form className="contact-form" onSubmit={submit}>
                        <label>Name<input value={form.data.name} onChange={(event) => form.setData('name', event.target.value)} /></label>
                        {form.errors.name && <small>{form.errors.name}</small>}
                        <label>Email<input type="email" value={form.data.email} onChange={(event) => form.setData('email', event.target.value)} /></label>
                        {form.errors.email && <small>{form.errors.email}</small>}
                        <label>Message<textarea rows={4} value={form.data.message} onChange={(event) => form.setData('message', event.target.value)} /></label>
                        {form.errors.message && <small>{form.errors.message}</small>}
                        <button className="button" type="submit" disabled={form.processing}>Open a channel</button>
                    </form>
                    {status && <p className="form-status" role="status">{status}</p>}
                    <div className="status-strip"><span>Signal <strong>strong</strong></span><span>Route <strong>clear</strong></span></div>
                </div>
                <div className="radar" aria-label="Radar display" />
            </div>
        </section>
    );
}
