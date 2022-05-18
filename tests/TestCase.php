<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function uploadFile()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg', 500, 500)->size(100);
        return $file;
    }
}
