export default (eventName, url, csrfToken) => ({
    content: null,
    isLoading: false,
    open: false,
    url,

    init() {
        window.addEventListener(eventName, (event) => {
            this.loadModalContent(event.detail);
        });
    },

    loadModalContent(detail) {
        if (this.url) {
            fetch(this.url, {
                method: 'POST',
                body: JSON.stringify(detail),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
            })
                .then((response) => response.text())
                .then((data) => (this.content = data))
                .finally(() => (this.open = true));
        } else {
            this.open = true;
        }
    },
});
