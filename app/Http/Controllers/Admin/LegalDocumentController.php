<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalDocumentController extends Controller
{
    public function index(): View
    {
        $documents = LegalDocument::orderBy('type', 'desc')->get();

        return view('admin.legal-documents.index', compact('documents'));
    }

    public function edit(LegalDocument $legalDocument): View
    {
        return view('admin.legal-documents.edit', ['doc' => $legalDocument]);
    }

    public function update(Request $request, LegalDocument $legalDocument): RedirectResponse
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ], [
            'title.required'   => 'Judul wajib diisi.',
            'content.required' => 'Isi dokumen wajib diisi.',
        ]);

        // Versi naik otomatis jika isi berubah, sehingga pengguna yang sedang
        // mengisi formulir diminta menyetujui ulang.
        if ($data['content'] !== $legalDocument->content) {
            $data['version'] = $legalDocument->version + 1;
        }

        $legalDocument->update($data);

        return redirect()
            ->route('admin.legal-documents.index')
            ->with('status', 'Dokumen berhasil diperbarui.');
    }
}
