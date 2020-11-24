@extends('backend.layouts.app')

@section('title', app_name() . ' | Kasir')


@section('content')
{{ html()->modelForm($siswa, 'POST', route('admin.kasir.konfirmasi', $siswa->id))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Kasir
                            <small class="text-muted">Konfirmasi</small>
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
                                    ->attribute('readonly', true)
                                    ->required()
                                 }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label("Kode Verifikasi")->class('col-md-2 form-control-label')->for('verif_code') }}

                            <div class="col-md-10">
                                {{ html()->text('verif_code')
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
                        {{ form_cancel(route('admin.kasir.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('Konfirmasi')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')
<script>
    let point_total = document.getElementById('point_total')
    let jumlah_point = document.getElementById('jumlah_point')

    jumlah_point.addEventListener('keypress', function(e){
        if (this.value > point_total.value) return false
    })
</script>
@endpush
