import axios from 'axios';
import '@tailwindplus/elements';

import Clipboard from '@ryangjchandler/alpine-clipboard';
import CharacterCount from '@tiptap/extension-character-count';
import Carousel from './components/carousel';
import ColorPicker from './components/color-picker';
import Cropper from './components/cropper';
import DatePicker from './components/date-picker';
import DateFormatPicker from './components/date-format-picker';
import KeyValueField from './components/key-value-field';
import registerFilepond from './components/filepond';
import Modal from './components/modal';
import Ratings from './components/ratings';
import TabsList from './components/tabs-list';
import TailwindScaleRange from './components/tailwind-scale-range';
import SwitchToggle from './components/switch-toggle';
import WordCount from './components/word-count';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('carousel', Carousel);
    window.Alpine.data('colorPicker', ColorPicker);
    window.Alpine.data('cropper', Cropper);
    window.Alpine.data('datePicker', DatePicker);
    window.Alpine.data('dateFormatPicker', DateFormatPicker);
    window.Alpine.data('keyValueField', KeyValueField);
    window.Alpine.data('modal', Modal);
    window.Alpine.data('ratings', Ratings);
    window.Alpine.data('tabsList', TabsList);
    window.Alpine.data('tailwindScaleRange', TailwindScaleRange);
    // window.Alpine.data('tiptap', TipTap);
    window.Alpine.data('switchToggle', SwitchToggle);
    window.Alpine.data('wordCount', WordCount);

    window.Alpine.plugin(Clipboard);

    registerFilepond();
});

document.addEventListener('flux:editor', (e) => {
    e.detail.registerExtension(
        CharacterCount.configure({
            wordCounter: (text) =>
                text.split(/\s+/).filter((word) => word !== '').length,
        }),
    );
});

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios = axios;
