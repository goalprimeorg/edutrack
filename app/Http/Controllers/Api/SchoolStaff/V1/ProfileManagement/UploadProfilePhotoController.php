<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\ProfileManagement;

use App\Actions\SchoolStaff\UpdateSchoolStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\ProfileManagement\UploadProfilePhotoRequest;
use App\InfrastructureProviders\Factory\MediaUploadFactory;

class UploadProfilePhotoController extends Controller
{
    public function __construct(
        private UpdateSchoolStaffAction $updateSchoolStaffAction,
        private MediaUploadFactory $mediaUploadFactory
    ) {}

    public function __invoke(UploadProfilePhotoRequest $request)
    {
        $loggedInStaff = auth('school-staff')->user();

        $mediaUploadDriver = $this->mediaUploadFactory->build();

        if ($mediaUploadDriver === 'error') {
            return generateErrorApiMessage('Media upload service is unavailable', 503);
        }

        $uploadResultUrl = $mediaUploadDriver->upload($request->profile_photo);

        $updateSchoolStaffData['profile_photo_url'] = $uploadResultUrl;

        $updateSchoolStaffRecordOptions['id'] = $loggedInStaff->id;
        $updateSchoolStaffRecordOptions['data'] = $updateSchoolStaffData;

        $this->updateSchoolStaffAction->execute(
            $updateSchoolStaffRecordOptions
        );

        return generateSuccessApiMessage('School profile photo upload successfully', 200);
    }
}
