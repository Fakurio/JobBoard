<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "company_name",
        "salary",
        "logo",
        "is_featured"
    ];

    public function contract_type()
    {
        return $this->belongsTo(ContractType::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'location');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'job_post_languages');
    }
}