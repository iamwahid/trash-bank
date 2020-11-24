@extends('backend.layouts.app')

@section('title', app_name() . ' | siswa')


@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Siswa <small class="text-muted">Daftar Siswa</small>
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
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Point</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach ($siswa as $k => $b)
                                  <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$b->user->name}}</td>
                                    <td>{{$b->kelas }}</td>
                                    <td>{{$b->point_total }}</td>
                                    <td>{!! $b->actions !!}</td>
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
</div>
<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Jualan <small class="text-muted">Harga Jualan</small>
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
                                    <th>Nama</th>
                                    <th>Point</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach ($jualan as $k => $b)
                                  <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$b->name}}</td>
                                    <td>{{$b->point }}</td>
                                    {{-- <td>{!! $b->actions !!}</td> --}}
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
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Barang <small class="text-muted">Harga Barang</small>
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
                                    <th>Nama</th>
                                    <th>Point</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach ($barang as $k => $b)
                                  <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{$b->name}}</td>
                                    <td>{{$b->point }}</td>
                                    {{-- <td>{!! $b->actions !!}</td> --}}
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
</div>
@endsection
