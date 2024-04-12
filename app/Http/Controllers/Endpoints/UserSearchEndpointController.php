<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Controllers\Controller;
use App\Http\Requests\Endpoints\DestroySearchRequest;
use App\Http\Requests\Endpoints\StoreSearchRequest;
use App\Http\Requests\Endpoints\UpdateSearchRequest;
use App\Models\Search;
use App\Repositories\SearchRepository;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class UserSearchEndpointController extends Controller implements HasMiddleware
{
    protected $searchRepository;

    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function store(StoreSearchRequest $request)
    {
        $this->searchRepository->saveSearch(Auth::user(), $request->all());

        return Auth::user()->load('searches')->searches;
    }

    public function update(UpdateSearchRequest $request, Search $search)
    {
        $search->title = $request->title;
        $search->frequency = $request->frequency;
        $search->wants_notification = $request->has('wants_notification');
        $search->save();

        return $request->user()->load('searches')->searches;
    }

    public function destroy(DestroySearchRequest $request, Search $search)
    {
        $search->delete();

        return $request->user()->load('searches')->searches;
    }
}
