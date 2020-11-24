@extends('backend.layouts.app')

@section('title', app_name() . ' | Siswa')


@section('content')
{{ html()->modelForm($siswa, 'POST', route('admin.siswa.update', $siswa))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Atur Siswa
                            <small class="text-muted">Edit data</small>
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
                        {{ html()->label("Kelas Siswa")->class('col-md-2 form-control-label')->for('kelas') }}

                            <div class="col-md-10">
                                {{ html()->text('kelas')
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
                        {{ form_submit(__('buttons.general.crud.edit')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection
