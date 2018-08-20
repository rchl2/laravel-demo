<?php

namespace App\Relations;

use App\Models\Reflinks;
use App\Models\Safebox;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait UserRelations
{
    /**
     * Safebox relation.
     */
    public function safebox(): hasOne
    {
        return $this->hasOne(Safebox::class, 'account_id', 'id');
    }

    /**
     * Reflink relation.
     */
    public function reflinkCorrelation(): hasOne
    {
        return $this->hasOne(Reflinks::class, 'id', 'reflink');
    }
}
