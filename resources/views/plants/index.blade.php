@extends('layouts.admin')

@section('title', 'Plants')

@section('content')
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Plant Inventory</h1>
        <a href="{{ route('plants.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded">+ Add Plant</a>
    </div>

    <div class="bg-white shadow rounded p-4">
        <table class="w-full text-left border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Name</th>
                    <th class="p-2">Category</th>
                    <th class="p-2">Unit Price</th>
                    <th class="p-2">Stock</th>
                    <th class="p-2">Created By</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($plants as $plant)
                    <tr class="border-t">
                        <td class="p-2">{{ $plant->name }}</td>
                        <td class="p-2">{{ ucfirst($plant->category) }}</td>
                        <td class="p-2">{{ number_format($plant->unit_price, 2) }}</td>
                        <td class="p-2">{{ $plant->stock_label }}</td>
                        <td class="p-2">{{ $plant->user->name }}</td>
                        <td class="p-2 flex gap-3">
                            <a href="{{ route('plants.show', $plant) }}" class="text-gray-700">View</a>
                            <a href="{{ route('plants.edit', $plant) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('plants.destroy', $plant) }}" method="POST"
                                  onsubmit="return confirm('Delete this plant?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-4 text-center text-gray-500">No plants yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $plants->links() }}</div>
    </div>
@endsection