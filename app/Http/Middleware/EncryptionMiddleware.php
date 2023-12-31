<?php

namespace App\Http\Middleware;

use App\Http\Services\EncryptionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\RSA;

class EncryptionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $encryptionService = new EncryptionService();
        $decrypted = $encryptionService->decrypt(base64_decode($request->data));
        $request->request->add(json_decode($decrypted, true));

        // Call the next middleware in the chain.
        $response = $next($request);

        $response->setContent(base64_encode($encryptionService->encrypt($response->getContent())));
        return $response;
    }
}
