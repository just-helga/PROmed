<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function applications() {
        return $this->hasMany(Application::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
