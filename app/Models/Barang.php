<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public $table = 'barang';
    protected $fillable = [
        'name',
        'point',
        'type'
    ];

    public $timestamps = false;

    public function getActionsAttribute()
    {
        $show = route('admin.barang.show', $this->id);
        $edit = route('admin.barang.edit', $this->id);
        $delete = route('admin.barang.delete', $this->id);
        return '<div class="btn-group">'.
        '<a href="'.$edit.'" class="btn btn-success">Edit</a>'.
        '<button type="button" onclick="deleteItem(\''.$delete.'\')" class="btn btn-danger">Delete</button>'.
        '</div>';
    }

    public function getActionJualanAttribute()
    {
        $show = route('admin.jualan.show', $this->id);
        $edit = route('admin.jualan.edit', $this->id);
        $delete = route('admin.jualan.delete', $this->id);
        return '<div class="btn-group">'.
        '<a href="'.$edit.'" class="btn btn-success">Edit</a>'.
        '<button type="button" onclick="deleteItem(\''.$delete.'\')" class="btn btn-danger">Delete</button>'.
        '</div>';
    }

    public function scopeType($query, $type = '')
    {
        if (!$type) return $query;
        return $query->where('type', $type);
    }
}
