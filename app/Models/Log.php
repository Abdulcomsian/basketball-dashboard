<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'action', 'model', 'model_id', 'data', 'related_id', 'related_model', 'description'];

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    protected $casts = [
        'data' => 'array',
    ];
}
