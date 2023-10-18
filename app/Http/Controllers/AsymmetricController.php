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
//        $data = "Bikramjeet Singh";
        $data_json =
            [
                "country_code" => "+91",
                "mobile" => "9530654704"
            ];
//        $data = \response()->json($data_json);

        $data = json_encode($data_json, true);
        $ciphertext = $this->encryptData($data);
        $finaldata =  base64_encode($ciphertext);
       dd($finaldata);

//        $plaintext = $this->decryptData($ciphertext);
//        dd(json_decode($plaintext));
//        dump("Plaintext: " . json_decode($plaintext, true));

        return json_decode($plaintext,true);
    }
}
