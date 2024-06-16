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
        'is_draft'
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

    public function materials() {
        return $this->hasMany(Material::class);
    }
}
