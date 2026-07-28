<?php

namespace App\Services;

use App\Models\Examination;

class ExaminationService
{
    /**
     * Store Examination
     */
    public function store(array $data): Examination
    {
        return Examination::create($data);
    }

    /**
     * Update Examination
     */
    public function update(
        Examination $examination,
        array $data
    ): Examination {

        $examination->update($data);

        return $examination->fresh();
    }

    /**
     * Delete Examination
     */
    public function destroy(
        Examination $examination
    ): bool {

        return $examination->delete();
    }
}