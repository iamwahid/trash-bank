<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    public $table = 'warga';
    protected $fillable = [
        'user_id',
        'place_of_birth',
        'birth_date',
        'address',
        'sex',
        'rt',
        'is_koordinator',
        'point_total',
    ];

    protected $appends = [
        'last_point',
        'last_info'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function points()
    {
        return $this->hasMany(PointHistory::class, 'warga_id')->orderBy('created_at', 'desc');
    }

    public function getLastInfoAttribute()
    {
        $last = $this->points->first();
        if (!$last) return;
        $last = '['.$last->type.'] '.$last->description;
        return $last;
    }

    public function getLastPointAttribute()
    {
        $latest = $this->points->first();
        return $latest;
    }

    public function getActionsAttribute()
    {
        $show = route('admin.warga.show', $this->id);
        $edit = route('admin.warga.edit', $this->id);
        $delete = route('admin.warga.delete', $this->id);
        $barang = route('admin.kasir.barang', $this->id);
        $point = route('admin.kasir.point', $this->id);
        $html = '';
        if (auth()->user()->hasRole(config('access.users.admin_role'))) {
            $html = '<div class="btn-group">'.
            '<a href="'.$show.'" class="btn btn-primary">Lihat</a>'.
            '<a href="'.$edit.'" class="btn btn-success">Edit</a>'.
            '<button type="button" onclick="deleteItem(\''.$delete.'\')" class="btn btn-danger">Delete</button>'.
            '</div>';
        } else if (auth()->user()->hasRole(config('access.users.executive_role'))) {
            $html = '<div class="btn-group">'.
            '<a href="'.$barang.'" class="btn btn-primary">Tukar Barang</a>'.
            '<a href="'.$point.'" class="btn btn-success">Tukar Point</a>'.
            '</div>';
        }

        return $html;
    }
}
