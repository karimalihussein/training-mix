import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import DataTable from '@/Components/DataTable';
import { PlusIcon } from '@heroicons/react/24/outline';

export default function ProductsIndex({ products }) {
    const columns = [
        { key: 'id', label: 'ID', sortable: true },
        { key: 'name', label: 'Name', sortable: true },
        { key: 'description', label: 'Description', sortable: false },
        {
            key: 'price',
            label: 'Price',
            sortable: true,
            render: (product) => `$${product.price || 0}`
        },
        {
            key: 'stock',
            label: 'Stock',
            sortable: true,
            render: (product) => (
                <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${product.stock > 10
                    ? 'bg-green-100 text-green-800'
                    : product.stock > 0
                        ? 'bg-yellow-100 text-yellow-800'
                        : 'bg-red-100 text-red-800'
                    }`}>
                    {product.stock || 0} units
                </span>
            )
        },
        {
            key: 'category_id',
            label: 'Category',
            sortable: true,
            render: (product) => product.category?.name || 'Uncategorized'
        },
        {
            key: 'created_at',
            label: 'Created',
            sortable: true,
            render: (product) => new Date(product.created_at).toLocaleDateString()
        },
    ];

    const handleDelete = (product) => {
        if (confirm(`Are you sure you want to delete ${product.name}?`)) {
            router.delete(`/dashboard/products/${product.id}`);
        }
    };

    const tableData = products.data.map(product => ({
        ...product,
        showUrl: `/dashboard/products/${product.id}`,
        editUrl: `/dashboard/products/${product.id}/edit`,
    }));

    return (
        <AdminLayout title="Products">
            <Head title="Products" />

            <div className="mb-6 flex justify-between items-center">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">Products</h1>
                    <p className="mt-1 text-sm text-gray-600">
                        Manage product inventory and details
                    </p>
                </div>
                <Link
                    href="/dashboard/products/create"
                    className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <PlusIcon className="h-4 w-4 mr-2" />
                    Add Product
                </Link>
            </div>

            <DataTable
                data={tableData}
                columns={columns}
                searchable={true}
                sortable={true}
                actions={true}
                onDelete={handleDelete}
                searchPlaceholder="Search products..."
                emptyMessage="No products found"
            />

            {/* Pagination */}
            {products.links && products.links.length > 3 && (
                <div className="mt-6 flex items-center justify-between">
                    <div className="text-sm text-gray-700">
                        Showing {products.from} to {products.to} of {products.total} results
                    </div>
                    <div className="flex space-x-2">
                        {products.links.map((link, index) => (
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