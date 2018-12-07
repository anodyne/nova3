import Nova from './Nova';

import './bootstrap';
import './event-listeners';
import './plugins';
import './directives';
import './components';

(function () {
    this.CreateNova = function (config) {
        return new Nova(config);
    };
}.call(window));
