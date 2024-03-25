<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage; // Storage ファサードを追加
use Illuminate\Http\UploadedFile;

class ExampleTest extends TestCase
{
    public function testFileUpload()
    {
        $file = new UploadedFile('path_to_test_file.jpg', 'test_file.jpg');
        
        // ファイルを public/storage ディレクトリにアップロード
        Storage::disk('public')->putFileAs('path/to/storage', $file, 'test_file.jpg');
        
        // その後のテストコードをここに追加
    }
}
