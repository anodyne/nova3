import NavMobileUserInfo from './NavMobileUserInfo.vue';
import NavMobileUserNotifications from './NavMobileUserNotifications.vue';
import NavMobileUserInbox from './NavMobileUserInbox.vue';

export default [
    {
        name: 'Basic Info',
        key: 'info',
        component: NavMobileUserInfo,
        icon: 'user'
    },
    {
        name: 'Notifications',
        key: 'notifications',
        component: NavMobileUserNotifications,
        icon: 'notification'
    },
    {
        name: 'Inbox',
        key: 'inbox',
        component: NavMobileUserInbox,
        icon: 'inbox'
    },
    {
        name: 'Sign Out',
        key: 'sign-out',
        component: 'NavMobileUserInfo',
        icon: 'sign-out'
    }
];
