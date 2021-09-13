<?php

namespace App\Traits;

use App\Models\FileTemp;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

trait FilePond
{
    public function moveFileFromTemp($name, $target = 'storage/images/')
    {
        $photo = FileTemp::where('user_id', Auth::id())->where('name', $name)->first();
        if ($photo) {
            $tempPath = public_path('storage/temp/' . $photo->folder . '/' . $photo->filename);
            if (File::exists($tempPath)) {
                $newPath = public_path($target . $photo->filename);
                File::copy($tempPath, $newPath);
                File::deleteDirectory('storage/temp/' . $photo->folder);

                if ($name == 'update-profile') {
                    $this->deleteUserImageBefore($target);
                }

                $photo->delete();
                return $photo->filename;
            }
        }
        return Auth::user()->profile_user->photo;
    }
    private function deleteUserImageBefore($target)
    {
        $oldPath = public_path($target . Auth::user()->profile_user->photo);
        if (File::exists($oldPath) && Auth::user()->profile_user->photo != 'default.png') {
            File::delete($oldPath);
        }
    }
    public function process($name)
    {
        $file = request()->file('photo');

        $namePhoto = Str::uuid() . '.' . $file->extension();
        $folder = Str::uuid();
        $path =  public_path('storage/temp/' . $folder);

        $file->move($path, $namePhoto);
        $photo = $namePhoto;

        FileTemp::updateOrCreate(
            ['user_id' => Auth::id(), 'name' => $name],
            ['folder' => $folder, 'filename' => $namePhoto]
        );

        return $photo;
    }
    public function revert($name)
    {
        $photo = FileTemp::where('user_id', Auth::id())->where('name', $name)->latest()->first();

        if ($photo) {
            $tempPath = public_path('storage/temp/' . $photo->folder);
            File::deleteDirectory($tempPath);

            $photo->delete();
        }
    }
}
