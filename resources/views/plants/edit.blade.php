@extends('layouts.admin')

@section('title', 'Edit Plant')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Plant</h1>

    <form method="POST" action="{{ route('plants.update', $plant) }}" class="bg-white shadow rounded p-6">
        @csrf
        @method('PUT')
        @include('plants._form')
        <button class="px-4 py-2 bg-gray-800 text-white rounded">Update</button>
        <a href="{{ route('plants.index') }}" class="ml-3 text-gray-600">Cancel</a>
    </form>
@endsection