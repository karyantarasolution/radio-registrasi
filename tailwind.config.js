import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/auth/*.blade.php',
        './resources/views/components/*.blade.php',
        // './resources/views/**/*.blade.php',
        './resources/views/profile/*.blade.php',
        './resources/views/layouts/guest.blade.php',
        './resources/views/layouts/navigation.blade.php',
        "./resources/registrasi/index.blade.php",
        "./resources/css/app.css",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};