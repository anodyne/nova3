import Shepherd from 'shepherd.js';
import { offset } from '@floating-ui/dom';
import registerTours from './tours';

function setupTour(tourKey = 'default', steps = []) {
    const tour = new Shepherd.Tour({
        useModalOverlay: true,
        defaultStepOptions: {
            cancelIcon: { enabled: true },
            arrow: false,
            scrollTo: { behavior: 'smooth', block: 'center' },
            modalOverlayOpeningRadius: 12,
            modalOverlayOpeningPadding: 6,
            floatingUIOptions: {
                middleware: [offset(24)],
            },
        },
    });

    steps.forEach((step) => tour.addStep(step));

    tour.on('complete', () => {
        window.livewire?.dispatch('tourCompleted', { tour: tourKey });
    });

    tour.on('cancel', () => {
        window.livewire?.dispatch('tourCancelled', { tour: tourKey });
    });

    return tour;
}

window.TourManager = {
    instances: {},
    register(tourKey, steps) {
        if (this.instances[tourKey]) return;

        this.instances[tourKey] = setupTour(tourKey, steps);
    },
    start(tourKey) {
        this.instances[tourKey]?.start();
    },
};

document.addEventListener('DOMContentLoaded', () => {
    registerTours();
});

document.addEventListener('livewire:navigated', () => {
    registerTours();
});
