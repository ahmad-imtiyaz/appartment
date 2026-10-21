<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PromoBannerController extends Controller
{
    public function index(): View
    {
        $banners = PromoBanner::orderBy('sort_order')->latest()->get();

        return view('admin.promo-banners.index', compact('banners'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules(imageRequired: true), $this->messages());

        $validated['image'] = $request->file('image')->store('promo-banners', 'public');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['posted_by'] = auth()->id();

        PromoBanner::create($validated);

        return back()->with('success', 'Banner promosi berhasil ditambahkan.');
    }

    public function update(Request $request, PromoBanner $promoBanner): RedirectResponse
    {
        $validated = $request->validate($this->rules(imageRequired: false), $this->messages());

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($promoBanner->image);
            $validated['image'] = $request->file('image')->store('promo-banners', 'public');
        } else {
            unset($validated['image']);
        }

        // Checkbox yang tidak dicentang tidak dikirim browser
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $promoBanner->update($validated);

        return back()->with('success', 'Banner promosi berhasil diperbarui.');
    }

    public function destroy(PromoBanner $promoBanner): RedirectResponse
    {
        Storage::disk('public')->delete($promoBanner->image);
        $promoBanner->delete();

        return back()->with('success', 'Banner promosi berhasil dihapus.');
    }

    private function rules(bool $imageRequired): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'image' => [
                $imageRequired ? 'required' : 'nullable',
                'image',
                'max:2048',
                // rasio 3:1, minimal 900x300 supaya tetap tajam
                'dimensions:ratio=' . PromoBanner::WIDTH . '/' . PromoBanner::HEIGHT . ',min_width=900',
            ],
            'link_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ];
    }

    private function messages(): array
    {
        return [
            'image.required' => 'Gambar banner wajib diupload.',
            'image.dimensions' => 'Ukuran gambar harus ' . PromoBanner::WIDTH . ' × ' . PromoBanner::HEIGHT . ' px (rasio 3:1).',
            'image.max' => 'Ukuran file maksimal 2 MB.',
            'link_url.url' => 'Link harus berupa URL lengkap, contoh: https://wa.me/628123456789',
        ];
    }
}
