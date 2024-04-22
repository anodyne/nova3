<?php

declare(strict_types=1);

namespace Nova\Setup\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public $timestamps = false;

    protected $connection = 'nova2';

    protected $table = 'characters';

    protected $primaryKey = 'charid';

    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'userid');
    }
}
