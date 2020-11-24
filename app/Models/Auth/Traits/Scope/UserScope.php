<?php

namespace App\Models\Auth\Traits\Scope;

use Illuminate\Support\Facades\DB;

/**
 * Class UserScope.
 */
trait UserScope
{
    /**
     * @param $query
     * @param bool $confirmed
     *
     * @return mixed
     */
    public function scopeConfirmed($query, $confirmed = true)
    {
        return $query->where('confirmed', $confirmed);
    }

    /**
     * @param $query
     * @param bool $status
     *
     * @return mixed
     */
    public function scopeActive($query, $status = true)
    {
        return $query->where('active', $status);
    }

    public function scopeRt($query, $rt = '')
    {
        if (!$rt) return $query;
        return $query->whereHas('warga', function($q) use ($rt){
            return $q->where('rt', $rt);
        });
    }

    public function scopeName($query, $name = '')
    {
        if (!$name) return $query;
        return $query->where(DB::raw('concat(users.first_name," ",users.last_name)') , 'LIKE' , '%'.$name.'%');
        // return $query->where(DB::raw('users.first_name || " " || users.last_name') , 'LIKE' , '%'.$name.'%');;
    }
}
