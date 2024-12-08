import axios from 'axios';

import SwitchToggle from './components/switch-toggle';

document.addEventListener('alpine:init', () => {
    console.log('alpine init');
    window.Alpine.data('switchToggle', SwitchToggle);
});

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios = axios;
