<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, config('app.available_locales', ['id', 'en']), true), 404);

        session(['locale' => $locale]);

        return back();
    }
}
