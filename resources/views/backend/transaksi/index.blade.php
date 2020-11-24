@extends('backend.layouts.app')

@section('title', app_name() . ' | Transaksi')


@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Transaksi <small class="text-muted">Daftar Transaksi</small>
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
            </div><!--col-->
        </div><!--row-->

        {{-- if admin --}}
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Siswa</th>
                                <th>Tipe</th>
                                <th>Deskripsi</th>
                                <th>Point</th>
                                <th>Total</th>
                                <th>Created at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trx as $k => $t)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $t->siswa->user->name.' ( Kelas '.$t->siswa->kelas.' )' }}</td>
                                <td>{{ $t->type }}</td>
                                <td>{{ $t->description }}</td>
                                <td>{{ $t->point }}</td>
                                <td>{{ $t->point_total }}</td>
                                <td>{{ $t->created_at->format('H:i:s d M Y').' ('.$t->created_at->diffForHumans().')' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {{-- {!! $users->total() !!} {{ trans_choice('labels.backend.access.users.table.total', $users->total()) }} --}}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {{-- {!! $users->render() !!} --}}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection

@push('after-scripts')
<script>
function deleteItem(url) {
    if (confirm('Yakin Menghapus Barang?')) {
        console.log(url);
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _method:'delete',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(s) {
                window.location.reload(true)
            },
            error: function(e) {
                alert('Error');
            }
        })
    } else {
    // Do nothing
    }
}
</script>
@endpush
