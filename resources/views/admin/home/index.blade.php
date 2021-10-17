@extends('admin.layouts.master')


@section('content')
    <div class="m-portlet">
        {{--<div class="m-portlet__head">--}}
            {{--<div class="m-portlet__head-caption">--}}
                {{--<div class="m-portlet__head-title">--}}
                    {{--<h3 class="m-portlet__head-text">--}}
                        {{--Админка--}}
                    {{--</h3>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="m-section">
            <div class="m-section__content">
                <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Админка
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-widget4">
                            <div class="m-widget4__img m-widget4__img--logo">
                                <img src="{{ URL::to('/') }}/core/adminLTE/assets/app/media/img/users/Group_44.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


