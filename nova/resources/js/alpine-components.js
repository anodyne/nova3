export default class AlpineComponents {
    listBox (options = {}) {
        return {
            open: false,
            value: 0,
            selected: 0,
            activeDescendant: 'listbox-option-0',
            ...options,

            init () { },

            onButtonClick () {
                this.open = !this.open;
                this.$refs.listbox.focus();
            },

            onEscape () {
                this.open = false;
            },

            onOptionSelect () { },

            onArrowUp () {
                this.selected--;
            },

            onArrowDown () {
                this.selected++;
            },

            choose (value) {
                this.value = value;
                this.selected = value;
                this.open = false;
            }
        };
    }

    modal (eventName, url, csrfToken) {
        return {
            content: null,
            isLoading: false,
            open: false,
            url,

            listen () {
                window.addEventListener(eventName, (event) => {
                    this.loadModalContent(event.detail);
                });
            },

            loadModalContent (detail) {
                fetch(this.url, {
                    method: 'POST',
                    body: JSON.stringify(detail),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                    .then(response => response.text())
                    .then(data => this.content = data)
                    .finally(() => this.open = true);
            }
        };
    }

    sortableList () {
        return {
            newSortOrder: '',
            sortable: null,

            init () {
                const el = document.getElementById('sortable-list');

                this.sortable = Sortable.create(el, {
                    draggable: '.sortable-item',
                    handle: '.sortable-handle',
                    onEnd: () => {
                        this.newSortOrder = this.sortable.toArray();
                    }
                });
            }
        };
    }

    tabsList (tab) {
        return {
            tab,

            switchTab (newTab) {
                this.tab = newTab;
                history.pushState({ tab: this.tab }, null, newTab);
            }
        };
    }

    toggleSwitch (active, disabled) {
        return {
            active,
            disabled,

            toggle ($dispatch) {
                if (!this.disabled) {
                    this.active = !this.active;
                    $dispatch('toggle-changed', { value: Boolean(this.active) });
                    $dispatch('input', Boolean(this.active));
                }
            }
        };
    }

    wordCount () {
        return {
            count: 0,

            init () {
                this.refreshCount();
            },

            refreshCount (event) {
                if (event) {
                    window.Countable.count(event.target.innerText, (counter) => {
                        this.count = window.Numeral(counter.words).format('0,0');
                    }, {
                        stripTags: true
                    });
                }
            }
        };
    }
}
