import { fontFamily } from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    daisyui: {
        themes: [
            {
                mytheme: {

                    // "primary": "#34d399",
                    
                    "primary": "#14b8a6",

                    "primary": "#2c6975",

                    "secondary": "#68b2a0",

                    "accent": "#2d82b5",

                    "neutral": "#2b3440",

                    // "base-100": "#ffffff",

                    // "base-100": "#e0e7ff",

                    // "base-100": "#eff2ff",

                    // "base-100": "#f6f8ff",
                    
                    // "base-100": "#fafbff",

                    "base-100": "#f9fefe",
                    "base-100": "#e4f3ef",
                    "base-100": "#eff5f3",

                    "info": "#3abff8",

                    "success": "#36d399",

                    "warning": "#fbbd23",

                    "error": "#f87272",
                },
            },
        ],
    },

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", ...fontFamily.sans],
            },
        },
    },

    plugins: [forms, require("daisyui")],
};
