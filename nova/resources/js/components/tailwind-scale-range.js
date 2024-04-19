export default (value) => ({
    value,
    scales: [
        { label: '50' },
        { label: '100' },
        { label: '200' },
        { label: '300' },
        { label: '400' },
        { label: '500' },
        { label: '600' },
        { label: '700' },
        { label: '800' },
        { label: '900' },
        { label: '950' },
    ],
    segmentsWidth: '100%',
    progress: '0%',
    segments: 1,

    calculateProgress() {
        this.segmentsWidth = `${100 / this.segments}%`;
        this.progress = `${(100 / this.segments) * this.value}%`;
        this.$dispatch('input', this.value);
    },

    init() {
        this.segments = this.scales.length - 1;
        this.calculateProgress();
        this.$watch('value', () => this.calculateProgress());
    },
});
