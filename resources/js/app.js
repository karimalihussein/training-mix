import "./bootstrap";
import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/react";

// Import all pages
import Login from "./Pages/Auth/Login";
import Dashboard from "./Pages/Admin/Dashboard";
import UsersIndex from "./Pages/Admin/Users/Index";
import UsersCreate from "./Pages/Admin/Users/Create";
import ProductsIndex from "./Pages/Admin/Products/Index";
import ProductsCreate from "./Pages/Admin/Products/Create";
import ReportsIndex from "./Pages/Admin/Reports/Index";
import App1 from "./Pages/LandingPage/App1";
import App2 from "./Pages/LandingPage/App2";
import App3 from "./Pages/LandingPage/App3";
import App4 from "./Pages/LandingPage/App4";

createInertiaApp({
    resolve: (name) => {
        const pages = {
            "Auth/Login": Login,
            "Admin/Dashboard": Dashboard,
            "Admin/Users/Index": UsersIndex,
            "Admin/Users/Create": UsersCreate,
            "Admin/Products/Index": ProductsIndex,
            "Admin/Products/Create": ProductsCreate,
            "Admin/Reports/Index": ReportsIndex,
            "LandingPage/App1": App1,
            "LandingPage/App2": App2,
            "LandingPage/App3": App3,
            "LandingPage/App4": App4,
        };
        return pages[name];
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
});
