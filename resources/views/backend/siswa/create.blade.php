@extends('backend.layouts.app')

@section('title', app_name() . ' | Siswa')


@section('content')
    {{ html()->form('POST', route('admin.siswa.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Atur Siswa
                            <small class="text-muted">Buat baru</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row mt-4 mb-4">
                    <div class="col">
                        <div class="form-group row">
                            {{ html()->label("Nama Siswa")->class('col-md-2 form-control-label')->for('user.name') }}

                            <div class="col-md-10">
                                {{ html()->text('user.name')
                                    ->class('form-control')
                                    ->required()
                                 }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                        {{ html()->label("Kelas")->class('col-md-2 form-control-label')->for('kelas') }}

                            <div class="col-md-10">
                                {{ html()->text('kelas')
                                    ->class('form-control')
                                    ->required()
                                 }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                        {{ html()->label("Email")->class('col-md-2 form-control-label')->for('email') }}

                            <div class="col-md-10">
                                {{ html()->text('email')
                                    ->class('form-control')
                                    ->required()
                                 }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                        {{ html()->label("Password")->class('col-md-2 form-control-label')->for('password') }}

                            <div class="col-md-10">
                                {{ html()->password('password')
                                    ->class('form-control')
                                    ->required()
                                 }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                        {{ html()->label("Password Konfirmasi")->class('col-md-2 form-control-label')->for('password_confirmation') }}

                            <div class="col-md-10">
                                {{ html()->password('password_confirmation')
                                    ->class('form-control')
                                    ->required()
                                 }}
                            </div><!--col-->
                        </div><!--form-group-->

                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.siswa.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection
