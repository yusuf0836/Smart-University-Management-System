<?php

namespace App\Services;

use App\Models\Routine;

class RoutineService
{
    /**
     * Store Routine
     */
    public function store(array $data): Routine
    {
        return Routine::create($data);
    }

    /**
     * Update Routine
     */
    public function update(Routine $routine, array $data): Routine
    {
        $routine->update($data);

        return $routine->fresh();
    }

    /**
     * Delete Routine
     */
    public function destroy(Routine $routine): bool
    {
        return $routine->delete();
    }
}