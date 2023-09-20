<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Nullix\CryptoJsAes\CryptoJsAes;

class UserContoller extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    function index(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'imei' => 'required',
        ]);

        $user = User::where('mobile', $request->mobile)
            ->where('imei', $request->imei)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Generate a Sanctum token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }


    /**
     * @return Application|Factory|View
     */
//   public function check()
//    {
////        $originalValue = ["We do encrypt an array", "123", ['nested']]; // this could be any value
////        $password = "Bikram";
////        $encrypted = CryptoJsAes::encrypt($originalValue, $password);
////
////       // decrypt
//////        $encrypted = '{"ct":"g9uYq0DJypTfiyQAspfUCkf+\/tpoW4DrZrpw0Tngrv10r+\/yeJMeseBwDtJ5gTnx","iv":"c8fdc314b9d9acad7bea9a865671ea51","s":"7e61a4cd341279af"}';
//////        $password = "123456";
////        $decrypted = CryptoJsAes::decrypt($encrypted, $password);
////
////        echo "Encrypted: " . $encrypted . "\n";
////        echo "Decrypted: " . print_r($decrypted, true) . "\n";
//
//       // show thw output  with the View
//
//        // Original data to be encrypted
//         $originalValue = ["Yes im a Developer", "123", ['nested']];
//
//
//        // Password for encryption and decryption
//        $password = "Bikram";
//
//        // Encrypt the data
//        $encrypted = CryptoJsAes::encrypt(json_encode($originalValue), $password);
////        $password = "123456";
//        // Decrypt the data
//        $decrypted = json_decode(CryptoJsAes::decrypt($encrypted, $password), true);
//
//        return view('check', compact('originalValue', 'encrypted', 'decrypted'));
//
//
//
//    }


    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function check(Request $request)
    {
        // Check if the request is an Ajax request
        if ($request->ajax()) {
            // Get the encrypted data from the request
            $encryptedData = $request->input('encrypted_data');
            // Password for decryption and re-encryption
            $password = "123456";

            // Decrypt the received data
            $decrypted = CryptoJsAes::decrypt($encryptedData, $password);
            $decryptedDataArray = json_decode($decrypted, true);
            //dd($decryptedDataArray);
            // Additional data to add
            $mergedData = [
                'message' => 'Data successfully decrypted, additional data added, and re-encrypted.',
                'extra' => 'This is some additional information added to the decrypted data.'
            ];

            // Encrypt the data again, including the additional data
            $reEncrypted = CryptoJsAes::encrypt(json_encode($mergedData), $password);


            // Return the re-encrypted data as JSON
            return response()->json(['re_encrypted_data' => $reEncrypted]);
        }

        // If it's not an Ajax request, return a view with the form or handle non-Ajax behavior.
        return view('check');
    }




    public function login(){
               return view('check');
            }

//    /**
//     * @param Request $request
//     * @return Application|Factory|View|JsonResponse
//     */
//    public function check(Request $request)
//    {
//        // Check if the request is an Ajax request
//        if ($request->ajax()) {
//            // Get the encrypted data from the request
//            $encryptedData = $request->input('encrypted_data');
//            // Password for decryption and re-encryption
//            $password = "123456";
//
//            // Decrypt the received data
//            $decrypted = CryptoJsAes::decrypt($encryptedData, $password);
//            $decryptedDataArray = json_decode($decrypted, true);
//
//            // Additional data to add
//            $additionalData = [
//                'message' => 'Data successfully decrypted.',
//                'extra' => 'This is some additional information.'
//            ];
//
//            // Merge the decrypted data with the additional data
//            $mergedData = array_merge($decryptedDataArray, $additionalData);
//
//            // Encrypt the merged data
//            $reEncrypted = CryptoJsAes::encrypt(json_encode($mergedData), $password);
//
//            // Return both the merged and re-encrypted data as JSON
//            return response()->json(['merged_and_re_encrypted_data' => $reEncrypted]);
//        }
//
//        // If it's not an Ajax request, return a view with the form or handle non-Ajax behavior.
//        return view('check');
//    }


}
