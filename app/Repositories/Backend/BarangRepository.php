<?php

namespace App\Repositories\Backend;

use App\Models\Barang;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\BaseRepository;
use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\Uuid;

/**
 * Class BarangRepository.
 */
class BarangRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Barang::class;
    }
}
