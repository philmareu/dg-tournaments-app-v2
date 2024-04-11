<?php

namespace App\Http\Controllers\Endpoints;

use App\Http\Requests\Endpoints\Tournament\StoreSponsorRequest;
use App\Http\Requests\Endpoints\Tournament\UpdateSponsorRequest;
use App\Http\Requests\Manager\DestroySponsorRequest;
use App\Models\Sponsor;
use App\Models\Upload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class UserSponsorsEndpointController extends Controller implements HasMiddleware
{
    protected $sponsor;

    protected $upload;

    public function __construct(Sponsor $sponsor, Upload $upload)
    {
        $this->sponsor = $sponsor;
        $this->upload = $upload;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function list(Request $request)
    {
        return $request->user()->sponsors->load('logo');
    }

    public function store(StoreSponsorRequest $request)
    {
        $upload = $this->upload->find($request->upload_id);

        $sponsor = $this->sponsor->make($request->only('title', 'url'));
        $sponsor->logo()->associate($upload);
        $sponsor->user()->associate(Auth::user());
        $sponsor->save();

        return $request->user()->sponsors->load('logo');
    }

    public function update(UpdateSponsorRequest $request, Sponsor $sponsor)
    {
        if($request->has('upload_id'))
        {
            $upload = $this->upload->find($request->upload_id);
            $sponsor->logo()->associate($upload);
        }

        $sponsor->update($request->only('title', 'url'));

        return $request->user()->sponsors->load('logo');
    }

    public function destroy(DestroySponsorRequest $request, Sponsor $sponsor)
    {
        $sponsor->delete();

        return auth()->user()->sponsors->load('logo');
    }
}
