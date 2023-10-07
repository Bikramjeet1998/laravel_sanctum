<?php

namespace App\Http\Controllers;
// include ('vendor/autoload.php');


use Illuminate\Http\Request;
use phpseclib3\Crypt\RSA;

class AsymmetricController extends Controller
{
//     function encryptData($data)
// {
//     // Replace with the actual file path to your public key
//     $publicKeyPath = 'storage/keys/public.pem';

//     // Initialize the RSA instance and load the public key
//     $rsa = new RSA();
//     $rsa->loadKey(file_get_contents($publicKeyPath));

//     // Encrypt the data
//     $encryptedData = $rsa->encrypt($data);

//     return $encryptedData;
// }


        public  function encryptData()
        {
            dd("hello");
            $publicKeyPath ='storage/keys/public.pem';
            dd(file_get_contents($publicKeyPath));
            // Initialize the RSA instance
            $rsa = new RSA();

            // Load the public key
            $rsa->loadPublicKey(file_get_contents($publicKeyPath));

            //  Encrypt the data
            //  $encryptedData = $rsa->encrypt($data);

            //  return $encryptedData;
        }




}
