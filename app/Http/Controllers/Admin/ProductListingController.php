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
        $validated = $request->validate($this->rules(), $this->messages());

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product-listings', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['posted_by'] = auth()->id();

        ProductListing::create($validated);

        return back()->with('success', 'Info jual-beli berhasil ditambahkan.');
    }

    public function update(Request $request, ProductListing $productListing): RedirectResponse
    {
        $validated = $request->validate($this->rules(), $this->messages());

        if ($request->hasFile('image')) {
            if ($productListing->image) {
                Storage::disk('public')->delete($productListing->image);
            }
            $validated['image'] = $request->file('image')->store('product-listings', 'public');
        }

        // Checkbox yang tidak dicentang tidak dikirim browser, jadi harus dibaca manual
        $validated['is_active'] = $request->boolean('is_active');

        // Jika harga dikosongkan, pastikan price_max ikut kosong
        if (empty($validated['price'])) {
            $validated['price_max'] = null;
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

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0', 'required_with:price_max'],
            'price_max' => ['nullable', 'numeric', 'min:0', 'gte:price'],
            'image' => ['nullable', 'image', 'max:2048'],
            'category' => ['nullable', 'string', 'max:100'],
            'contact_info' => ['required', 'string', 'max:255'],
        ];
    }

    private function messages(): array
    {
        return [
            'price.required_with' => 'Harga minimum wajib diisi jika harga maksimum diisi.',
            'price_max.gte' => 'Harga maksimum harus lebih besar atau sama dengan harga minimum.',
        ];
    }
}
