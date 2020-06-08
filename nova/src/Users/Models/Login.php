<?php

namespace Nova\Users\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    public $timestamps = false;

    protected $fillable = ['ip_address', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
