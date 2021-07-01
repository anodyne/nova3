import Alpine from 'alpinejs';

import Modal from './components/modal';
import Ratings from './components/ratings';
import SortableList from './components/sortable-list';
import TabsList from './components/tabs-list';
import TipTap from './components/tip-tap';
import ToggleSwitch from './components/toggle-switch';
import WordCount from './components/word-count';

Alpine.data('modal', Modal);
Alpine.data('ratings', Ratings);
Alpine.data('sortableList', SortableList);
Alpine.data('tabsList', TabsList);
Alpine.data('tipTap', TipTap);
Alpine.data('toggleSwitch', ToggleSwitch);
Alpine.data('wordCount', WordCount);

window.Alpine = Alpine;

Alpine.start();
