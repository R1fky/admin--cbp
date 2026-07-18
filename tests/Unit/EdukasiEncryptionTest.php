<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Edukasi;

class EdukasiEncryptionTest extends TestCase
{
    public function test_edukasi_route_key_is_encrypted()
    {
        $edukasi = new Edukasi();
        $edukasi->id = 10;

        $routeKey = $edukasi->getRouteKey();

        $this->assertNotEmpty($routeKey);
        $this->assertNotEquals(10, $routeKey);
        $this->assertStringNotContainsString('/', $routeKey);
        $this->assertStringNotContainsString('+', $routeKey);
        $this->assertStringNotContainsString('=', $routeKey);
    }

    public function test_edukasi_decrypts_route_key_correctly()
    {
        $edukasi = new Edukasi();
        $edukasi->id = 10;

        $routeKey = $edukasi->getRouteKey();

        // Let's check decryption manually by mimicking the process
        $base64 = str_replace(['-', '_'], ['+', '/'], $routeKey);
        $padding = strlen($base64) % 4;
        if ($padding) {
            $base64 .= str_repeat('=', 4 - $padding);
        }

        $appKey = config('app.key');
        if (str_starts_with($appKey, 'base64:')) {
            $appKey = base64_decode(substr($appKey, 7));
        }
        $key = substr($appKey, 0, 16);

        $decrypted = openssl_decrypt($base64, 'AES-128-ECB', $key);

        $this->assertEquals(10, $decrypted);
    }

    public function test_edukasi_resolve_route_binding_aborts_for_invalid_key()
    {
        $edukasi = new Edukasi();

        try {
            $edukasi->resolveRouteBinding('invalid-encrypted-key-here');
            $this->fail('Expected HttpException not thrown');
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            $this->assertEquals(404, $e->getStatusCode());
        }
    }
}
