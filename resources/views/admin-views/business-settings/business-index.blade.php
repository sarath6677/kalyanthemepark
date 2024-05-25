@extends('layouts.admin.app')

@section('title', translate('Settings'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 pb-2">
            <img width="24" src="{{asset('public/assets/admin/img/media/business-setup.png')}}" alt="{{ translate('business_setup') }}">
            <h2 class="page-header-title">{{translate('Business Setup')}}</h2>
        </div>

        {{-- <div class="inline-page-menu my-4">
            @include('admin-views.business-settings.partial._business-setup-tabs')
        </div> --}}

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-1">
                    <i class="tio-briefcase"></i> {{translate('Business Information')}}
                </h5>
            </div>
            <div class="card-body">
                    <form action="{{route('admin.business-settings.update-setup')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @php($name=\App\Models\BusinessSetting::where('key','business_name')->first())
                            <div class="col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1">{{translate('business')}} {{translate('name')}}</label>
                                    <input type="text" name="restaurant_name" value="{{$name->value??''}}" class="form-control"
                                        placeholder="{{translate('New Business')}}" required>
                                </div>
                            </div>

                            @php($phone=\App\Models\BusinessSetting::where('key','phone')->first())
                            <div class="col-sm-6 col-xl-4 ">
                                <div class="form-group">
                                    <label class="input-label">{{translate('phone')}}</label>
                                    <input type="text" value="{{$phone->value??''}}"
                                        name="phone" class="form-control"
                                        placeholder="" required>
                                </div>
                            </div>

                            @php($email=\App\Models\BusinessSetting::where('key','email')->first())
                            <div class="col-sm-6 col-xl-4 ">
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1">{{translate('email')}}</label>
                                    <input type="email" value="{{$email->value??''}}"
                                        name="email" class="form-control" placeholder=""
                                        required>
                                </div>
                            </div>

                            @php($phoneVerification=\App\CentralLogics\Helpers::get_business_settings('phone_verification'))
                            <div class="col-sm-6 col-xl-4">
                                <div class="form-group">
                                    <div class="d-flex align-items-center gap-2">
                                        <label>{{translate('phone')}} {{translate('verification')}} ( OTP )</label>
                                        <small class="text-danger">*</small>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="1"
                                                    name="phone_verification"
                                                    id="phone_verification_on" {{ $phoneVerification==1?'checked':''}}>
                                                <label class="custom-control-label"
                                                    for="phone_verification_on">{{translate('on')}}</label>
                                            </div>
                                        </div>

                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="0"
                                                    name="phone_verification"
                                                    id="phone_verification_off" {{ $phoneVerification==0?'checked':''}}>
                                                <label class="custom-control-label"
                                                    for="phone_verification_off">{{translate('off')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                @php($address=\App\Models\BusinessSetting::where('key','address')->first())
                                <div class="form-group">
                                    <label class="input-label">{{translate('address')}}</label>
                                    <textarea type="text" id="address" name="address" class="form-control"
                                            rows="1" required>{{$address->value??''}}</textarea>
                                </div>
                            </div>

                        @php($businessShortDescription=\App\Models\BusinessSetting::where('key','business_short_description')->first())
                        <div class="col-sm-6 col-xl-4 ">
                            <div class="form-group">
                                <label class="input-label" for="business_short_description">{{translate('business_short_description')}}</label>
                                <input type="text" value="{{$businessShortDescription->value??''}}"
                                    name="business_short_description" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="input-label d-flex align-items-center gap-2">{{translate('logo')}}
                                        <small class="text-danger">* ( {{translate('ratio')}} 3:1 )</small>
                                    </label>

                                    <div class="custom-file">
                                        <input type="file" name="logo" id="customFileEg1" class="custom-file-input"
                                               accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileEg1">{{translate('choose File')}}</label>
                                    </div>

                                    <div class="text-center mt-3">
                                        <img class="border rounded-10 mx-w300 w-100" id="viewer"
                                             src="{{$logo}}" alt="{{ translate('logo') }}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="input-label d-flex align-items-center gap-2">{{translate('Favicon')}}
                                        <small class="text-danger">* ( {{translate('ratio')}} 1:1 )</small>
                                    </label>

                                    <div class="custom-file">
                                        <input type="file" name="favicon" id="customFileEg2" class="custom-file-input"
                                               accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileEg2">{{translate('choose File')}}</label>
                                    </div>

                                    <div class="text-center mt-3 overflow-hidden aspect-ratio-2">
                                        <img class="border rounded-10 w-100 img-fit max-height-180px max-width-180px" id="viewer1"
                                             src="{{$favicon}}" alt="{{ translate('favicon') }}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="input-label d-flex align-items-center gap-2">{{translate('landing_page_logo')}}
                                        <small class="text-danger">* ( {{translate('ratio')}} 3:1 )</small>
                                    </label>

                                    <div class="custom-file">
                                        <input type="file" name="landing_page_logo" id="customFileEg3" class="custom-file-input"
                                               accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileEg3">{{translate('choose File')}}</label>
                                    </div>

                                    <div class="text-center mt-3">
                                        <img class="border rounded-10 mx-w300 w-100" id="viewer3"
                                             src="{{$landingPageLogo}}" alt="{{ translate('landing_page_logo') }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" class="btn btn-primary demo-form-submit">{{translate('submit')}}</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        "use strict";

        function readURL(input, viewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(`#${viewId}`).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this, 'viewer');
        });
        $("#customFileEg2").change(function () {
            readURL(this, 'viewer1');
        });
        $("#customFileEg3").change(function () {
            readURL(this, 'viewer3');
        });
    </script>

    <script>
        $(document).on('ready', function () {
            @php($country=\App\CentralLogics\Helpers::get_business_settings('country')??'BD')
            $("#country option[value='{{$country}}']").attr('selected', 'selected').change();
        })
    </script>
@endpush
