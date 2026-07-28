<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class DashboardCache
{
    public static function clear(): void
    {
        Cache::forget('admin_dashboard');
    }

    public static function clearTeacher(int $teacherId): void
    {
        Cache::forget("teacher_dashboard_{$teacherId}");
    }

    public static function clearStudent(int $studentId): void
    {
        Cache::forget("student_dashboard_{$studentId}");
    }
}