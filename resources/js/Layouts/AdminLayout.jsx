import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import {
    Bars3Icon,
    XMarkIcon,
    HomeIcon,
    UsersIcon,
    CubeIcon,
    DocumentTextIcon,
    ReceiptPercentIcon,
    ShoppingCartIcon,
    BuildingOfficeIcon,
    EyeIcon,
    ChartBarIcon,
    UserCircleIcon,
    ArrowRightOnRectangleIcon,
} from '@heroicons/react/24/outline';

const navigation = [
    { name: 'Dashboard', href: '/dashboard', icon: HomeIcon },
    { name: 'Users', href: '/dashboard/users', icon: UsersIcon },
    { name: 'Products', href: '/dashboard/products', icon: CubeIcon },
    { name: 'Articles', href: '/dashboard/articles', icon: DocumentTextIcon },
    { name: 'Invoices', href: '/dashboard/invoices', icon: ReceiptPercentIcon },
    { name: 'Orders', href: '/dashboard/orders', icon: ShoppingCartIcon },
    { name: 'Offices', href: '/dashboard/offices', icon: BuildingOfficeIcon },
    { name: 'Visits', href: '/dashboard/visits', icon: EyeIcon },
    { name: 'Reports', href: '/dashboard/reports', icon: ChartBarIcon },
];

export default function AdminLayout({ children, title = 'Admin Panel' }) {
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const { auth } = usePage().props;

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Mobile sidebar */}
            <div className={`fixed inset-0 z-50 lg:hidden ${sidebarOpen ? 'block' : 'hidden'}`}>
                <div className="fixed inset-0 bg-gray-600 bg-opacity-75" onClick={() => setSidebarOpen(false)} />
                <div className="fixed inset-y-0 left-0 flex w-64 flex-col bg-white">
                    <div className="flex h-16 items-center justify-between px-4">
                        <h1 className="text-xl font-semibold text-gray-900">Admin Panel</h1>
                        <button
                            onClick={() => setSidebarOpen(false)}
                            className="text-gray-400 hover:text-gray-600"
                        >
                            <XMarkIcon className="h-6 w-6" />
                        </button>
                    </div>
                    <nav className="flex-1 space-y-1 px-2 py-4">
                        {navigation.map((item) => (
                            <Link
                                key={item.name}
                                href={item.href}
                                className="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                            >
                                <item.icon className="mr-3 h-5 w-5" />
                                {item.name}
                            </Link>
                        ))}
                    </nav>
                </div>
            </div>

            {/* Desktop sidebar */}
            <div className="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
                <div className="flex flex-col flex-grow bg-white border-r border-gray-200">
                    <div className="flex h-16 items-center px-4">
                        <h1 className="text-xl font-semibold text-gray-900">Admin Panel</h1>
                    </div>
                    <nav className="flex-1 space-y-1 px-2 py-4">
                        {navigation.map((item) => (
                            <Link
                                key={item.name}
                                href={item.href}
                                className="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                            >
                                <item.icon className="mr-3 h-5 w-5" />
                                {item.name}
                            </Link>
                        ))}
                    </nav>
                    <div className="border-t border-gray-200 p-4">
                        <div className="flex items-center">
                            <UserCircleIcon className="h-8 w-8 text-gray-400" />
                            <div className="ml-3">
                                <p className="text-sm font-medium text-gray-700">{auth.user?.name}</p>
                                <p className="text-xs text-gray-500">{auth.user?.email}</p>
                            </div>
                        </div>
                        <Link
                            href="/dashboard/logout"
                            method="post"
                            as="button"
                            className="mt-3 flex w-full items-center px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md"
                        >
                            <ArrowRightOnRectangleIcon className="mr-3 h-5 w-5" />
                            Logout
                        </Link>
                    </div>
                </div>
            </div>

            {/* Main content */}
            <div className="lg:pl-64">
                {/* Top bar */}
                <div className="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                    <button
                        type="button"
                        className="-m-2.5 p-2.5 text-gray-700 lg:hidden"
                        onClick={() => setSidebarOpen(true)}
                    >
                        <Bars3Icon className="h-6 w-6" />
                    </button>

                    <div className="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                        <div className="flex flex-1">
                            <h1 className="text-lg font-semibold text-gray-900">{title}</h1>
                        </div>
                    </div>
                </div>

                {/* Page content */}
                <main className="py-6">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {children}
                    </div>
                </main>
            </div>
        </div>
    );
} 