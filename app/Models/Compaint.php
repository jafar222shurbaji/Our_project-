<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compaint extends Model
{
    use HasFactory;

    protected $table = 'compaints';
    protected $fillable = [
        'user_id',
        'description',
        'treatment_status',
        'complaint_suggestion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
