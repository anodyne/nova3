import dashboardSteps from './dashboard';

function filterVisibleSteps(steps) {
    return steps.filter((step) => {
        if (!step.attachTo?.element) return true;
        return document.querySelector(step.attachTo.element);
    });
}

function registerTours() {
    const tourMap = {
        'dashboard-tour': dashboardSteps,
    };

    if (typeof window.TourManager?.register === 'function') {
        Object.entries(tourMap).forEach(([key, steps]) => {
            const filtered = filterVisibleSteps(steps);
            window.TourManager.register(key, filtered);
        });
    }
}

export default registerTours;
