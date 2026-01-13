import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        screens: {
            sm: '480px',
            md: '768px',
            pw: '845px',
            lg: '976px',
            xl: '1440px'
        },
        extend: {
            colors: {
                'crimson': '#8B0000',
                'body': '#F6C8C3',
                'ruby': '#B22222',
                'coral': '#DC143C',
                'mauve': '#DD9191',
                'dustyRose': '#CF7070',
                'logoColor': '#FF4D80',
                'patchHeader': '#FF4D4D',
                'loginForm': 'rgba(227, 70, 70, 0.77)',
                'itemPanel': '#E34646',
                'darkerItemPanel': '#B22222',
                'panels': '#F6C8C3',
                'statBar': "#D60A0A"
            },
            animation: {
                fadeIn: 'fadeIn 0.3s ease-out forwards',
                fadeOut: 'fadeOut 0.3s ease-in forwards',
                slideIn: 'slideIn 0.3s ease-out forwards',
            },
            keyframes: {
                fadeIn: {
                    from: {
                        opacity: '0',
                        transform: 'translateY(10px)'
                    },
                    to: {
                        opacity: '1',
                        transform: 'translateY(0)'
                    },
                },
                fadeOut: {
                    from: { 
                        opacity: '1', transform: 'translateX(0)' 
                    },
                    to: { 
                        opacity: '0', transform: 'translateX(20px)' 
                    },
                },
                slideIn: {
                    '0%': {
                        opacity: '0',
                        transform: 'translateX(20px)',
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateX(0)',
                    },
                },
                pulse: {
                    '0%': {
                        transform: 'translate(-180px, -120px) rotate(-30deg) scale(1)',
                    },
                    '50%': {
                        transform: 'translate(-180px, -120px) rotate(-30deg) scale(1.05)',
                    },
                    '100%': {
                        transform: 'translate(-180px, -120px) rotate(-30deg) scale(1)',
                    },
                },
            },

            width: {
                '1/7': '14.2857%',
                '1/8': '12.5%'
            }
        },
    },
    plugins: [],
};
