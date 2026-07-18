<?php

namespace App\Traits;

trait EncryptsRouteKey
{
    /**
     * Get the encryption key.
     */
    private static function getEncryptionKey(): string
    {
        $appKey = config('app.key');
        if (str_starts_with($appKey, 'base64:')) {
            $appKey = base64_decode(substr($appKey, 7));
        }
        return substr($appKey, 0, 16);
    }

    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        $id = $this->getKey();
        if (is_null($id)) {
            return '';
        }
        $key = self::getEncryptionKey();
        $encrypted = openssl_encrypt((string) $id, 'AES-128-ECB', $key);
        return str_replace(['+', '/', '='], ['-', '_', ''], $encrypted);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if (is_numeric($value)) {
            return $this->where($field ?? $this->getRouteKeyName(), $value)->firstOrFail();
        }

        $base64 = str_replace(['-', '_'], ['+', '/'], $value);
        $padding = strlen($base64) % 4;
        if ($padding) {
            $base64 .= str_repeat('=', 4 - $padding);
        }

        $key = self::getEncryptionKey();
        $decrypted = openssl_decrypt($base64, 'AES-128-ECB', $key);

        if ($decrypted === false) {
            abort(404);
        }

        return $this->where($field ?? $this->getRouteKeyName(), $decrypted)->firstOrFail();
    }
}
