<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\RSA;

class AsymmetricController extends Controller
{
    /**
     * Encrypts the given data using RSA encryption.
     *
     * @return Response The encrypted data as a response.
     * @throws FileNotFoundException
     */
    public function encryptData()
    {
        $publicKeyPath = 'keys/public.pem';
        if (Storage::disk('local')->exists($publicKeyPath)) {

            $fullPathOfPublicKey = Storage::disk('local')->get($publicKeyPath);

            $publicKey = RSA::load($fullPathOfPublicKey);
            $data = 'This is the data to be encrypted.';

            $ciphertext = $publicKey->encrypt($data);

            // Return the encrypted data as a response
            return response($ciphertext, 200)
                ->header('Content-Type', 'application/x-pem-file');

        } else {
            // Handle the case where the file doesn't exist
            return response('File not found',  404);
        }
    }

}
