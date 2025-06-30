<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\Authentication;

use App\Actions\SuperAdmin\GetSuperAdminByEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\Authentication\AuthenticationRequest;
use App\Http\Resources\Api\SuperAdmin\V1\Authentication\SuccessfulAuthenticationResource;
use App\InfrastructureProviders\Internal\CipherClient;

class AuthenticationController extends Controller
{
    public function __construct(
        private GetSuperAdminByEmailAction $getSuperAdminByEmailAction
    ) {}

    public function __invoke(AuthenticationRequest $request)
    {
        $superAdmin = $this->getSuperAdminByEmailAction->execute($request->email);

        if (is_null($superAdmin)) {
            return generateErrorApiMessage('Admin record does not exist', 400);
        }

        if (CipherClient::verify($request->password, $superAdmin->password) === false) {
            return generateErrorApiMessage('Admin record does not exist', 400);
        }

        $mutatedSuperAdminInformation = new SuccessfulAuthenticationResource($superAdmin);

        $token = $superAdmin->createToken('Super Admin Access Token')->plainTextToken;

        $accessTokenInformation = [
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => '60 minutes',
        ];

        $responsePayload = [
            'admin_information' => $mutatedSuperAdminInformation,
            'access_credentials' => $accessTokenInformation,
        ];

        return generateSuccessApiMessage('Super admin authenticated successfully', 200, $responsePayload);
    }
}
