import iro from '@jaames/iro';

export default (element, color) => ({
    element,
    color,
    colorPicker: null,
    inputColor: color,

    init() {
        this.colorPicker = new iro.ColorPicker(this.element, {
            color: this.color,
            width: 225,
        });

        this.colorPicker.on('color:change', (c) => {
            this.color = c.hexString;
            this.inputColor = this.color;
        });
    },
});
