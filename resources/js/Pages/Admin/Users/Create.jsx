import React from 'react';
import { Head } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import Form from '@/Components/Form';

export default function UserCreate() {
    const fields = [
        { name: 'name', label: 'Name', type: 'text', required: true },
        { name: 'email', label: 'Email', type: 'email', required: true },
        { name: 'password', label: 'Password', type: 'password', required: true },
        { name: 'password_confirmation', label: 'Confirm Password', type: 'password', required: true },
    ];

    return (
        <AdminLayout title="Create User">
            <Head title="Create User" />

            <div className="mb-6">
                <h1 className="text-2xl font-bold text-gray-900">Create User</h1>
                <p className="mt-1 text-sm text-gray-600">
                    Add a new user to the system
                </p>
            </div>

            <div className="bg-white shadow rounded-lg p-6">
                <Form
                    method="post"
                    action="/dashboard/users"
                    fields={fields}
                    submitLabel="Create User"
                    cancelUrl="/dashboard/users"
                />
            </div>
        </AdminLayout>
    );
} 