import React from 'react';
import { Head } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import {
    UsersIcon,
    CubeIcon,
    DocumentTextIcon,
    ReceiptPercentIcon,
    ShoppingCartIcon,
    BuildingOfficeIcon,
    EyeIcon,
    ArrowTrendingUpIcon,
} from '@heroicons/react/24/outline';
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer, BarChart, Bar, PieChart, Pie, Cell } from 'recharts';

const stats = [
    { name: 'Total Users', value: '1,234', icon: UsersIcon, change: '+12%', changeType: 'positive' },
    { name: 'Products', value: '567', icon: CubeIcon, change: '+8%', changeType: 'positive' },
    { name: 'Articles', value: '89', icon: DocumentTextIcon, change: '+15%', changeType: 'positive' },
    { name: 'Invoices', value: '456', icon: ReceiptPercentIcon, change: '+5%', changeType: 'positive' },
    { name: 'Orders', value: '234', icon: ShoppingCartIcon, change: '+20%', changeType: 'positive' },
    { name: 'Offices', value: '12', icon: BuildingOfficeIcon, change: '+2%', changeType: 'positive' },
    { name: 'Visits', value: '3,456', icon: EyeIcon, change: '+18%', changeType: 'positive' },
    { name: 'Revenue', value: '$45,678', icon: ArrowTrendingUpIcon, change: '+25%', changeType: 'positive' },
];

const chartData = [
    { name: 'Jan', users: 400, revenue: 2400, orders: 2400 },
    { name: 'Feb', users: 300, revenue: 1398, orders: 2210 },
    { name: 'Mar', users: 200, revenue: 9800, orders: 2290 },
    { name: 'Apr', users: 278, revenue: 3908, orders: 2000 },
    { name: 'May', users: 189, revenue: 4800, orders: 2181 },
    { name: 'Jun', users: 239, revenue: 3800, orders: 2500 },
    { name: 'Jul', users: 349, revenue: 4300, orders: 2100 },
];

const pieData = [
    { name: 'Users', value: 400, color: '#3B82F6' },
    { name: 'Products', value: 300, color: '#10B981' },
    { name: 'Orders', value: 200, color: '#F59E0B' },
    { name: 'Revenue', value: 100, color: '#EF4444' },
];

export default function Dashboard({ auth }) {
    return (
        <AdminLayout title="Dashboard">
            <Head title="Dashboard" />

            {/* Stats Grid */}
            <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                {stats.map((item) => (
                    <div key={item.name} className="bg-white overflow-hidden shadow rounded-lg">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <item.icon className="h-6 w-6 text-gray-400" />
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="text-sm font-medium text-gray-500 truncate">{item.name}</dt>
                                        <dd className="text-lg font-medium text-gray-900">{item.value}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div className="bg-gray-50 px-5 py-3">
                            <div className="text-sm">
                                <span className={`font-medium ${item.changeType === 'positive' ? 'text-green-600' : 'text-red-600'
                                    }`}>
                                    {item.change}
                                </span>
                                <span className="text-gray-500"> from last month</span>
                            </div>
                        </div>
                    </div>
                ))}
            </div>

            {/* Charts Grid */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {/* Line Chart */}
                <div className="bg-white shadow rounded-lg p-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Revenue & Orders Trend</h3>
                    <ResponsiveContainer width="100%" height={300}>
                        <LineChart data={chartData}>
                            <CartesianGrid strokeDasharray="3 3" />
                            <XAxis dataKey="name" />
                            <YAxis />
                            <Tooltip />
                            <Line type="monotone" dataKey="revenue" stroke="#3B82F6" strokeWidth={2} />
                            <Line type="monotone" dataKey="orders" stroke="#10B981" strokeWidth={2} />
                        </LineChart>
                    </ResponsiveContainer>
                </div>

                {/* Bar Chart */}
                <div className="bg-white shadow rounded-lg p-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">User Growth</h3>
                    <ResponsiveContainer width="100%" height={300}>
                        <BarChart data={chartData}>
                            <CartesianGrid strokeDasharray="3 3" />
                            <XAxis dataKey="name" />
                            <YAxis />
                            <Tooltip />
                            <Bar dataKey="users" fill="#3B82F6" />
                        </BarChart>
                    </ResponsiveContainer>
                </div>

                {/* Pie Chart */}
                <div className="bg-white shadow rounded-lg p-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Resource Distribution</h3>
                    <ResponsiveContainer width="100%" height={300}>
                        <PieChart>
                            <Pie
                                data={pieData}
                                cx="50%"
                                cy="50%"
                                labelLine={false}
                                label={({ name, percent }) => `${name} ${(percent * 100).toFixed(0)}%`}
                                outerRadius={80}
                                fill="#8884d8"
                                dataKey="value"
                            >
                                {pieData.map((entry, index) => (
                                    <Cell key={`cell-${index}`} fill={entry.color} />
                                ))}
                            </Pie>
                            <Tooltip />
                        </PieChart>
                    </ResponsiveContainer>
                </div>

                {/* Recent Activity */}
                <div className="bg-white shadow rounded-lg p-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                    <div className="space-y-4">
                        {[
                            { action: 'New user registered', time: '2 minutes ago', user: 'john@example.com' },
                            { action: 'Order completed', time: '5 minutes ago', user: 'Order #1234' },
                            { action: 'Product updated', time: '10 minutes ago', user: 'iPhone 15 Pro' },
                            { action: 'Invoice generated', time: '15 minutes ago', user: 'Invoice #5678' },
                            { action: 'Office visit logged', time: '20 minutes ago', user: 'Office A' },
                        ].map((activity, index) => (
                            <div key={index} className="flex items-center space-x-3">
                                <div className="flex-shrink-0">
                                    <div className="h-2 w-2 bg-green-400 rounded-full"></div>
                                </div>
                                <div className="flex-1 min-w-0">
                                    <p className="text-sm font-medium text-gray-900">{activity.action}</p>
                                    <p className="text-sm text-gray-500">{activity.user}</p>
                                </div>
                                <div className="flex-shrink-0 text-sm text-gray-500">{activity.time}</div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>

            {/* Quick Actions */}
            <div className="mt-8 bg-white shadow rounded-lg p-6">
                <h3 className="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                    {[
                        { name: 'Add User', href: '/dashboard/users/create', icon: UsersIcon },
                        { name: 'Add Product', href: '/dashboard/products/create', icon: CubeIcon },
                        { name: 'Create Article', href: '/dashboard/articles/create', icon: DocumentTextIcon },
                        { name: 'Generate Report', href: '/dashboard/reports', icon: ArrowTrendingUpIcon },
                    ].map((action) => (
                        <a
                            key={action.name}
                            href={action.href}
                            className="group relative rounded-lg p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <div className="flex items-center">
                                <action.icon className="h-6 w-6 text-gray-400 group-hover:text-indigo-600" />
                                <span className="ml-3 text-sm font-medium text-gray-900">{action.name}</span>
                            </div>
                        </a>
                    ))}
                </div>
            </div>
        </AdminLayout>
    );
} 