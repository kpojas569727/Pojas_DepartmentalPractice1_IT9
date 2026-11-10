@extends('layouts.admin')

@section('title', 'Plant Reports')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Plant Reports</h1>

    {{-- Filter form (GET, so the filters appear in the URL and carry to the exports) --}}
    <form method="GET" action="{{ route('reports.plants') }}" class="bg-white shadow rounded p-4 mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-medium">Report</label>
            <select name="type" class="border rounded p-2">
                @foreach ($types as $value => $label)
                    <option value="{{ $value }}" @selected(request('type', 'price_list') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Category</label>
            <select name="category" class="border rounded p-2">
                <option value="">All</option>
                @foreach (App\Models\Plant::CATEGORIES as $cat)
                    <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Stock Status</label>
            <select name="stock_status" class="border rounded p-2">
                <option value="">All</option>
                @foreach (App\Models\Plant::STATUSES as $value => $label)
                    <option value="{{ $value }}" @selected(request('stock_status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <button class="px-4 py-2 bg-gray-800 text-white rounded">Apply</button>

        {{-- request()->query() passes the current filters to the exports --}}
        <a href="{{ route('reports.plants.pdf', request()->query()) }}" class="px-4 py-2 bg-red-600 text-white rounded">Export PDF</a>
        <a href="{{ route('reports.plants.csv', request()->query()) }}" class="px-4 py-2 bg-green-600 text-white rounded">Export CSV</a>
    </form>

    <div class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-3">{{ $title }} ({{ $plants->count() }} records)</h2>

        <table class="w-full text-left border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Name</th>
                    <th class="p-2">Category</th>
                    <th class="p-2">Unit Price</th>
                    <th class="p-2">Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($plants as $plant)
                    <tr class="border-t">
                        <td class="p-2">{{ $plant->name }}</td>
                        <td class="p-2">{{ ucfirst($plant->category) }}</td>
                        <td class="p-2">{{ number_format($plant->unit_price, 2) }}</td>
                        <td class="p-2">{{ $plant->stock_label }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-4 text-center text-gray-500">No records match the filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection