import 'alpinejs';
import axios from 'axios';
import Numeral from 'numeral';
import Countable from 'countable';
import Sortable from 'sortablejs';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios = axios;
window.Numeral = Numeral;
window.Sortable = Sortable;
window.Countable = Countable;
