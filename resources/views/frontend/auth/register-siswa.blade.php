@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        @lang('labels.frontend.auth.register_box_title')
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    {{ html()->form('POST', route('frontend.auth.register.post'))->class('form-horizontal')->open() }}
                        <div class="row mt-4 mb-4">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label("Nama Siswa")->class('form-control-label')->for('user_name') }}

                                    {{ html()->text('user_name')
                                        ->class('form-control')
                                        ->required()
                                    }}
                                </div><!--form-group-->

                                <div class="form-group">
                                    {{ html()->label("Kelas")->class('form-control-label')->for('kelas') }}

                                    {{ html()->text('kelas')
                                        ->class('form-control')
                                        ->required()
                                    }}
                                    <div class="col-md-10">
                                    </div><!--col-->
                                </div><!--form-group-->

                                <div class="form-group">
                                    {{ html()->label("Email")->class('form-control-label')->for('email') }}

                                    {{ html()->text('email')
                                        ->class('form-control')
                                        ->required()
                                    }}
                                    <div class="col-md-10">
                                    </div><!--col-->
                                </div><!--form-group-->

                                <div class="form-group">
                                    {{ html()->label("Password")->class('form-control-label')->for('password') }}

                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->required()
                                    }}
                                    <div class="col-md-10">
                                    </div><!--col-->
                                </div><!--form-group-->

                                <div class="form-group">
                                    {{ html()->label("Password Konfirmasi")->class('form-control-label')->for('password_confirmation') }}

                                    {{ html()->password('password_confirmation')
                                        ->class('form-control')
                                        ->required()
                                    }}
                                    <div class="col-md-10">
                                    </div><!--col-->
                                </div><!--form-group-->

                            </div><!--col-->
                        </div><!--row-->

                        @if(config('access.captcha.registration'))
                        <div class="row">
                            <div class="col">
                                @captcha
                                {{ html()->hidden('captcha_status', 'true') }}
                            </div><!--col-->
                        </div><!--row-->
                        @endif

                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix">
                                    {{ form_submit(__('labels.frontend.auth.register_button')) }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                    {{ html()->form()->close() }}

                    {{-- <div class="row">
                        <div class="col">
                            <div class="text-center">
                                {!! $socialiteLinks !!}
                            </div>
                        </div><!--/ .col -->
                    </div><!-- / .row --> --}}

                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection

@push('after-scripts')
    @if(config('access.captcha.registration'))
        @captchaScripts
    @endif
@endpush
