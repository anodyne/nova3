<?php

namespace Nova\Pages;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'uri', 'key', 'verb', 'resource', 'layout',
    ];
}