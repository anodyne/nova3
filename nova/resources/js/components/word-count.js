import Countable from 'countable';
import Numeral from 'numeral';

export default () => ({
    count: 0,

    init() {
        this.refreshCount();
    },

    refreshCount(event) {
        if (event) {
            Countable.count(event.target.innerText, (counter) => {
                this.count = Numeral(counter.words).format('0,0');
            }, {
                stripTags: true,
            });
        }
    },
});
