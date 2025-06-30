<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\Authentication;

use App\Actions\SchoolStaff\GetSchoolStaffByEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\Authentication\AuthenticationRequest;
use App\Http\Resources\Api\SchoolStaff\V1\Authentication\SuccessfulAuthenticationResource;
use App\InfrastructureProviders\Internal\CipherClient;

class AuthenticationController extends Controller
{
    public function __construct(
        private GetSchoolStaffByEmailAction $getSchoolStaffByEmailAction
    ) {}

    public function __invoke(AuthenticationRequest $request)
    {
        $relationships = [
            'currentClassroom'
        ];

        $schoolStaff = $this->getSchoolStaffByEmailAction->execute($request->email, $relationships);

        if (is_null($schoolStaff)) {
            return generateErrorApiMessage('Staff record does not exist', 400);
        }

        if (CipherClient::verify($request->password, $schoolStaff->password) === false) {
            return generateErrorApiMessage('Staff record does not exist', 400);
        }

        $mutatedSchoolStaffInformation = new SuccessfulAuthenticationResource($schoolStaff);

        $token = $schoolStaff->createToken('School Staff Access Token')->plainTextToken;

        $accessTokenInformation = [
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => '60 minutes',
        ];

        $responsePayload = [
            'staff_information' => $mutatedSchoolStaffInformation,
            'access_credentials' => $accessTokenInformation,
        ];

        return generateSuccessApiMessage('Staff authenticated successfully', 200, $responsePayload);
    }
}
