import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
    extend: {
        fontFamily: {
            sans: ['Inter var', 'Inter', 'ui-sans-serif', 'system-ui', ...defaultTheme.fontFamily.sans],
            display: ['Playfair Display', 'Georgia', 'ui-serif', ...defaultTheme.fontFamily.serif],
        },
        colors: {
            // Modern hotel brand colors
            primary: {
                50: '#f0f9ff',
                100: '#e0f2fe',
                200: '#bae6fd',
                300: '#7dd3fc',
                400: '#38bdf8',
                500: '#0ea5e9',
                600: '#0284c7',
                700: '#0369a1',
                800: '#075985',
                900: '#0c4a6e',
                950: '#082f49',
            },
            accent: {
                50: '#fef3c7',
                100: '#fde68a',
                200: '#fcd34d',
                300: '#fbbf24',
                400: '#f59e0b',
                500: '#d97706',
                600: '#b45309',
                700: '#92400e',
            },
        },
        animation: {
            'fade-in': 'fadeIn 0.5s ease-in',
            'slide-up': 'slideUp 0.5s ease-out',
            'scale-in': 'scaleIn 0.3s ease-out',
            'shimmer': 'shimmer 2s infinite',
        },
        keyframes: {
            fadeIn: {
                '0%': { opacity: '0' },
                '100%': { opacity: '1' },
            },
            slideUp: {
                '0%': { transform: 'translateY(20px)', opacity: '0' },
                '100%': { transform: 'translateY(0)', opacity: '1' },
            },
            scaleIn: {
                '0%': { transform: 'scale(0.95)', opacity: '0' },
                '100%': { transform: 'scale(1)', opacity: '1' },
            },
            shimmer: {
                '0%': { backgroundPosition: '-1000px 0' },
                '100%': { backgroundPosition: '1000px 0' },
            },
        },
        boxShadow: {
            'luxury': '0 20px 60px -15px rgba(0, 0, 0, 0.3)',
            'card': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
            'card-hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
        },
    },
},

    plugins: [forms],
};
