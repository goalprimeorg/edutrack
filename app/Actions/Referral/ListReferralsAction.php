<?php

namespace App\Actions\Referral;

use App\Models\Referral;

class ListReferralsAction
{
    public function __construct(
        private Referral $Referral
    ) {}

    public function execute(array $listReferralsRecordOptions, array $relationships = [])
    {
        $perPage = $listReferralsRecordOptions['per_page'] ?? 100;
        $schoolId = $listReferralsRecordOptions['school_id'] ?? null;
        $studentId = $listReferralsRecordOptions['student_id'] ?? null;
        $userId = $listReferralsRecordOptions['user_id'] ?? null;

        return $this->Referral->with($relationships)->when($schoolId, function ($model, $schoolId) {
            $model->where([
                'school_id' => $schoolId,
            ]);
        })->when($studentId, function ($model, $studentId) {
            $model->where([
                'student_id' => $studentId,
            ]);
        })->when($userId, function ($model, $userId) {
            $model->where([
                'user_id' => $userId,
            ]);
        })->paginate($perPage);
    }
}
