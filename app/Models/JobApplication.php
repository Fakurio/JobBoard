<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        "status",
        "user_id",
        "job_post_id",
    ];

    public function status()
    {
        return $this->belongsTo(JobApplicationsStatus::class, "status");
    }

    public function post()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
