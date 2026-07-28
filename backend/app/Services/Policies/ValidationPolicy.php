<?php

namespace App\Services\Policies;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use App\Models\Notice;


class ValidationPolicy
{
    public function validateDuplicate(
        Builder $query,
        string $field,
        string $message
    ): void {

        if ($query->exists()) {

            throw ValidationException::withMessages([
                $field => [$message]
            ]);

        }
    }

    public function validateDuplicateForUpdate(
        Builder $query,
        int $id,
        string $field,
        string $message
    ): void {

        if ($query->where('id', '!=', $id)->exists()) {

            throw ValidationException::withMessages([
                $field => [$message]
            ]);

        }
    }

    public function validateActive(
        bool $status,
        string $field,
        string $message
    ): void {

        if (! $status) {

            throw ValidationException::withMessages([
                $field => [$message]
            ]);

        }
    }

    public function fail(
        string $field,
        string $message
    ): void {

        throw ValidationException::withMessages([
            $field => [$message]
        ]);
    }

    public function validateUniqueNoticeTitle(
        string $title,
        ?int $ignoreId = null
    ): void {

        $query = Notice::where('title', $title);

        if ($ignoreId) {

            $query->where('id', '!=', $ignoreId);

        }

        if ($query->exists()) {

            throw ValidationException::withMessages([

                'title' => [
                    'This notice title already exists.',
                ],

            ]);

        }
    }
}