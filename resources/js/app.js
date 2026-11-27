const menuButton = document.querySelector('#mobile-menu-button');
const mobileMenu = document.querySelector('#mobile-menu');

if (menuButton instanceof HTMLButtonElement && mobileMenu instanceof HTMLElement) {
    menuButton.addEventListener('click', () => {
        const isExpanded = menuButton.getAttribute('aria-expanded') === 'true';

        menuButton.setAttribute('aria-expanded', String(!isExpanded));
        mobileMenu.classList.toggle('hidden', isExpanded);
    });

    mobileMenu.addEventListener('click', (event) => {
        if (event.target instanceof HTMLAnchorElement) {
            menuButton.setAttribute('aria-expanded', 'false');
            mobileMenu.classList.add('hidden');
        }
    });
}
