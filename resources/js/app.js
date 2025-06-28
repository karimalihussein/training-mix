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
        };
        return pages[name];
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
});
