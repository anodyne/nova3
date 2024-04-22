import axios from 'axios';

import Clipboard from '@ryangjchandler/alpine-clipboard';
import AdminThemeToggle from './components/admin-theme-toggle';
import ColorPicker from './components/color-picker';
import DatePicker from './components/date-picker';
import DateFormatPicker from './components/date-format-picker';
import Modal from './components/modal';
import Ratings from './components/ratings';
import TabsList from './components/tabs-list';
import TailwindScaleRange from './components/tailwind-scale-range';
import TipTap from './components/tiptap';
import SwitchToggle from './components/switch-toggle';
import WordCount from './components/word-count';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('adminThemeToggle', AdminThemeToggle);
    window.Alpine.data('colorPicker', ColorPicker);
    window.Alpine.data('datePicker', DatePicker);
    window.Alpine.data('dateFormatPicker', DateFormatPicker);
    window.Alpine.data('modal', Modal);
    window.Alpine.data('ratings', Ratings);
    window.Alpine.data('tabsList', TabsList);
    window.Alpine.data('tailwindScaleRange', TailwindScaleRange);
    window.Alpine.data('tiptap', TipTap);
    window.Alpine.data('switchToggle', SwitchToggle);
    window.Alpine.data('wordCount', WordCount);

    window.Alpine.plugin(Clipboard);
});

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios = axios;
