@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>
                        <i class="fas fa-tachometer-alt"></i> @lang('navs.frontend.dashboard')
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <div class="row">
                        <div class="col col-sm-4 order-1 order-sm-2  mb-4">
                            <div class="card mb-4 bg-light">
                                <img class="card-img-top" src="{{ $logged_in_user->picture }}" alt="Profile Picture">

                                <div class="card-body">
                                    <h4 class="card-title">
                                        {{ $logged_in_user->name }}<br/>
                                    </h4>

                                    <p class="card-text">
                                        <small>
                                            <i class="fas fa-envelope"></i> {{ $logged_in_user->email }}<br/>
                                            <i class="fas fa-calendar-check"></i> @lang('strings.frontend.general.joined') {{ timezone()->convertToLocal($logged_in_user->created_at, 'F jS, Y') }} <br>
                                            @if ($logged_in_user->siswa)
                                            <i class="fas fa-user"></i> Kelas {{$logged_in_user->siswa->kelas}}
                                            @endif
                                        </small>
                                    </p>

                                    <p class="card-text">

                                        <a href="{{ route('frontend.user.account')}}" class="btn btn-info btn-sm mb-1">
                                            <i class="fas fa-user-circle"></i> @lang('navs.frontend.user.account')
                                        </a>

                                        @can('view backend')
                                            &nbsp;<a href="{{ route('admin.dashboard')}}" class="btn btn-danger btn-sm mb-1">
                                                <i class="fas fa-user-secret"></i> @lang('navs.frontend.user.administration')
                                            </a>
                                        @endcan
                                    </p>
                                </div>
                            </div>
                            
                            @if ($logged_in_user->siswa)
                            <div class="card mb-4">
                                <div class="card-header"><strong>Your Point</strong></div>
                                <div class="card-body text-center">
                                    <div>
                                        <h1><strong>{{$logged_in_user->siswa->point_total}}</strong></h1>
                                        <small>Last action : {{$logged_in_user->siswa->last_info}}</small>
                                    </div>
                                    <a href="{{route('frontend.user.transaksi')}}" class="btn btn-sm btn-success">Riwayat transaksi</a>
                                </div>
                            </div><!--card-->
                            @endif
                        </div><!--col-md-4-->

                        <div class="col-md-8 order-2 order-sm-1">
                            <div class="row">
                                <div class="col-12">
                                    @if ($logged_in_user->siswa)
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <strong>Code</strong>
                                        </div><!--card-header-->
                                        <div class="card-body text-center">
                                            @if ($logged_in_user->siswa->last && !$logged_in_user->siswa->last->verified)
                                            <h1><strong>{{$logged_in_user->siswa->last->verif_code}}</strong></h1>
                                            @endif
                                            <button class="btn btn-success" onclick="window.location.reload(true)"><i class="fas fa-refresh"></i> Reload</button>
                                        </div><!--card-body-->
                                    </div><!--card-->
                                    @endif
                                </div><!--col-md-6-->
                                <div class="col-12 mb-3">
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
                                <div class="col-12">
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
                            </div><!--row-->
                        </div><!--col-md-8-->
                    </div><!-- row -->
                </div> <!-- card-body -->
            </div><!-- card -->
        </div><!-- row -->
    </div><!-- row -->
@endsection
