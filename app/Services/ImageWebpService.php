<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageWebpService
{
    public function store(UploadedFile $file, string $prefix): string
    {
        $directory = public_path('image');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Keep the original file instead of invoking ImageMagick. Shared
        // hosting providers commonly do not expose the `magick` binary.
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = $prefix.'-'.now()->format('YmdHis').'-'.Str::random(6);
        $relativePath = 'image/'.$filename.'.'.$extension;

        try {
            $file->move($directory, $filename.'.'.$extension);
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Gambar gagal disimpan. Pastikan folder public/image dapat ditulis oleh PHP.', 0, $exception);
        }

        return $relativePath;
    }
}
