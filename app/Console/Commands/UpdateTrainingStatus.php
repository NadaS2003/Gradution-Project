<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Carbon\Carbon;

class UpdateTrainingStatus extends Command
{
    protected $signature = 'training:update-status';
    protected $description = 'تحديث حالة التدريب للطلاب الذين انتهى تدريبهم';

    public function handle()
    {
        // جلب جميع الطلاب الذين لديهم تدريب منتهي ولكن لم يتم تحديث حالتهم
        $students = Student::whereHas('application', function ($query) {
            $query->whereDate('end_date', '<', Carbon::today()) // انتهى التدريب
            ->where('training_status', '!=', 'completed'); // لم يتم تحديث الحالة
        })->get();

        foreach ($students as $student) {
            $student->training_status = 'completed';
            $student->save();
        }

        $this->info('تم تحديث حالة التدريب للطلاب المنتهية فترتهم.');
    }
}
