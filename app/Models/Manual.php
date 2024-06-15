<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'min_duration',
        'max_duration',
        'questions',
    ];

    protected $casts = [
        'questions' => 'array'
    ];



    public function getDurationAttribute() {
        return $this->min_duration . '-' . $this->max_duration;
    }

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }
}
