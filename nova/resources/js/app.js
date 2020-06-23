import 'alpinejs';
import axios from 'axios';
import Sortable from 'sortablejs';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios = axios;
window.Sortable = Sortable;
