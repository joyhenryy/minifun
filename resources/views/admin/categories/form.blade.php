@extends('layouts.admin')

@section('page_title', isset($category) ? 'Edit Category' : 'Add Category')

@section('content')

<div class="max-w-xl">
    {{-- Back --}}
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-gray-900 mb-6 transition-colors">
        <i class="fas fa-arrow-left"></i> Back to Categories
    </a>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 lg:p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">{{ isset($category) ? 'Edit Category' : 'New Category' }}</h2>

        @if($errors->any())
            <div class="mb-6 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="space-y-6">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm transition-all duration-300" placeholder="e.g. Diecast Cars">
                <p class="text-xs text-gray-400 mt-1">A slug will be auto-generated from the name.</p>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="px-8 py-3 bg-black hover:bg-gray-800 text-white text-sm font-bold rounded-xl transition-all duration-300 hover:scale-[1.02]">
                    {{ isset($category) ? 'Update Category' : 'Create Category' }}
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition-all duration-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
