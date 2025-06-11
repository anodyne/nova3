import TrueCropper from 'truecropper';

export default () => ({
    cropper: null,

    init() {
        this.$nextTick(() => {
            this.cropper = new TrueCropper(this.$refs.image, {
                aspectRatio: 1,
            });
        });
    },

    cropImage() {
        if (!this.cropper) return;

        const originalCanvas = this.cropper.getImagePreview();

        // Target size (square)
        const maxSize = 400;

        const resizedCanvas = document.createElement('canvas');
        resizedCanvas.width = maxSize;
        resizedCanvas.height = maxSize;

        const ctx = resizedCanvas.getContext('2d');

        // Preserve transparency
        ctx.clearRect(0, 0, maxSize, maxSize);
        ctx.drawImage(originalCanvas, 0, 0, maxSize, maxSize);

        resizedCanvas.toBlob((blob) => {
            const file = new File([blob], 'avatar.png', { type: 'image/png' });

            const input = this.$refs.fileInput;
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;

            input.dispatchEvent(new Event('change', { bubbles: true }));
        }, 'image/png');
    },
});
