import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                mumpul: {
                    maroon: '#5B1315',   
                    cream: '#FDF7EA',   
                    yellow: '#FFE033',   
                    green: '#1E3F20',   
                    greenHover: '#143519',
                    text: '#2B1E1A',
                }
            },
            fontFamily: {
                serif: ['Georgia', 'Merriweather', ...defaultTheme.fontFamily.serif],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};