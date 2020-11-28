<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    public $table = 'point_history';
    protected $fillable = [
        'warga_id',
        'type',
        'count',
        'description',
        'point',
        'point_total',
        'verif_code',
        'verified'
    ];

    protected $casts = [
        'verified' => 'boolean',
    ];

    protected $hidden = [
        'verif_code'
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

    public function getBarcodeAttribute()
    {
        if (!$this->verified && $this->verif_code) {
            $barcode = base64_encode(implode('-', [$this->id, $this->warga_id, $this->verif_code]));
            $barcode = barcode_class($barcode, 'QRCODE', 20, 20);
            return $barcode->png;
        }
        return '';
    }

    public function scopeType($query, $type = '')
    {
        if (!$type) return $query;
        return $query->where('type', $type);
    }
}
