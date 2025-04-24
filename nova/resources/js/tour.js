import Shepherd from 'shepherd.js';
import { offset } from '@floating-ui/dom';

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

window.TourManager.register('dashboard-tour', [
    {
        id: 'step-nav-search',
        title: 'Global search',
        text: 'Welcome to the dashboard!',
        attachTo: { element: '[data-tour=dashboard-search]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-nav-messages',
        title: 'Private messages',
        text: 'Welcome to the dashboard!',
        attachTo: { element: '[data-tour=dashboard-messages]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-nav-notifications',
        title: 'Notifications',
        text: 'Nova will send many of its notifications through the in-app notification system. This prevents your email inbox from being flooded by messages that you immediately delete.',
        attachTo: { element: '[data-tour=dashboard-notifications]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-nav-writing',
        title: 'Writing',
        text: 'Here is where you will write story posts, manage stories, and manage post types.',
        attachTo: { element: '[data-tour=writing]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-nav-characters',
        title: 'Characters',
        text: 'Manage game characters from here as well as things like departments, positions, and ranks.',
        attachTo: { element: '[data-tour=characters]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-nav-users',
        title: 'Users',
        text: 'Manage users from here as well as things like authorization roles.',
        attachTo: { element: '[data-tour=users]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-nav-pages',
        title: 'Pages',
        text: 'Every page in Nova is now controlled through the Page Manager. In addition to being able to modify existing pages, you can create new public-facing pages and design them with a simple block-based editor.',
        attachTo: { element: '[data-tour=pages]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-nav-forms',
        title: 'Forms',
        text: 'Every page in Nova is now controlled through the Page Manager. In addition to being able to modify existing pages, you can create new public-facing pages and design them with a simple block-based editor.',
        attachTo: { element: '[data-tour=forms]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-nav-reporting',
        title: 'Reports',
        text: 'Every page in Nova is now controlled through the Page Manager. In addition to being able to modify existing pages, you can create new public-facing pages and design them with a simple block-based editor.',
        attachTo: { element: '[data-tour=reporting]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-nav-settings',
        title: 'Settings',
        text: 'Every page in Nova is now controlled through the Page Manager. In addition to being able to modify existing pages, you can create new public-facing pages and design them with a simple block-based editor.',
        attachTo: { element: '[data-tour=settings]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-nav-system',
        title: 'System overview',
        text: 'In addition to seeing an overview of the system, this is where you will find add-on management, public menu items, themes, and a convenient error log viewer.',
        attachTo: { element: '[data-tour=system]', on: 'right' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-writing-overview',
        title: 'Contribution stats',
        text: 'This will provide a running set of stats about writing contributions to the game from yourself and other players.',
        attachTo: { element: '[data-tour=dashboard-writing-overview]', on: 'left' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-writing-level',
        title: 'Contribution level',
        text: 'As you contribute more to the game, your contribution level will increase. How high can you get your contribution level?',
        attachTo: { element: '[data-tour=dashboard-writing-level]', on: 'left' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-writing-stats',
        title: 'Contribution stats',
        text: 'As you contribute more to the game, your contribution level will increase. How high can you get your contribution level?',
        attachTo: { element: '[data-tour=dashboard-writing-stats]', on: 'left' },
        buttons: [{ text: 'Next', action: () => window.TourManager.instances['dashboard-tour'].next() }],
    },
    {
        id: 'step-help',
        title: 'Get help',
        text: 'If you have questions or need help, you can always join our Discord server to get help with Nova.',
        attachTo: { element: '[data-tour=dashboard-help]', on: 'right' },
        buttons: [
            { text: 'Back', action: () => window.TourManager.instances['dashboard-tour'].back() },
            {
                text: 'Finish',
                action: () => {
                    window.TourManager.instances['dashboard-tour'].complete();
                },
            },
        ],
    },
]);
