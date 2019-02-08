import Vue from 'vue';
import Nova from './nova';

import './components';
import './directives';
import './plugins';

window.Vue = Vue;

window.Nova = new Nova();
