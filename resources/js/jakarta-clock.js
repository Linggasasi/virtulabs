const jakartaTimeFormatter = new Intl.DateTimeFormat('en-GB', {
    timeZone: 'Asia/Jakarta',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hourCycle: 'h23',
});

export function initializeJakartaClocks() {
    document.querySelectorAll('[data-jakarta-clock]').forEach((clock) => {
        if (!(clock instanceof HTMLElement) || clock.dataset.clockInitialized === 'true') {
            return;
        }

        const time = clock.querySelector('[data-jakarta-time]');

        if (!(time instanceof HTMLTimeElement)) {
            return;
        }

        clock.dataset.clockInitialized = 'true';

        const update = () => {
            const now = new Date();

            time.dateTime = now.toISOString();
            time.textContent = jakartaTimeFormatter.format(now);
        };

        update();
        window.setInterval(update, 1000);
    });
}
