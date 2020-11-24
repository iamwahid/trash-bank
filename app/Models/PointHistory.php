<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    public $table = 'point_history';
    protected $fillable = [
        'warga_id',
        'type',
        'description',
        'point',
        'point_total',
        'verif_code',
        'verified'
    ];

    public $cast = [
        'verified' => 'boolean'
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function getActionsAttribute()
    {
        // $show = route('admin.warga.show', $this->id);
        // $edit = route('admin.warga.edit', $this->id);
        // $delete = route('admin.warga.delete', $this->id);
        // return '<div class="btn-group">'.
        // '<a href="'.$show.'" class="btn btn-primary">Lihat</a>'.
        // '<a href="'.$edit.'" class="btn btn-success">Edit</a>'.
        // '<a href="'.$delete.'" class="btn btn-danger">Delete</a>'.
        // '</div>';
    }
}
