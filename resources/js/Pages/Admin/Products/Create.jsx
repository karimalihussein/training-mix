import React from 'react';
import { Head } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import Form from '@/Components/Form';

export default function ProductCreate({ categories }) {
    const fields = [
        { name: 'name', label: 'Product Name', type: 'text', required: true },
        { name: 'description', label: 'Description', type: 'textarea', required: false },
        { name: 'price', label: 'Price', type: 'number', step: '0.01', min: '0', required: true },
        { name: 'stock', label: 'Stock Quantity', type: 'number', min: '0', required: true },
        {
            name: 'category_id',
            label: 'Category',
            type: 'select',
            required: false,
            options: categories.map(cat => ({ value: cat.id, label: cat.name }))
        },
    ];

    return (
        <AdminLayout title="Create Product">
            <Head title="Create Product" />

            <div className="mb-6">
                <h1 className="text-2xl font-bold text-gray-900">Create Product</h1>
                <p className="mt-1 text-sm text-gray-600">
                    Add a new product to the inventory
                </p>
            </div>

            <div className="bg-white shadow rounded-lg p-6">
                <Form
                    method="post"
                    action="/dashboard/products"
                    fields={fields}
                    submitLabel="Create Product"
                    cancelUrl="/dashboard/products"
                />
            </div>
        </AdminLayout>
    );
} 