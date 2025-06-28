import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import {
    LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer,
    BarChart, Bar, PieChart, Pie, Cell, AreaChart, Area
} from 'recharts';
import {
    CalendarIcon,
    ChartBarIcon,
    CurrencyDollarIcon,
    UsersIcon,
    ShoppingCartIcon,
} from '@heroicons/react/24/outline';

const timeRanges = [
    { name: 'Last 7 days', value: '7d' },
    { name: 'Last 30 days', value: '30d' },
    { name: 'Last 3 months', value: '3m' },
    { name: 'Last year', value: '1y' },
];

const salesData = [
    { date: '2024-01', sales: 4000, orders: 240, users: 120 },
    { date: '2024-02', sales: 3000, orders: 139, users: 98 },
    { date: '2024-03', sales: 2000, orders: 980, users: 86 },
    { date: '2024-04', sales: 2780, orders: 390, users: 99 },
    { date: '2024-05', sales: 1890, orders: 480, users: 85 },
    { date: '2024-06', sales: 2390, orders: 380, users: 106 },
    { date: '2024-07', sales: 3490, orders: 430, users: 142 },
];

const userGrowthData = [
    { month: 'Jan', new: 65, active: 1200, total: 1200 },
    { month: 'Feb', new: 59, active: 1259, total: 1259 },
    { month: 'Mar', new: 80, active: 1339, total: 1339 },
    { month: 'Apr', new: 81, active: 1420, total: 1420 },
    { month: 'May', new: 56, active: 1476, total: 1476 },
    { month: 'Jun', new: 55, active: 1531, total: 1531 },
    { month: 'Jul', new: 40, active: 1571, total: 1571 },
];

const categoryData = [
    { name: 'Electronics', value: 400, color: '#3B82F6' },
    { name: 'Clothing', value: 300, color: '#10B981' },
    { name: 'Books', value: 200, color: '#F59E0B' },
    { name: 'Home & Garden', value: 150, color: '#EF4444' },
    { name: 'Sports', value: 100, color: '#8B5CF6' },
];

const topProducts = [
    { name: 'iPhone 15 Pro', sales: 234, revenue: 234000 },
    { name: 'MacBook Air', sales: 156, revenue: 156000 },
    { name: 'AirPods Pro', sales: 98, revenue: 19600 },
    { name: 'iPad Air', sales: 87, revenue: 43500 },
    { name: 'Apple Watch', sales: 76, revenue: 22800 },
];

