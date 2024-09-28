<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLanguage($locale)
    {
        // Validate the locale against the allowed list
        if (! in_array($locale, ['en', 'fr'])) {
            // Abort the request with a 400 status code and an error message
            abort(400, 'Invalid locale');
        }

        // Store the validated locale in the session
        session()->put('locale', $locale);

        // Redirect back to the previous page or to a default route
        return redirect()->back();
    }
}
