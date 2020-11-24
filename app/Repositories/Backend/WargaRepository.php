<?php

namespace App\Repositories\Backend;

use App\Events\Backend\Auth\User\UserPermanentlyDeleted;
use App\Exceptions\GeneralException;
use App\Models\Warga;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\BaseRepository;
use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\Uuid;
use Str;

/**
 * Class WargaRepository.
 */
class WargaRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Warga::class;
    }

    // for siswa
    public function tukarBarang(Warga $siswa, $data)
    {
        $data = array_merge([
            'type' => 'jual',
            'verified' => true
        ], $data);
        // dd($siswa->point_total + $data['point_total']);
        $siswa->points()->create($data);
        $siswa->update(['point_total' => $data['point_total'] ]);
    }

    public function tukarPoint(Warga $siswa, $data)
    {
        $code = strtolower(Str::random(5));
        $data = array_merge([
            'type' => 'beli',
            // 'point_total' => $siswa->point_total, // point awal
            'verif_code' => $code,
        ], $data);
        // $res = $siswa->point_total - $data['jumlah_point'];
        $trx = $siswa->points()->create($data);
        session()->put('trx_id', $trx->id );
        // $siswa->update(['point_total' => $siswa->point_total - $data['jumlah_point'] ]);
        $siswa->save();
    }

    public function konfirmasi(Warga $siswa, $code)
    {
        $trx = session()->get('trx_id');
        $trx = $siswa->points()->where('id', '=', $trx)->get()->first();
        if ($this->validateCode($siswa, $code) && $trx && $siswa->point_total >= $trx->point) {
            $point_total = $siswa->point_total - $trx->point;
            $siswa->update([
                'point_total' => $point_total,
            ]);
            $trx->update([
                'point_total' => $point_total,
                'verified' => true
            ]);
            session()->forget('trx_id');
            return true;
        }
        return false;
    }

    public function getLatestCode(Warga $siswa)
    {
        if (!$siswa->id) return;
        $latest = $siswa->points->first();
        if (!$latest) return;
        return $latest->verif_code;
    }

    //for kasir
    public function validateCode(Warga $siswa, $code)
    {
        if (!$code || !$siswa->id) return;
        $latest = $this->getLatestCode($siswa);
        return $latest && $latest == $code;
    }

    public function deleteById($id) : bool
    {
        $this->unsetClauses();
        $siswa = $this->getById($id);
        $user = $siswa->user;
        $siswa->points()->delete();
        $siswa->delete();

        $user->passwordHistories()->delete();
        if ($user->forceDelete()) {
            return true;
        }
        return false;
    }

}
