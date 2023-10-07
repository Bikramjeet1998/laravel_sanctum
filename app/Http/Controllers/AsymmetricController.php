<?php

namespace App\Http\Controllers;

use App\Http\Services\EncryptionService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class AsymmetricController extends Controller
{
    private $encryptionService;

    /**
     * @param EncryptionService $encryptionService
     */
    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }

    /**
     * @param $data
     * @return mixed
     * @throws FileNotFoundException
     */
    public function encryptData($data = null)
    {
        return $this->encryptionService->encrypt($data);
    }

    /**
     * @param $ciphertext
     * @return mixed
     * @throws FileNotFoundException
     */
    public function decryptData($ciphertext = null)
    {
        return $this->encryptionService->decrypt($ciphertext);
    }

    /**
     * @return mixed
     * @throws FileNotFoundException
     */
    public function testing(){
        $data = "Bikramjeet Singh";
        $ciphertext = $this->encryptData($data);

        dump("Ciphertext: " . $ciphertext);
        $plaintext = $this->decryptData($ciphertext);

        dump("Plaintext: " . $plaintext);

        return $plaintext;
    }
}
