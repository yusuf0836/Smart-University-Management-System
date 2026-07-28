<?php

namespace App\Services;

use App\Models\Notice;
use App\Services\Policies\ValidationPolicy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NoticeService
{
    public function __construct(
        protected ValidationPolicy $validationPolicy
    ) {}

    public function getAll(): Collection
    {
        return Notice::with('creator')
            ->latest()
            ->get();
    }

    public function getById(int $id): Notice
    {
        return Notice::with('creator')
            ->findOrFail($id);
    }

    public function store(array $data): Notice
    {
        DB::beginTransaction();

        try {

            $this->validationPolicy
                ->validateUniqueNoticeTitle(
                    $data['title']
                );

            if (
                isset($data['attachment']) &&
                $data['attachment'] instanceof UploadedFile
            ) {

                $data['attachment'] = $data['attachment']
                    ->store('notices', 'public');

            }

            $data['created_by'] = auth()->id();

            $notice = Notice::create($data);

            DB::commit();

            return $notice;

        } catch (\Throwable $exception) {

            DB::rollBack();

            throw $exception;

        }
    }

    public function update(
        int $id,
        array $data
    ): Notice {

        DB::beginTransaction();

        try {

            $notice = Notice::findOrFail($id);

            $this->validationPolicy
                ->validateUniqueNoticeTitle(
                    $data['title'],
                    $id
                );

            if (
                isset($data['attachment']) &&
                $data['attachment'] instanceof UploadedFile
            ) {

                if (
                    $notice->attachment &&
                    Storage::disk('public')->exists($notice->attachment)
                ) {

                    Storage::disk('public')
                        ->delete($notice->attachment);

                }

                $data['attachment'] = $data['attachment']
                    ->store('notices', 'public');
            }

            $notice->update($data);

            DB::commit();

            return $notice;

        } catch (\Throwable $exception) {

            DB::rollBack();

            throw $exception;

        }
    }

    public function delete(int $id): void
    {
        $notice = Notice::findOrFail($id);

        if (
            $notice->attachment &&
            Storage::disk('public')->exists($notice->attachment)
        ) {

            Storage::disk('public')
                ->delete($notice->attachment);

        }

        $notice->delete();
    }

    public function restore(int $id): Notice
    {
        $notice = Notice::onlyTrashed()
            ->findOrFail($id);

        $notice->restore();

        return $notice;
    }

    public function getPublished(): Collection
    {
        return Notice::published()
            ->active()
            ->latest('publish_date')
            ->get();
    }

    public function getPinned(): Collection
    {
        return Notice::published()
            ->active()
            ->pinned()
            ->latest('publish_date')
            ->get();
    }

    public function getByAudience(
        string $audience
    ): Collection {

        return Notice::published()

            ->active()

            ->where(function ($query) use ($audience) {

                $query->where('audience', 'All')

                    ->orWhere('audience', $audience);

            })

            ->latest('publish_date')

            ->get();
    }
}