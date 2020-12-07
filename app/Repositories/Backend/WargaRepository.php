<?php

namespace App\Repositories\Backend;

use App\Events\Backend\Auth\User\UserPermanentlyDeleted;
use App\Exceptions\GeneralException;
use App\Models\Barang;
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

    // for warga
    public function tukarBarang(Warga $warga, Barang $barang, $data)
    {
        $count = (float) $data['count'];
        $total = $count * $barang->point;
        $point_total = $warga->point_total + $total;
        $data['description'] = $barang->name.' ('.$count.' x '.$barang->point.') '.$total.' Point | '.$point_total.' Saldo Total';
        $data['point'] = $barang->point;
        $data['point_total'] = $total;
        $data['type'] = 'tukar';
        $data['verified'] = true;

        // update counter
        $barang->counter = $barang->counter + $count;
        $barang->save();

        $warga->points()->create($data);
        $warga->point_total = $point_total;
        $warga->save();
    }

    public function ambilPoint(Warga $warga, $data)
    {
        $total = (int)$data['point'];
        
        if ($total > (int) $warga->point_total) return response()->json(['message' => 'Saldo tidak cukup'], 422);
        $data['description'] = 'Ambil Saldo '.$total.' Point';
        $data['point'] = $total;
        $data['point_total'] = $total;
        $data['type'] = 'ambil';
        $data['verif_code'] = strtolower(Str::random(14));

        $trx = $warga->points()->create($data);
        session()->put('trx_id', $trx->id );
        $warga->save();

        return response()->json(['trx_id' => $trx->id, 'status' => 'unverified']);
    }

    public function konfirmasi(Warga $warga, $data)
    {
        $trx = $warga->points()->where('id', '=', $data['trx_id'] ?? session()->get('trx_id'))->get()->first();
        
        if ($trx && ($trx->verif_code == $data['verif_code'])) {
            if ($trx->type == 'ambil') {
                if ($warga->point_total < $trx->point) return response()->json(['message' => 'Saldo tidak Cukup'], 422);
                $point_total = $warga->point_total - $trx->point_total;
                $warga->point_total = $point_total;
                $trx->verified = true;
                $trx->description = $trx->description . ' | '.$point_total.' Saldo Total';
                $trx->save();
                $warga->save();
            } else {
                $trx->verified = true;
                $trx->save();
            }
            session()->forget('trx_id');
            return response()->json(['message' => 'Berhasil Verifikasi']);
        }
        return response()->json(['message' => 'Kode Verifikasi tidak Valid'], 422);
    }

    public function getLatestCode(Warga $warga)
    {
        if (!$warga->id) return;
        $latest = $warga->points->first();
        if (!$latest) return;
        return $latest->verif_code;
    }

    //for kasir
    public function validateCode(Warga $warga, $code)
    {
        if (!$code || !$warga->id) return;
        $latest = $this->getLatestCode($warga);
        return $latest && $latest == $code;
    }

    public function deleteById($id) : bool
    {
        $this->unsetClauses();
        $warga = $this->getById($id);
        $user = $warga->user;
        $warga->points()->delete();
        $warga->delete();

        $user->passwordHistories()->delete();
        if ($user->forceDelete()) {
            return true;
        }
        return false;
    }

    public function decodeBarcode($barcode)
    {
        $decoded = base64_decode($barcode, true);
        $parts = [];
        if ($decoded) {
            $parts = explode('-', $decoded);
            $parts[1] = $this->getById($parts[1]);
        }
        return $parts;
    }

    public function scanTrxBarcode($barcode)
    {
        $decoded = $this->decodeBarcode($barcode);
        if ($decoded) {
            $parts = $decoded;
            $trx_id = $parts[0];
            $warga = $parts[1];
            $verif_code = $parts[2];
            return $this->konfirmasi($warga, compact(['trx_id', 'verif_code']));
        }
        return response()->json(['message' => 'Data tidak Valid'], 422);
    }

    public function scanBarcode($barcode)
    {
        $decoded = $this->decodeBarcode($barcode);
        if ($decoded) {
            $parts = $decoded;
            $warga = $parts[1];
            return response()->json($warga);
        }
        return response()->json([], 404);
    }

}
