@extends('core::layouts.master')

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ $title }}
                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="#" data-url="{{ route('admin.audio.create') }}"
                           data-type="modal" data-modal="largeModal"
                           class="m-portlet__nav-link m-portlet__nav-link--icon handle-click"
                           data-container="body"
                           data-toggle="m-tooltip"
                           data-placement="top"
                           title="Загрузить аудио файл">
                            <i class="la la-plus-circle"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <p class="text-center"><b>Список аудио файлов</b></p>
                <table class="table table-bordered ajax-content"
                       data-url="{{ route('admin.audio.list') }}">
                    <thead>
                    <tr>
                        <th class="text-center" width="50">#</th>
                        <th class="text-center" style="width:10%;">Название</th>
                        <th class="text-center" style="width:10%;">Длит (сек)</th>
                        <th class="text-center" style="width:70%;">waveform</th>
                        <th class="text-center" style="width:5%;">Текстовый контент</th>
                        <th class="text-center" style="width:5%;">Порядковый номер</th>
                        <th class="text-center" style="width:10%;"><i class="fa fa-adjust" aria-hidden="true"></i></th>
                        <th class="text-center" style="width:10%;"><i class="fa fa-bars" aria-hidden="true"></i></th>
                        <th class="text-center" style="width:10%;"><i class="fa fa-trash" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="pagination_placeholder"></div>
            </div>
        </div>
        <!--end::Section-->
    </div>
@stop
