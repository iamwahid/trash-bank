@extends('frontend.layouts.app')

@section('title', app_name() . ' | Riwayat Transaksi' )

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>
                        <i class="fas fa-tachometer-alt"></i> Riwayat Transaksi
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="card-title mb-0">
                                                Transaksi <small class="text-muted">Riwayat Transaksi</small>
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
                                                            <th>Tipe</th>
                                                            <th>Deskripsi</th>
                                                            <th>Point</th>
                                                            <th>Total</th>
                                                            <th>Created at</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($logged_in_user->siswa->points as $k => $t)
                                                        <tr>
                                                            <td>{{ $k+1 }}</td>
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
                        </div>
                    </div><!-- row -->
                </div> <!-- card-body -->
            </div><!-- card -->
        </div><!-- row -->
    </div><!-- row -->
@endsection
