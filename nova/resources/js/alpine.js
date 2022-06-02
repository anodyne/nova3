import Alpine from 'alpinejs';

import Collapse from '@alpinejs/collapse';
import Focus from '@alpinejs/focus';
import Tooltip from '@ryangjchandler/alpine-tooltip';

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

Alpine.plugin(Collapse);
Alpine.plugin(Focus);
Alpine.plugin(Tooltip);

Alpine.data('adminThemeToggle', AdminThemeToggle);
Alpine.data('colorPicker', ColorPicker);
Alpine.data('datePicker', DatePicker);
Alpine.data('filtersPanel', FiltersPanel);
Alpine.data('listBox', ListBox);
Alpine.data('modal', Modal);
Alpine.data('ratings', Ratings);
Alpine.data('sortableList', SortableList);
Alpine.data('tabsList', TabsList);
Alpine.data('tipTap', TipTap);
Alpine.data('toggleSwitch', ToggleSwitch);
Alpine.data('wordCount', WordCount);

window.Alpine = Alpine;

Alpine.start();
