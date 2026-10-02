import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const renderIcons = () => window.lucide?.createIcons?.();
    renderIcons();
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const updateTheme = (isDark) => {
            document.documentElement.classList.toggle('dark', isDark);
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            button.setAttribute('aria-label', isDark ? 'Gunakan tema terang' : 'Gunakan tema gelap');
            button.setAttribute('title', isDark ? 'Gunakan tema terang' : 'Gunakan tema gelap');

            button.innerHTML = `<i data-lucide="${isDark ? 'sun' : 'moon'}" class="h-4 w-4"></i>`;
            document.querySelectorAll('[data-theme-toggle]').forEach((themeButton) => {
                if (themeButton === button) return;

                themeButton.setAttribute('aria-label', isDark ? 'Gunakan tema terang' : 'Gunakan tema gelap');
                themeButton.setAttribute('title', isDark ? 'Gunakan tema terang' : 'Gunakan tema gelap');
                themeButton.innerHTML = button.innerHTML;
            });
            renderIcons();
        };

        updateTheme(document.documentElement.classList.contains('dark'));
        button.addEventListener('click', () => {
            updateTheme(!document.documentElement.classList.contains('dark'));
        });
    });
    document.querySelectorAll('[data-menu-toggle]').forEach((button) => {
        button.addEventListener('click', () => document.querySelector(button.dataset.menuToggle)?.classList.toggle('hidden'));
    });
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        const input = document.getElementById(button.dataset.passwordToggle);
        const icon = button.querySelector('[data-password-icon]');

        if (!input) return;

        button.addEventListener('click', () => {
            const isVisible = input.type === 'password';

            input.type = isVisible ? 'text' : 'password';
            button.setAttribute('aria-pressed', String(isVisible));
            button.setAttribute('aria-label', isVisible ? 'Sembunyikan password' : 'Tampilkan password');

            if (icon) {
                icon.setAttribute('data-lucide', isVisible ? 'eye-off' : 'eye');
                renderIcons();
            }
        });
    });
    document.querySelectorAll('[data-image-uploader]').forEach((uploader) => {
        uploader.querySelectorAll('[data-image-slot]').forEach((slot, index) => {
            const input = slot.querySelector('.product-image-input');
            const preview = slot.querySelector('[data-image-preview]');
            const removeButton = slot.querySelector('[data-image-remove]');

            if (!input || !preview || !removeButton) return;

            const existingImage = preview.querySelector('[data-existing-image]');
            const existingImageUrl = existingImage?.getAttribute('src');
            let existingRemoved = false;
            let hasNewImage = false;

            const showPlaceholder = () => {
                preview.innerHTML = '<span data-image-placeholder class="product-image-placeholder"><span class="product-image-plus">+</span><span>Tambah foto</span></span>';
            };

            const showExistingImage = () => {
                preview.innerHTML = `<img src="${existingImageUrl}" data-existing-image="true" alt="Foto ${index + 1}">`;
            };

            input.addEventListener('change', () => {
                const [file] = input.files;

                if (!file || !file.type.startsWith('image/')) return;

                const removeInput = slot.querySelector('[data-remove-input]');
                const wasExistingRemoved = Boolean(removeInput);
                removeInput?.remove();
                existingRemoved = existingRemoved || wasExistingRemoved;
                hasNewImage = true;

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    preview.innerHTML = `<img src="${reader.result}" alt="Preview foto ${index + 1}">`;
                    removeButton.classList.remove('hidden');
                });
                reader.readAsDataURL(file);
            });

            removeButton.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                input.value = '';

                if (hasNewImage) {
                    hasNewImage = false;

                    if (existingImageUrl && !existingRemoved) {
                        showExistingImage();
                        return;
                    }
                }

                if (existingImageUrl && !existingRemoved) {
                    const removeInput = document.createElement('input');
                    removeInput.type = 'hidden';
                    removeInput.name = `remove_images[${index}]`;
                    removeInput.value = '1';
                    removeInput.dataset.removeInput = 'true';
                    slot.appendChild(removeInput);
                    existingRemoved = true;
                }

                showPlaceholder();
                removeButton.classList.add('hidden');
            });
        });
    });
    document.querySelectorAll('[data-product-gallery]').forEach((gallery) => {
        const mainImage = gallery.querySelector('[data-main-product-image]');
        const viewport = gallery.querySelector('[data-gallery-viewport]');
        const thumbnails = Array.from(gallery.querySelectorAll('[data-gallery-image]'));
        const previousButton = gallery.querySelector('[data-gallery-prev]');
        const nextButton = gallery.querySelector('[data-gallery-next]');
        const counter = gallery.querySelector('[data-gallery-counter]');

        if (!mainImage || thumbnails.length === 0) return;

        let activeIndex = 0;

        const showImage = (index) => {
            activeIndex = (index + thumbnails.length) % thumbnails.length;
            const thumbnail = thumbnails[activeIndex];

            mainImage.addEventListener('load', () => mainImage.classList.remove('is-changing'), { once: true });
            mainImage.classList.add('is-changing');
            mainImage.src = thumbnail.dataset.galleryImage;
            mainImage.alt = thumbnail.querySelector('img')?.alt || mainImage.alt;

            thumbnails.forEach((item, itemIndex) => {
                item.classList.toggle('is-active', itemIndex === activeIndex);
            });

            if (counter) {
                counter.textContent = String(activeIndex + 1) + '/' + thumbnails.length;
            }
        };

        thumbnails.forEach((thumbnail, index) => {
            thumbnail.addEventListener('click', () => showImage(index));
        });

        previousButton?.addEventListener('click', () => showImage(activeIndex - 1));
        nextButton?.addEventListener('click', () => showImage(activeIndex + 1));

        let touchStartX = null;

        viewport?.addEventListener('touchstart', (event) => {
            touchStartX = event.touches[0]?.clientX ?? null;
        }, { passive: true });

        viewport?.addEventListener('touchend', (event) => {
            if (touchStartX === null) return;

            const touchEndX = event.changedTouches[0]?.clientX ?? touchStartX;
            const distance = touchEndX - touchStartX;
            touchStartX = null;

            if (Math.abs(distance) < 50) return;

            showImage(distance > 0 ? activeIndex - 1 : activeIndex + 1);
        }, { passive: true });

        showImage(0);
    });
    document.querySelectorAll('.bottom-nav a').forEach((link) => {
        link.addEventListener('pointerenter', () => link.classList.add('is-hovered'));
        link.addEventListener('pointerleave', () => link.classList.remove('is-hovered'));
        link.addEventListener('focus', () => link.classList.add('is-hovered'));
        link.addEventListener('blur', () => link.classList.remove('is-hovered'));
        link.addEventListener('pointerdown', () => {
            link.classList.add('is-hovered');
            window.setTimeout(() => link.classList.remove('is-hovered'), 450);
        });
    });
    document.querySelectorAll('[data-demo-toast]').forEach((button) => {
        button.addEventListener('click', () => {
            const toast = document.querySelector('#demo-toast');
            if (!toast) return;
            toast.querySelector('[data-toast-message]').textContent = button.dataset.demoToast;
            toast.classList.remove('translate-y-24', 'opacity-0');
            setTimeout(() => toast.classList.add('translate-y-24', 'opacity-0'), 3000);
        });
    });
    document.querySelectorAll('[data-dismiss-flash]').forEach((button) => {
        button.addEventListener('click', () => button.closest('[data-flash-message]')?.remove());
    });
});
