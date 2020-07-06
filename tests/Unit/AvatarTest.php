<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->json('POST', '/avatar', ['avatar' => $file,]);

        // 断言文件已经存储 . . .
        Storage::disk('avatars')->assertExists($file->hashName());

        // 断言文件不存在 . . .
        Storage::disk('avatars')->assertMissing('missing.jpg');
    }
}
