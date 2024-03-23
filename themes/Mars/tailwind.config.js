const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "views/*.blade.php",
        "views/**/*.blade.php",
        "views/**/**/*.blade.php",
        "views/**/**/**/*.blade.php",
        "views/**/**/**/**/*.blade.php",
        "resources/**/*.vue",
    ],
    theme  : {
        extend: {
            fontFamily        : {
                'sans': [...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
