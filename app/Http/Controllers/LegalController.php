<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use Illuminate\View\View;

class LegalController extends Controller
{
    public function show(string $type): View
    {
        $doc = LegalDocument::where('type', $type)->firstOrFail();

        return view('legal.show', compact('doc'));
    }
}
