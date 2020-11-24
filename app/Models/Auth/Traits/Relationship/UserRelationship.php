<?php

namespace App\Models\Auth\Traits\Relationship;

use App\Models\Auth\PasswordHistory;
use App\Models\Auth\User;
use App\Models\Warga;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{

    /**
     * @return mixed
     */
    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    public function warga()
    {
        return $this->hasOne(Warga::class, 'user_id');
    }
}

