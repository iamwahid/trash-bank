@extends('backend.layouts.app')

@section('title', app_name() . ' | Kasir')


@section('content')
{{ html()->modelForm($siswa, 'POST', route('admin.kasir.point', $siswa->id))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Kasir
                            <small class="text-muted">Tukar Point</small>
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
                        {{ html()->label("Kelas")->class('col-md-2 form-control-label')->for('kelas') }}

                            <div class="col-md-10">
                                {{ html()->text('kelas')
                                    ->class('form-control')
                                    ->attribute('readonly', true)
                                    ->required()
                                 }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                        {{ html()->label("Point Siswa")->class('col-md-2 form-control-label')->for('point_total') }}

                            <div class="col-md-10">
                                {{ html()->text('point_total')
                                    ->class('form-control')
                                    ->attribute('type', 'number')
                                    ->attribute('readonly', true)
                                    ->required()
                                    }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                        {{ html()->label("Beli Jualan")->class('col-md-2 form-control-label')->for('barang') }}

                            <div class="col-md-10">
                                {{ html()->select('barang')
                                    ->class('form-control')
                                    ->options($barang)
                                    ->required()
                                 }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                        {{ html()->label("Jumlah")->class('col-md-2 form-control-label')->for('jumlah') }}

                            <div class="col-md-10">
                                {{ html()->text('jumlah')
                                    ->class('form-control')
                                    ->attribute('type', 'number')
                                    ->required()
                                    }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                        {{ html()->label("Total Harga")->class('col-md-2 form-control-label')->for('total') }}

                            <div class="col-md-10">
                                {{ html()->text('total')
                                    ->class('form-control')
                                    ->attribute('type', 'number')
                                    ->attribute('readonly', true)
                                    ->required()
                                    }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                        {{ html()->label("Keterangan")->class('col-md-2 form-control-label')->for('keterangan') }}

                            <div class="col-md-10">
                                {{ html()->textarea('keterangan')
                                    ->class('form-control')
                                    ->attribute('rows', 2)
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
                        {{ form_submit(__('Tukar')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')
<script>
    let barang = document.getElementById('barang')
    let jumlah = document.getElementById('jumlah')
    let total = document.getElementById('total')

    barang.addEventListener('change', function(e){
        // console.log(this.value);
        let value = this.value.split('_')[1]
        total.value = value * jumlah.value
    })

    jumlah.addEventListener('keyup', function(e){
        // console.log(this.value);
        let value = barang.value.split('_')[1]
        total.value = this.value * value
    })
</script>
@endpush
