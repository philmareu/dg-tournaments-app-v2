<?php

namespace App\Http\Controllers\Endpoints;

use App\Events\MediaSaved;
use App\Http\Requests\Endpoints\DestroyMediaRequest;
use App\Http\Requests\Endpoints\StoreMediaRequest;
use App\Http\Requests\Endpoints\UpdateMediaRequest;
use App\Models\Tournament;
use App\Models\Upload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaEndpointController extends Controller
{
    protected $upload;

    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    public function store(StoreMediaRequest $request, Tournament $tournament)
    {
        $upload = $this->upload->find($request->uploaded_id);
        $upload->update(['title' => $request->title]);

        $tournament->media()->save($upload);
        $tournament->touch();

        event(new MediaSaved($tournament));

        return $tournament->media;
    }

    public function update(UpdateMediaRequest $request, Tournament $tournament)
    {
        $tournament->media()->detach($request->id);
        $upload = $this->upload->find($request->uploaded_id);
        $upload->update(['title' => $request->title]);

        $tournament->media()->save($upload);
        $tournament->touch();

        return $tournament->media;
    }

    public function destroy(DestroyMediaRequest $request, Tournament $tournament, $uploadId)
    {
        $tournament->media()->detach($uploadId);
        $tournament->touch();

        return $tournament->media;
    }
}
