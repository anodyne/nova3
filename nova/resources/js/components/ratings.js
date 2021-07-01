export default (count = 0) => ({
    count,

    setCount(newCount) {
        this.count = newCount;
    },

    rating: (i) => ({
        'x-on:keydown.space.prevent': function () {
            this.count = i;
        },
        'x-on:keydown.arrow-right.prevent': function () {
            const next = this.$el.closest('[x-data="ratings"]').querySelector(`[data-rating="${i + 1}"]`);

            if (!next) {
                return;
            }

            next.focus();
            this.count = next.dataset.rating;
        },
        'x-on:keydown.arrow-left.prevent': function () {
            const previous = this.$el.closest('[x-data="ratings"]').querySelector(`[data-rating="${i - 1}"]`);

            if (!previous) {
                return;
            }

            previous.focus();
            this.count = previous.dataset.rating;
        },
        'x-bind:data-rating': function () {
            return i;
        },
    }),
});
