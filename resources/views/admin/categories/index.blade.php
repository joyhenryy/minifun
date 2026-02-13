@extends('layouts.admin')

@section('page_title', 'Categories')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">All Categories</h2>
        <p class="text-sm text-gray-400 mt-0.5">Organize your products into groups</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-gray-800 text-white text-sm font-semibold rounded-xl transition-all duration-300">
        <i class="fas fa-plus"></i> Add Category
    </a>
</div>

{{-- Categories Table --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Name</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Slug</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Products</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Created</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-900">{{ $category->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-gray-100 px-2 py-1 rounded-lg text-gray-500">{{ $category->slug }}</code>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold">{{ $category->products_count }} items</span>
                        </td>
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $category->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200" title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? All products in this category will also be deleted.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200" title="Delete">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-tags text-xl text-gray-300"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900">No categories yet</h3>
                            <p class="text-gray-400 text-sm mt-1">Create your first category to organize products.</p>
                            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-black text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-colors">
                                <i class="fas fa-plus"></i> Add Category
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
    @endif
</div>

@endsection
