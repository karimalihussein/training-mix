import React, { useState } from 'react';
import { Link } from '@inertiajs/react';
import {
    MagnifyingGlassIcon,
    PencilIcon,
    TrashIcon,
    EyeIcon,
    ChevronUpIcon,
    ChevronDownIcon,
} from '@heroicons/react/24/outline';

export default function DataTable({
    data,
    columns,
    searchable = true,
    sortable = true,
    actions = true,
    onDelete = null,
    searchPlaceholder = 'Search...',
    emptyMessage = 'No data found',
}) {
    const [searchTerm, setSearchTerm] = useState('');
    const [sortField, setSortField] = useState('');
    const [sortDirection, setSortDirection] = useState('asc');

    // Filter data based on search term
    const filteredData = data.filter((item) => {
        if (!searchTerm) return true;
        return columns.some((column) => {
            const value = column.key ? item[column.key] : '';
            return value.toString().toLowerCase().includes(searchTerm.toLowerCase());
        });
    });

    // Sort data
    const sortedData = [...filteredData].sort((a, b) => {
        if (!sortField) return 0;

        const aValue = a[sortField];
        const bValue = b[sortField];

        if (sortDirection === 'asc') {
            return aValue > bValue ? 1 : -1;
        } else {
            return aValue < bValue ? 1 : -1;
        }
    });

    const handleSort = (field) => {
        if (sortField === field) {
            setSortDirection(sortDirection === 'asc' ? 'desc' : 'asc');
        } else {
            setSortField(field);
            setSortDirection('asc');
        }
    };

    const getSortIcon = (field) => {
        if (sortField !== field) {
            return <ChevronUpIcon className="h-4 w-4 text-gray-400" />;
        }
        return sortDirection === 'asc' ? (
            <ChevronUpIcon className="h-4 w-4 text-gray-900" />
        ) : (
            <ChevronDownIcon className="h-4 w-4 text-gray-900" />
        );
    };

    return (
        <div className="bg-white shadow rounded-lg">
            {/* Search Bar */}
            {searchable && (
                <div className="p-4 border-b border-gray-200">
                    <div className="relative">
                        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <MagnifyingGlassIcon className="h-5 w-5 text-gray-400" />
                        </div>
                        <input
                            type="text"
                            className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder={searchPlaceholder}
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                        />
                    </div>
                </div>
            )}

            {/* Table */}
            <div className="overflow-x-auto">
                <table className="min-w-full divide-y divide-gray-200">
                    <thead className="bg-gray-50">
                        <tr>
                            {columns.map((column) => (
                                <th
                                    key={column.key}
                                    className={`px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider ${sortable && column.sortable !== false ? 'cursor-pointer hover:bg-gray-100' : ''
                                        }`}
                                    onClick={() => sortable && column.sortable !== false && handleSort(column.key)}
                                >
                                    <div className="flex items-center space-x-1">
                                        <span>{column.label}</span>
                                        {sortable && column.sortable !== false && getSortIcon(column.key)}
                                    </div>
                                </th>
                            ))}
                            {actions && (
                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            )}
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {sortedData.length === 0 ? (
                            <tr>
                                <td
                                    colSpan={columns.length + (actions ? 1 : 0)}
                                    className="px-6 py-4 text-center text-sm text-gray-500"
                                >
                                    {emptyMessage}
                                </td>
                            </tr>
                        ) : (
                            sortedData.map((item, index) => (
                                <tr key={item.id || index} className="hover:bg-gray-50">
                                    {columns.map((column) => (
                                        <td key={column.key} className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {column.render ? column.render(item) : item[column.key]}
                                        </td>
                                    ))}
                                    {actions && (
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div className="flex items-center space-x-2">
                                                {item.showUrl && (
                                                    <Link
                                                        href={item.showUrl}
                                                        className="text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        <EyeIcon className="h-4 w-4" />
                                                    </Link>
                                                )}
                                                {item.editUrl && (
                                                    <Link
                                                        href={item.editUrl}
                                                        className="text-blue-600 hover:text-blue-900"
                                                    >
                                                        <PencilIcon className="h-4 w-4" />
                                                    </Link>
                                                )}
                                                {onDelete && (
                                                    <button
                                                        onClick={() => onDelete(item)}
                                                        className="text-red-600 hover:text-red-900"
                                                    >
                                                        <TrashIcon className="h-4 w-4" />
                                                    </button>
                                                )}
                                            </div>
                                        </td>
                                    )}
                                </tr>
                            ))
                        )}
                    </tbody>
                </table>
            </div>

            {/* Pagination Info */}
            {sortedData.length > 0 && (
                <div className="px-6 py-3 border-t border-gray-200">
                    <div className="text-sm text-gray-700">
                        Showing <span className="font-medium">{sortedData.length}</span> of{' '}
                        <span className="font-medium">{data.length}</span> results
                    </div>
                </div>
            )}
        </div>
    );
} 