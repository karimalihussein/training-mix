import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import DataTable from '@/Components/DataTable';
import { PlusIcon } from '@heroicons/react/24/outline';

export default function UsersIndex({ users }) {
    const columns = [
        { key: 'id', label: 'ID', sortable: true },
        { key: 'name', label: 'Name', sortable: true },
        { key: 'email', label: 'Email', sortable: true },
        {
            key: 'email_verified_at',
            label: 'Verified',
            sortable: true,
            render: (user) => (
                <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${user.email_verified_at
                    ? 'bg-green-100 text-green-800'
                    : 'bg-red-100 text-red-800'
                    }`}>
                    {user.email_verified_at ? 'Verified' : 'Unverified'}
                </span>
            )
        },
        {
            key: 'created_at',
            label: 'Joined',
            sortable: true,
            render: (user) => new Date(user.created_at).toLocaleDateString()
        },
        {
            key: 'balance',
            label: 'Balance',
            sortable: true,
            render: (user) => `$${user.balance || 0}`
        },
    ];

    const handleDelete = (user) => {
        if (confirm(`Are you sure you want to delete ${user.name}?`)) {
            router.delete(`/dashboard/users/${user.id}`);
        }
    };

    const tableData = users.data.map(user => ({
        ...user,
        showUrl: `/dashboard/users/${user.id}`,
        editUrl: `/dashboard/users/${user.id}/edit`,
    }));

    return (
        <AdminLayout title="Users">
            <Head title="Users" />

            <div className="mb-6 flex justify-between items-center">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">Users</h1>
                    <p className="mt-1 text-sm text-gray-600">
                        Manage user accounts and permissions
                    </p>
                </div>
                <Link
                    href="/dashboard/users/create"
                    className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <PlusIcon className="h-4 w-4 mr-2" />
                    Add User
                </Link>
            </div>

            <DataTable
                data={tableData}
                columns={columns}
                searchable={true}
                sortable={true}
                actions={true}
                onDelete={handleDelete}
                searchPlaceholder="Search users..."
                emptyMessage="No users found"
            />

            {/* Pagination */}
            {users.links && users.links.length > 3 && (
                <div className="mt-6 flex items-center justify-between">
                    <div className="text-sm text-gray-700">
                        Showing {users.from} to {users.to} of {users.total} results
                    </div>
                    <div className="flex space-x-2">
                        {users.links.map((link, index) => (
                            <Link
                                key={index}
                                href={link.url}
                                className={`px-3 py-2 text-sm font-medium rounded-md ${link.active
                                    ? 'bg-indigo-600 text-white'
                                    : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'
                                    } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ))}
                    </div>
                </div>
            )}
        </AdminLayout>
    );
} 