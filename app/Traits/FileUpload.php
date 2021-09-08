<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

trait FileUpload
{
    public function withDelete($path = 'storage/images', $name = 'photo')
    {
        $photo = null;

        if (request()->hasFile($name)) {
            $file = request()->file($name);

            $namePhoto = Str::uuid() . '.' . $file->extension();
            $file->move(public_path($path), $namePhoto);
            $photo = $namePhoto;

            $path = public_path($path) . '/' . Auth::user()->profile_user->photo;
            if (File::exists($path) && Auth::user()->profile_user->photo != 'default.png') {
                File::delete($path);
            }
        }
        return $photo;
    }
}
