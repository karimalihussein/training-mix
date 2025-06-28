# Custom Admin Panel with React & Inertia.js

A comprehensive, modern admin panel built with Laravel, React, and Inertia.js featuring a clean, responsive design and full CRUD functionality.

## Features

### 🔐 Authentication System

-   **Custom Login Page**: Clean, modern login interface with password visibility toggle
-   **Admin Middleware**: Route protection for admin-only access
-   **Session Management**: Secure authentication with remember me functionality

### 📊 Dashboard

-   **Statistics Cards**: Real-time metrics for users, products, orders, revenue, etc.
-   **Interactive Charts**: Line charts, bar charts, pie charts using Recharts
-   **Recent Activity Feed**: Live updates of system activities
-   **Quick Actions**: Direct links to common admin tasks

### 🗂️ Resource Management

-   **Users**: Full CRUD operations with role management
-   **Products**: Inventory management with stock tracking
-   **Articles**: Content management with draft/published states
-   **Invoices**: Financial tracking and management
-   **Orders**: Order processing and status management
-   **Offices**: Location management
-   **Visits**: Appointment and visit scheduling

### 📈 Reports & Analytics

-   **Sales Reports**: Revenue tracking and trend analysis
-   **User Analytics**: Growth metrics and user behavior
-   **Product Performance**: Top-selling products and inventory insights
-   **Interactive Charts**: Multiple chart types for data visualization

### 🎨 UI/UX Features

-   **Responsive Design**: Works perfectly on desktop, tablet, and mobile
-   **Dark/Light Mode Ready**: Easy to implement theme switching
-   **Modern Components**: Built with Headless UI and Heroicons
-   **Data Tables**: Sortable, searchable tables with pagination
-   **Form Components**: Reusable form builder with validation

## Technology Stack

### Frontend

-   **React 18+**: Modern React with hooks and functional components
-   **Inertia.js**: Seamless SPA experience without API complexity
-   **Tailwind CSS**: Utility-first CSS framework
-   **Headless UI**: Accessible UI components
-   **Heroicons**: Beautiful SVG icons
-   **Recharts**: Interactive charts and data visualization

### Backend

-   **Laravel 10+**: PHP framework with robust features
-   **Eloquent ORM**: Database management and relationships
-   **Middleware**: Route protection and authentication
-   **Resource Controllers**: RESTful API design

## File Structure

```
resources/
├── js/
│   ├── app.js                    # Main React app entry point
│   ├── Layouts/
│   │   └── AdminLayout.jsx       # Main admin layout component
│   ├── Pages/
│   │   ├── Auth/
│   │   │   └── Login.jsx         # Custom login page
│   │   └── Admin/
│   │       ├── Dashboard.jsx     # Main dashboard
│   │       ├── Users/
│   │       │   ├── Index.jsx     # Users listing
│   │       │   └── Create.jsx    # User creation form
│   │       ├── Products/
│   │       │   ├── Index.jsx     # Products listing
│   │       │   └── Create.jsx    # Product creation form
│   │       └── Reports/
│   │           └── Index.jsx     # Reports and analytics
│   └── Components/
│       ├── DataTable.jsx         # Reusable data table
│       └── Form.jsx              # Reusable form builder
├── views/
│   └── admin.blade.php           # Admin panel blade template

app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/                # Admin controllers
│   │       ├── AdminController.php
│   │       ├── UserController.php
│   │       ├── ProductController.php
│   │       ├── ReportController.php
│   │       └── ...
│   └── Middleware/
│       └── AdminMiddleware.php   # Admin route protection

routes/
├── admin.php                     # Admin routes
└── web.php                       # Main routes (includes admin)
```

## Installation & Setup

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer require inertiajs/inertia-laravel

# Install Node.js dependencies
npm install @inertiajs/react @headlessui/react @heroicons/react recharts
```

### 2. Configure Inertia.js

The admin panel is already configured with Inertia.js in `resources/js/app.js`.

### 3. Set Up Routes

Admin routes are defined in `routes/admin.php` and included in `routes/web.php`.

### 4. Create Admin User

You can create an admin user through the registration system or directly in the database.

### 5. Access Admin Panel

Visit `/dashboard/login` to access the admin panel.

## Usage

### Authentication

1. Navigate to `/dashboard/login`
2. Enter your credentials
3. Access the admin dashboard

### Managing Resources

Each resource (Users, Products, etc.) provides:

-   **Index Page**: List all items with search and sort functionality
-   **Create Page**: Add new items with form validation
-   **Edit Page**: Modify existing items
-   **Show Page**: View detailed information
-   **Delete**: Remove items with confirmation

### Reports & Analytics

-   **Dashboard**: Overview of key metrics
-   **Sales Reports**: Revenue and order analysis
-   **User Reports**: User growth and behavior
-   **Product Reports**: Inventory and performance metrics

## Customization

### Adding New Resources

1. Create a new controller in `app/Http/Controllers/Admin/`
2. Add routes to `routes/admin.php`
3. Create React components in `resources/js/Pages/Admin/`
4. Update the navigation in `AdminLayout.jsx`

### Styling

The admin panel uses Tailwind CSS. You can customize:

-   Colors in `tailwind.config.js`
-   Components in individual `.jsx` files
-   Global styles in `resources/css/app.css`

### Charts

Charts are built with Recharts. You can:

-   Add new chart types
-   Customize colors and styling
-   Integrate with real data sources

## Security Features

-   **CSRF Protection**: All forms include CSRF tokens
-   **Admin Middleware**: Route-level protection
-   **Input Validation**: Server-side validation for all forms
-   **SQL Injection Protection**: Eloquent ORM protection
-   **XSS Protection**: Inertia.js automatic escaping

## Performance Optimizations

-   **Lazy Loading**: Components load on demand
-   **Pagination**: Efficient data loading
-   **Caching**: Ready for Redis/Memcached integration
-   **Asset Optimization**: Vite.js for fast builds

## Future Enhancements

### Planned Features

-   [ ] Role-based permissions system
-   [ ] Real-time notifications
-   [ ] Advanced search and filtering
-   [ ] Bulk operations
-   [ ] Export functionality (CSV, PDF)
-   [ ] Audit logging
-   [ ] API endpoints for mobile apps
-   [ ] Multi-language support
-   [ ] Dark mode toggle
-   [ ] Advanced analytics dashboard

### Technical Improvements

-   [ ] Unit and feature tests
-   [ ] API documentation
-   [ ] Performance monitoring
-   [ ] Error tracking
-   [ ] Automated backups
-   [ ] CI/CD pipeline

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This admin panel is part of the training-mix project and follows the same licensing terms.

## Support

For support and questions:

-   Check the Laravel documentation
-   Review Inertia.js documentation
-   Consult the Tailwind CSS documentation
-   Open an issue in the repository

---

**Built with ❤️ using Laravel, React, and Inertia.js**
