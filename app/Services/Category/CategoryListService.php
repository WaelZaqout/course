<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryListService
{
    public function execute(Request $request): LengthAwarePaginator
    {
        return Category::query()
            ->with(['parent'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->search($request->q);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // 🔥 مهم جدًا
    }
}
