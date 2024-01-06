<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\EncryptionService;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Personal_Access_Client;
use Nullix\CryptoJsAes\CryptoJsAes;
use OpenApi\Annotations as OA;
use Illuminate\Http\Request;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;


/**
 * @OA\Info(
 *   title="User API",
 *   version="1.0"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/users",
     *   summary="Authenticate a user and generate a token",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="client_id", type="string"),
     *       @OA\Property(property="client_secret", type="string"),
     *     )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="User authentication successful",
     *     @OA\JsonContent(
     *       @OA\Property(property="user", type="object"),
     *       @OA\Property(property="token", type="string"),
     *     )
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="User not found",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *     )
     *   )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'client_id' => 'required',
            'client_secret' => 'required',
        ]);

        $user = Personal_Access_Client::where('client_id', $request->client_id)
            ->where('client_secret', $request->client_secret)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Generate a Sanctum token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    /**
     * @OA\Get(
     *   path="/api/users",
     *   summary="Get user data",
     *   @OA\Response(
     *     response="200",
     *     description="User data retrieved successfully",
     *     @OA\JsonContent(
     *       @OA\Property(property="user", type="array", @OA\Items(type="object")),
     *     )
     *   )
     * )
     *
     * @return JsonResponse
     */
    public function userData()
    {
        // Get the user data from the user model.
        $user = User::all();

        // Return the user data as a JSON response.
        return response()->json(['user' => $user], 200);
    }

    /**
     * @OA\Post(
     *   path="/api/check",
     *   summary="Check and re-encrypt data",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="encrypted_data", type="string"),
     *     )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Data decrypted, modified, and re-encrypted",
     *     @OA\JsonContent(
     *       @OA\Property(property="re_encrypted_data", type="string"),
     *     )
     *   )
     * )
     *
     * @param Request $request
     * @return JsonResponse
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

    /**
     * @OA\Post(
     *   path="/api/verifyUser",
     *   summary="Verify a user",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="name", type="string"),
     *       @OA\Property(property="encryptedData", type="string"),
     *     )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="User verification result",
     *     @OA\JsonContent(
     *       @OA\Property(property="result", type="string"),
     *     )
     *   )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyUser(Request $request)
    {
        dd($request->name);

        // Perform user verification logic here

        return response()->json(['result' => 'User verified'], 200);
    }


        public function encryptIMEI(Request $request)
    {
        $imei = $request->input('imei');

        // Generate a new key pair
        $rsa = RSA::createKey(2048);
        
        // Extract the public and private key
        $publicKey = $rsa->getPublicKey();
        $privateKey = $rsa;

        // Encrypt the IMEI number using the public key
        $encrypted = $publicKey->encrypt($imei);

        // Use dd() to dump the keys and encrypted IMEI
        dd([
            'public_key' => $publicKey->toString('PSS'),
            'private_key' => $privateKey->toString('PSS')
           
        ]);
    }
}


