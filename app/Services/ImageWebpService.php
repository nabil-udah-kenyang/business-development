<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class ImageWebpService
{
    public function store(UploadedFile $file, string $prefix): string
    {
        $directory = public_path('image');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = $prefix.'-'.now()->format('YmdHis').'-'.Str::random(6);

        if ($extension === 'svg') {
            $file->move($directory, $filename.'.svg');

            return 'image/'.$filename.'.svg';
        }

        $outputPath = $directory.'/'.$filename.'.webp';
        $process = new Process([
            'magick',
            $file->getRealPath(),
            '-auto-orient',
            '-quality',
            '88',
            $outputPath,
        ]);
        $process->setTimeout(60);
        $process->mustRun();

        if (! is_file($outputPath)) {
            throw new \RuntimeException('Gambar gagal dikonversi ke WebP.');
        }

        return 'image/'.$filename.'.webp';
    }
}
