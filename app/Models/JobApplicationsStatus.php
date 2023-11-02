<?php

namespace App\Models;

use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationsStatus extends Model
{
    use HasFactory;
    protected $table = "job_applications_status";
    public function job_applications()
    {
        return $this->hasMany(JobApplication::class, "status");
    }
}
