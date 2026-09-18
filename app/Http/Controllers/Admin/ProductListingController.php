<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductListingController extends Controller
{
    public function index()
    {
        $listings = ProductListing::latest()->get();

        return view('admin.product-listings.index', compact('listings'));
    }

    public function publicIndex(Request $request)
    {
        $query = ProductListing::where('is_active', true)->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $listings = $query->paginate(12)->withQueryString();

        $categories = ProductListing::where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('guest.product-listings', compact('listings', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'category' => ['nullable', 'string', 'max:100'],
            'contact_info' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product-listings', 'public');
        }

        $validated['posted_by'] = auth()->id();

        ProductListing::create($validated);

        return back()->with('success', 'Info jual-beli berhasil ditambahkan.');
    }

    public function update(Request $request, ProductListing $productListing): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'category' => ['nullable', 'string', 'max:100'],
            'contact_info' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($productListing->image) {
                Storage::disk('public')->delete($productListing->image);
            }
            $validated['image'] = $request->file('image')->store('product-listings', 'public');
        }

        $productListing->update($validated);

        return back()->with('success', 'Info jual-beli berhasil diperbarui.');
    }

    public function destroy(ProductListing $productListing): RedirectResponse
    {
        if ($productListing->image) {
            Storage::disk('public')->delete($productListing->image);
        }

        $productListing->delete();

        return back()->with('success', 'Info jual-beli berhasil dihapus.');
    }
}
