@extends('layouts.admin')

@section('title', 'View Plant')

@section('content')
    <h1 class="text-2xl font-bold mb-4">{{ $plant->name }}</h1>

    <div class="bg-white shadow rounded p-6 space-y-2">
        <p><strong>Category:</strong> {{ ucfirst($plant->category) }}</p>
        <p><strong>Unit Price:</strong> {{ number_format($plant->unit_price, 2) }}</p>
        <p><strong>Stock Status:</strong> {{ $plant->stock_label }}</p>
        <p><strong>Description:</strong> {{ $plant->description ?: 'N/A' }}</p>
        <p><strong>Created By:</strong> {{ $plant->user->name }}</p>
        <p><strong>Created At:</strong> {{ $plant->created_at->format('M d, Y h:i A') }}</p>
    </div>

    <a href="{{ route('plants.index') }}" class="inline-block mt-4 text-gray-600">&larr; Back</a>
@endsection