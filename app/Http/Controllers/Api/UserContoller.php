<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Personal_Access_Client;
use Nullix\CryptoJsAes\CryptoJsAes;

class UserContoller extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    function index(Request $request): JsonResponse
    {
        $request->validate([
            'client_id' => 'required',
            'client_secret' => 'required',
        ]);

        $user = Personal_Access_Client::where('client_id', $request->client_id)
            ->where('client_secret',$request->client_secret)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Generate a Sanctum token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function login(){
               return view('check');
            }

    public function userData()
    {
        
        // Get the user data from the user model.
        $user = User::all();


        // Return the user data as a JSON response.
        return response()->json(['user' => $user], 200);
    }



// ------------------------if we retun an new message as array in json-------------------------------------



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



// -------------------If we merge two array ------------------

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
