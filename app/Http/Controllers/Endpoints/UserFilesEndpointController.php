<?php

namespace App\Http\Controllers\Endpoints;

use App\Models\Upload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserFilesEndpointController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $path = $file->store('public');

        $upload = new Upload([
            'title' => $file->getClientOriginalName(),
            'filename' => $this->extractFilenameFromPath($path),
            'alt' => '',
            'mime' => $file->getClientMimeType(),
            'size' => $file->getClientSize()
        ]);

        $upload->user()->associate(Auth::user())->save();

        return $upload;
    }

    private function extractFilenameFromPath($path)
    {
        $segments = explode('/', $path);

        return end($segments);
    }
}
