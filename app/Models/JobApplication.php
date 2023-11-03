<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        "status_id",
        "user_id",
        "job_post_id",
    ];

    public function status()
    {
        return $this->belongsTo(JobApplicationsStatus::class, "status_id");
    }

    public function post()
    {
        return $this->belongsTo(JobPost::class, "job_post_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
