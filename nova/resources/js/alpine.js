import Alpine from 'alpinejs';

import Collapse from '@alpinejs/collapse';
import Focus from '@alpinejs/focus';

import AdminThemeToggle from './components/admin-theme-toggle';
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

Alpine.data('adminThemeToggle', AdminThemeToggle);
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
