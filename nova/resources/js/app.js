import axios from 'axios';
import '@nextapps-be/livewire-sortablejs';
import './alpine';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios = axios;
