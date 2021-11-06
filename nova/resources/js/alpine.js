import Alpine from 'alpinejs';

import Trap from '@alpinejs/trap';

import ListBox from './components/list-box';
import Modal from './components/modal';
import Ratings from './components/ratings';
import SortableList from './components/sortable-list';
import TabsList from './components/tabs-list';
import TipTap from './components/tiptap';
import ToggleSwitch from './components/toggle-switch';
import WordCount from './components/word-count';

Alpine.plugin(Trap);

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
