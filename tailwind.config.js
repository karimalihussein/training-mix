const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./resources/js/**/*.jsx",
    ],

    theme: {
        extend: {
            colors: {
                transparent: "transparent",
                current: "currentColor",

                black: colors.black,
                white: colors.white,
                gray: colors.neutral, // ✅ trueGray -> neutral
                "gray-background": "#f7f8fc",
                blue: "#328af1",
                "blue-hover": "#2879bd",
                yellow: "#ffc73c",
                red: "#ec454f",
                "red-100": "#fee2e2",
                green: "#1aab8b",
                "green-50": "#f0fdf4",
                purple: "#8b60ed",
            },
            spacing: {
                22: "5.5rem",
                44: "11rem",
                70: "17.5rem",
                76: "19rem",
                104: "26rem",
                128: "32rem",
                175: "43.75rem",
            },
            maxWidth: {
                custom: "68.5rem",
            },
            boxShadow: {
                card: "4px 4px 15px 0 rgba(36, 37, 38, 0.08)",
                dialog: "3px 4px 15px 0 rgba(36, 37, 38, 0.22)",
            },
            fontFamily: {
                sans: ["Open Sans", ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                xxs: ["0.625rem", { lineHeight: "1rem" }],
            },
            animation: {
                "slide-in-right": "slideInRight 0.5s ease-out",
                pulse: "pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite",
            },
            keyframes: {
                slideInRight: {
                    "0%": {
                        transform: "translateX(100%)",
                        opacity: "0",
                    },
                    "100%": {
                        transform: "translateX(0)",
                        opacity: "1",
                    },
                },
            },
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/line-clamp"),
    ],
};
