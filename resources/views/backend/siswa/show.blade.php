@extends('backend.layouts.app')

@section('title', app_name() . ' | Siswa')


@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Data Siswa <small class="text-muted">{{$siswa->user->name}}</small>
                </h4>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-sm-5">
                <strong>Kelas</strong>
            </div>
            <div class="col-sm-7">
                {{ $siswa->kelas }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-sm-5">
                <strong>Point Total</strong>
            </div>
            <div class="col-sm-7">
                {{ $siswa->point_total }}
            </div>
        </div>

        <h4> Riwayat Transaksi </h4>
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tipe</th>
                    <th>Deskripsi</th>
                    <th>Point</th>
                    <th>Total</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($siswa->points as $k => $b)
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $b->type }}</td>
                    <td>{{ $b->description }}</td>
                    <td>{{ $b->point }}</td>
                    <td>{{ $b->point_total }}</td>
                    <td>{{ $b->created_at->format('H:i:s d M Y').' ('.$b->created_at->diffForHumans().')' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div><!--card-body-->
</div><!--card-->
@endsection
