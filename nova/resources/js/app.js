import Nova from './Nova';

import './bootstrap';
import './event-listeners';
import './components';

(function () {
    this.CreateNova = function (config) {
        return new Nova(config);
    };
}.call(window));
