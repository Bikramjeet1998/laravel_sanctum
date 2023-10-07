<?php

namespace App\Http\Services;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\RSA;

class EncryptionService
{
    /**
     * @param $data
     * @return mixed
     * @throws FileNotFoundException
     */
    public function encrypt($data)
    {
        $publicKeyPath = 'keys/public.pem';
        if (Storage::disk('local')->exists($publicKeyPath)) {
            $publicKey = RSA::load(
                Storage::disk('local')->get($publicKeyPath)
            );
            return $publicKey->encrypt($data);
        } else {
            throw new FileNotFoundException();
        }

    }

    /**
     * @param $ciphertext
     * @return mixed
     * @throws FileNotFoundException
     */
    public function decrypt($ciphertext)
    {
        $privateKeyPath = 'keys/private.pem';
        if (Storage::disk('local')->exists($privateKeyPath)) {
            $privateKey = RSA::load(
                Storage::disk('local')->get($privateKeyPath)
            );
            return $privateKey->decrypt($ciphertext);
        } else {
            throw new FileNotFoundException();
        }
    }
}
