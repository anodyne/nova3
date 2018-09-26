/**
 * All credit goes to the folks at Bulma.io for this stuff. The simplicity
 * of this stuff is amazing and they really should consider wrapping all
 * of this up into a small Javascript companion library that works with
 * their framework!
 */

function getAll (selector) {
    return Array.prototype.slice.call(document.querySelectorAll(selector), 0);
}

document.addEventListener('DOMContentLoaded', () => {
    /**
     * Dropdowns
     */

    const $dropdowns = getAll('.dropdown:not(.is-hoverable)');

    function closeDropdowns () {
        $dropdowns.forEach(($el) => {
            $el.classList.remove('is-active');
        });
    }

    if ($dropdowns.length > 0) {
        $dropdowns.forEach(($el) => {
            $el.addEventListener('click', (event) => {
                event.stopPropagation();
                $el.classList.toggle('is-active');
            });
        });

        document.addEventListener('click', () => {
            closeDropdowns();
        });
    }

    /**
     * Modals
     */

    const rootEl = document.documentElement;
    const $modals = getAll('.modal');
    const $modalButtons = getAll('.modal-button');
    const $modalCloses = getAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button');

    function closeModals () {
        rootEl.classList.remove('is-clipped');

        $modals.forEach(($el) => {
            $el.classList.remove('is-active');
        });
    }

    if ($modalButtons.length > 0) {
        $modalButtons.forEach(($el) => {
            $el.addEventListener('click', ({ dataset }) => {
                const $target = document.getElementById(dataset.target);
                rootEl.classList.add('is-clipped');
                $target.classList.add('is-active');
            });
        });
    }

    if ($modalCloses.length > 0) {
        $modalCloses.forEach(($el) => {
            $el.addEventListener('click', () => {
                closeModals();
            });
        });
    }

    document.addEventListener('keydown', (event) => {
        const e = event || window.event;

        if (e.keyCode === 27) {
            closeModals();
            closeDropdowns();
        }
    });
});
