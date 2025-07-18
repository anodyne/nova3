export default function Carousel(carouselData = { slides: [], intervalTime: 4000 }) {
    return {
        slides: carouselData.slides,
        autoplayIntervalTime: carouselData.intervalTime,
        currentSlideIndex: 1,
        isPaused: false,
        autoplayInterval: null,

        previous() {
            if (this.currentSlideIndex > 1) {
                this.currentSlideIndex -= 1;
            } else {
                this.currentSlideIndex = this.slides.length;
            }
        },

        next() {
            if (this.currentSlideIndex < this.slides.length) {
                this.currentSlideIndex += 1;
            } else {
                this.currentSlideIndex = 1;
            }
        },

        autoplay() {
            clearInterval(this.autoplayInterval);

            if (this.autoplayIntervalTime > 0) {
                this.autoplayInterval = setInterval(() => {
                    if (!this.isPaused) {
                        this.next();
                    }
                }, this.autoplayIntervalTime);
            }
        },

        setAutoplayIntervalTime(newIntervalTime) {
            this.autoplayIntervalTime = newIntervalTime;
            this.autoplay();
        },
    };
}
