import 'alpinejs/dist/cdn';

import AdminThemeToggle from './components/admin-theme-toggle';
import ColorPicker from './components/color-picker';
import DatePicker from './components/date-picker';
import FiltersPanel from './components/filters-panel';
import ListBox from './components/list-box';
import Modal from './components/modal';
import Ratings from './components/ratings';
import SortableList from './components/sortable-list';
import TabsList from './components/tabs-list';
import TipTap from './components/tiptap';
import ToggleSwitch from './components/toggle-switch';
import WordCount from './components/word-count';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('adminThemeToggle', AdminThemeToggle);
    window.Alpine.data('colorPicker', ColorPicker);
    window.Alpine.data('datePicker', DatePicker);
    window.Alpine.data('filtersPanel', FiltersPanel);
    window.Alpine.data('listBox', ListBox);
    window.Alpine.data('modal', Modal);
    window.Alpine.data('ratings', Ratings);
    window.Alpine.data('sortableList', SortableList);
    window.Alpine.data('tabsList', TabsList);
    window.Alpine.data('tipTap', TipTap);
    window.Alpine.data('toggleSwitch', ToggleSwitch);
    window.Alpine.data('wordCount', WordCount);
});
