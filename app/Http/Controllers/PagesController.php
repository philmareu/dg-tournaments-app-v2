<?php

namespace App\Http\Controllers;


use App\Models\Feature;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function page(Request $request, Page $page)
    {
        $page = $page->where('uri', $request->path())->first();

        return view('pages.default')
            ->with('page', $page);
    }

    public function about()
    {
        return view('pages.about.index')->withFeatures(Feature::with('image')->get());
    }

    public function tos()
    {
        return view('pages.tos');
    }

    public function privacyPolicy()
    {

    }
}
