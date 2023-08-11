import defaultTheme from "tailwindcss/defaultTheme";
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
                    "primary": "#050505",

                    "secondary": "#FA0706",

                    "accent": "#04ABA3",

                    "neutral": "#DFC9C8",

                    "base-100": "#ffffff",

                    "info": "#3abff8",

                    "success": "#36d399",

                    "warning": "#fbbd23",

                    "error": "#f87272",
                },
            },
        ],
    },

    // theme: {
    //     extend: {
    //         fontFamily: {
    //             sans: ["Figtree", ...defaultTheme.fontFamily.sans],
    //         },
    //     },
    // },

    plugins: [forms, require("daisyui")],
};
