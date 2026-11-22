const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/**
 * Menu mobile: tombol buka/tutup panel navigasi.
 */
function initMobileMenu() {
    const toggle = document.querySelector('[data-menu-toggle]');
    const panel = document.querySelector('[data-menu-panel]');

    if (!toggle || !panel) {
        return;
    }

    const setOpen = (open) => {
        toggle.setAttribute('aria-expanded', String(open));
        panel.classList.toggle('hidden', !open);
        toggle.querySelector('[data-menu-icon-open]')?.classList.toggle('hidden', open);
        toggle.querySelector('[data-menu-icon-close]')?.classList.toggle('hidden', !open);
        toggle.querySelector('.sr-only').textContent = open ? 'Tutup menu' : 'Buka menu';
    };

    toggle.addEventListener('click', () => setOpen(toggle.getAttribute('aria-expanded') !== 'true'));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            setOpen(false);
            toggle.focus();
        }
    });

    window.matchMedia('(min-width: 1024px)').addEventListener('change', (event) => {
        if (event.matches) {
            setOpen(false);
        }
    });
}

/**
 * Slider beranda: scroll-snap native + tombol, titik, dan putar otomatis.
 */
function initSliders() {
    document.querySelectorAll('[data-slider]').forEach((slider) => {
        const track = slider.querySelector('[data-slider-track]');
        const slides = Array.from(track.children);
        const dots = Array.from(slider.querySelectorAll('[data-slider-dot]'));
        let current = 0;
        let timer = null;

        if (slides.length < 2) {
            return;
        }

        const goTo = (index) => {
            current = (index + slides.length) % slides.length;
            track.scrollTo({ left: slides[current].offsetLeft, behavior: reducedMotion ? 'auto' : 'smooth' });
        };

        const markActive = (index) => {
            current = index;
            dots.forEach((dot, dotIndex) => {
                dot.setAttribute('aria-current', dotIndex === index ? 'true' : 'false');
            });
            slides.forEach((slide, slideIndex) => {
                slide.toggleAttribute('inert', slideIndex !== index);
            });
        };

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        markActive(slides.indexOf(entry.target));
                    }
                });
            },
            { root: track, threshold: 0.6 },
        );
        slides.forEach((slide) => observer.observe(slide));

        const stop = () => {
            window.clearInterval(timer);
            timer = null;
        };
        const start = () => {
            if (reducedMotion || timer) {
                return;
            }
            timer = window.setInterval(() => goTo(current + 1), 6000);
        };

        slider.querySelector('[data-slider-prev]')?.addEventListener('click', () => {
            stop();
            goTo(current - 1);
        });
        slider.querySelector('[data-slider-next]')?.addEventListener('click', () => {
            stop();
            goTo(current + 1);
        });
        dots.forEach((dot, index) =>
            dot.addEventListener('click', () => {
                stop();
                goTo(index);
            }),
        );

        slider.addEventListener('mouseenter', stop);
        slider.addEventListener('mouseleave', start);
        slider.addEventListener('focusin', stop);
        markActive(0);
        start();
    });
}

/**
 * Lightbox galeri memakai <dialog> native.
 */
function initLightbox() {
    const dialog = document.querySelector('[data-lightbox]');
    const triggers = Array.from(document.querySelectorAll('[data-lightbox-item]'));

    if (!dialog || triggers.length === 0) {
        return;
    }

    const image = dialog.querySelector('[data-lightbox-image]');
    const video = dialog.querySelector('[data-lightbox-video]');
    const caption = dialog.querySelector('[data-lightbox-caption]');
    const counter = dialog.querySelector('[data-lightbox-counter]');
    let current = 0;

    const stopVideo = () => {
        if (!video) {
            return;
        }
        video.pause();
        video.removeAttribute('src');
        video.load();
    };

    const show = (index) => {
        current = (index + triggers.length) % triggers.length;
        const trigger = triggers[current];
        const href = trigger.getAttribute('href');
        const isVideo = trigger.dataset.mediaType === 'video';

        if (isVideo && video) {
            image.classList.add('hidden');
            video.classList.remove('hidden');
            video.src = href;
            video.load();
            video.play().catch(() => {});
        } else {
            stopVideo();
            video?.classList.add('hidden');
            image.classList.remove('hidden');
            image.src = href;
            image.alt = trigger.dataset.caption || trigger.querySelector('img')?.alt || '';
        }

        caption.textContent = trigger.dataset.caption || '';
        counter.textContent = `${current + 1} / ${triggers.length}`;
    };

    triggers.forEach((trigger, index) =>
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            show(index);
            dialog.showModal();
        }),
    );

    dialog.querySelector('[data-lightbox-prev]').addEventListener('click', () => show(current - 1));
    dialog.querySelector('[data-lightbox-next]').addEventListener('click', () => show(current + 1));
    dialog.querySelector('[data-lightbox-close]').addEventListener('click', () => dialog.close());
    dialog.addEventListener('close', stopVideo);
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });
    dialog.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
            show(current - 1);
        }
        if (event.key === 'ArrowRight') {
            show(current + 1);
        }
    });
}

initMobileMenu();
initSliders();
initLightbox();