export default function ReportsIndex() {
    const [selectedRange, setSelectedRange] = useState('30d');

    const stats = [
        { name: 'Total Revenue', value: '$45,678', change: '+12%', changeType: 'positive', icon: CurrencyDollarIcon },
        { name: 'Total Orders', value: '1,234', change: '+8%', changeType: 'positive', icon: ShoppingCartIcon },
        { name: 'Active Users', value: '892', change: '+15%', changeType: 'positive', icon: UsersIcon },
        { name: 'Conversion Rate', value: '3.2%', change: '+2%', changeType: 'positive', icon: ChartBarIcon },
    ];

    return (
        <AdminLayout title="Reports">
            <Head title="Reports" />

            {/* Header */}
            <div className="mb-6 flex justify-between items-center">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">Reports & Analytics</h1>
                    <p className="mt-1 text-sm text-gray-600">
                        Comprehensive insights into your business performance
                    </p>
                </div>
                <div className="flex items-center space-x-4">
                    <div className="flex items-center space-x-2">
                        <CalendarIcon className="h-5 w-5 text-gray-400" />
                        <select
                            value={selectedRange}
                            onChange={(e) => setSelectedRange(e.target.value)}
                            className="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            {timeRanges.map((range) => (
                                <option key={range.value} value={range.value}>
                                    {range.name}
                                </option>
                            ))}
                        </select>
                    </div>
                </div>
            </div>

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
                                <span className="text-gray-500"> from last period</span>
                            </div>
                        </div>
                    </div>
                ))}
            </div>

            {/* Charts Grid */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                {/* Sales Trend */}
                <div className="bg-white shadow rounded-lg p-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Sales Trend</h3>
                    <ResponsiveContainer width="100%" height={300}>
                        <AreaChart data={salesData}>
                            <CartesianGrid strokeDasharray="3 3" />
                            <XAxis dataKey="date" />
                            <YAxis />
                            <Tooltip />
                            <Area type="monotone" dataKey="sales" stroke="#3B82F6" fill="#3B82F6" fillOpacity={0.3} />
                        </AreaChart>
                    </ResponsiveContainer>
                </div>

                {/* User Growth */}
                <div className="bg-white shadow rounded-lg p-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">User Growth</h3>
                    <ResponsiveContainer width="100%" height={300}>
                        <LineChart data={userGrowthData}>
                            <CartesianGrid strokeDasharray="3 3" />
                            <XAxis dataKey="month" />
                            <YAxis />
                            <Tooltip />
                            <Line type="monotone" dataKey="total" stroke="#3B82F6" strokeWidth={2} />
                            <Line type="monotone" dataKey="active" stroke="#10B981" strokeWidth={2} />
                        </LineChart>
                    </ResponsiveContainer>
                </div>

                {/* Category Distribution */}
                <div className="bg-white shadow rounded-lg p-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Sales by Category</h3>
                    <ResponsiveContainer width="100%" height={300}>
                        <PieChart>
                            <Pie
                                data={categoryData}
                                cx="50%"
                                cy="50%"
                                labelLine={false}
                                label={({ name, percent }) => `${name} ${(percent * 100).toFixed(0)}%`}
                                outerRadius={80}
                                fill="#8884d8"
                                dataKey="value"
                            >
                                {categoryData.map((entry, index) => (
                                    <Cell key={`cell-${index}`} fill={entry.color} />
                                ))}
                            </Pie>
                            <Tooltip />
                        </PieChart>
                    </ResponsiveContainer>
                </div>

                {/* Top Products */}
                <div className="bg-white shadow rounded-lg p-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Top Products</h3>
                    <ResponsiveContainer width="100%" height={300}>
                        <BarChart data={topProducts} layout="horizontal">
                            <CartesianGrid strokeDasharray="3 3" />
                            <XAxis type="number" />
                            <YAxis dataKey="name" type="category" width={100} />
                            <Tooltip />
                            <Bar dataKey="sales" fill="#3B82F6" />
                        </BarChart>
                    </ResponsiveContainer>
                </div>
            </div>

            {/* Detailed Tables */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {/* Top Products Table */}
                <div className="bg-white shadow rounded-lg p-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Top Selling Products</h3>
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sales
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Revenue
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {topProducts.map((product, index) => (
                                    <tr key={index}>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {product.name}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {product.sales}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ${product.revenue.toLocaleString()}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>

                {/* Recent Activity */}
                <div className="bg-white shadow rounded-lg p-6">
                    <h3 className="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                    <div className="space-y-4">
                        {[
                            { action: 'New order placed', details: 'Order #1234 - $299.99', time: '2 minutes ago' },
                            { action: 'User registered', details: 'john@example.com', time: '5 minutes ago' },
                            { action: 'Product updated', details: 'iPhone 15 Pro stock updated', time: '10 minutes ago' },
                            { action: 'Payment received', details: 'Invoice #5678 - $1,299.99', time: '15 minutes ago' },
                            { action: 'Low stock alert', details: 'MacBook Air - 5 units remaining', time: '20 minutes ago' },
                        ].map((activity, index) => (
                            <div key={index} className="flex items-center space-x-3">
                                <div className="flex-shrink-0">
                                    <div className="h-2 w-2 bg-green-400 rounded-full"></div>
                                </div>
                                <div className="flex-1 min-w-0">
                                    <p className="text-sm font-medium text-gray-900">{activity.action}</p>
                                    <p className="text-sm text-gray-500">{activity.details}</p>
                                </div>
                                <div className="flex-shrink-0 text-sm text-gray-500">{activity.time}</div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
} 