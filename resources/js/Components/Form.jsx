import React from 'react';
import { useForm, Link } from '@inertiajs/react';

export default function Form({
    method = 'post',
    action,
    initialData = {},
    fields = [],
    submitLabel = 'Save',
    cancelUrl = null,
    children
}) {
    const { data, setData, post, put, patch, delete: destroy, processing, errors, reset } = useForm(initialData);

    const handleSubmit = (e) => {
        e.preventDefault();

        if (method === 'put' || method === 'patch') {
            put(action);
        } else if (method === 'delete') {
            destroy(action);
        } else {
            post(action);
        }
    };

    const renderField = (field) => {
        const { name, label, type = 'text', required = false, options = [], ...props } = field;

        return (
            <div key={name} className="mb-4">
                <label htmlFor={name} className="block text-sm font-medium text-gray-700 mb-1">
                    {label}
                    {required && <span className="text-red-500">*</span>}
                </label>

                {type === 'textarea' ? (
                    <textarea
                        id={name}
                        name={name}
                        value={data[name] || ''}
                        onChange={(e) => setData(name, e.target.value)}
                        className={`w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm ${errors[name] ? 'border-red-300' : 'border-gray-300'
                            }`}
                        rows={4}
                        {...props}
                    />
                ) : type === 'select' ? (
                    <select
                        id={name}
                        name={name}
                        value={data[name] || ''}
                        onChange={(e) => setData(name, e.target.value)}
                        className={`w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm ${errors[name] ? 'border-red-300' : 'border-gray-300'
                            }`}
                        {...props}
                    >
                        <option value="">Select {label}</option>
                        {options.map((option) => (
                            <option key={option.value} value={option.value}>
                                {option.label}
                            </option>
                        ))}
                    </select>
                ) : type === 'checkbox' ? (
                    <div className="flex items-center">
                        <input
                            id={name}
                            name={name}
                            type="checkbox"
                            checked={data[name] || false}
                            onChange={(e) => setData(name, e.target.checked)}
                            className="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            {...props}
                        />
                        <label htmlFor={name} className="ml-2 block text-sm text-gray-900">
                            {label}
                        </label>
                    </div>
                ) : (
                    <input
                        id={name}
                        name={name}
                        type={type}
                        value={data[name] || ''}
                        onChange={(e) => setData(name, e.target.value)}
                        className={`w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm ${errors[name] ? 'border-red-300' : 'border-gray-300'
                            }`}
                        {...props}
                    />
                )}

                {errors[name] && (
                    <p className="mt-1 text-sm text-red-600">{errors[name]}</p>
                )}
            </div>
        );
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-6">
            {fields.map(renderField)}

            {children}

            <div className="flex justify-end space-x-3">
                {cancelUrl && (
                    <Link
                        href={cancelUrl}
                        className="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Cancel
                    </Link>
                )}
                <button
                    type="submit"
                    disabled={processing}
                    className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    {processing ? 'Saving...' : submitLabel}
                </button>
            </div>
        </form>
    );
} 