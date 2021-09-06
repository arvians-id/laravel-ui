<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $filename)
    {
        $path = 'images/' . $filename;
        if (!Storage::exists($path)) {
            abort(404);
        }

        return Storage::response($path);
    }
}
