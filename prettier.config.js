module.exports = {
    plugins: [
        'prettier-plugin-blade',
        'prettier-plugin-tailwindcss',
    ],
    overrides: [
        {
            files: [
                '*.blade.php',
            ],
            options: {
                parser: 'blade',
                printWidth: 120,
            },
        },
    ],
};
