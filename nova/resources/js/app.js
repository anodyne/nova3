import 'alpinejs';
import axios from 'axios';
import Numeral from 'numeral';
import Countable from 'countable';
import Sortable from 'sortablejs';
import EditorJS from '@editorjs/editorjs';
import AlpineComponents from './alpine-components';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios = axios;
window.Numeral = Numeral;
window.EditorJS = EditorJS;
window.Sortable = Sortable;
window.Countable = Countable;
window.AlpineComponents = new AlpineComponents();
