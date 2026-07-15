<?php

namespace App\Services;

use App\Models\AcademicSession;
use Illuminate\Support\Facades\DB;

class AcademicSessionService
{
    /**
     * Create Academic Session
     */
    public function store(array $data): AcademicSession
    {
        return DB::transaction(function () use ($data) {

            if ($data['is_current']) {
                AcademicSession::query()
                    ->update([
                        'is_current' => false,
                    ]);
            }

            return AcademicSession::create($data);
        });
    }

    /**
     * Update Academic Session
     */
    public function update(
        AcademicSession $academicSession,
        array $data
    ): AcademicSession {

        return DB::transaction(function () use ($academicSession, $data) {

            if ($data['is_current']) {
                AcademicSession::query()
                    ->whereKeyNot($academicSession->id)
                    ->update([
                        'is_current' => false,
                    ]);
            }

            $academicSession->update($data);

            return $academicSession->fresh();
        });
    }

    /**
     * Delete Academic Session
     */
    public function destroy(
        AcademicSession $academicSession
    ): void {

        if ($academicSession->is_current) {
            abort(422, 'Current academic session cannot be deleted.');
        }

        $academicSession->delete();
    }
}