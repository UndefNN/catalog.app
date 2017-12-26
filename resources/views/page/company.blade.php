@extends('layouts.main')

@section('content')
    <section class="content-header">
        <h1>Карточка организации</h1>
    </section>
    <section class="content">
        @if ( session()->has('message') )
            <div class="callout callout-success">
                <h4>Сообщение</h4>
                <p>{{ session('message') }}</p>
            </div>
        @endif
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $company->short_name }}</h3>
            </div>
            <div class="box-body">
                
                <div class="row info-row mb-4">
                    <div class="col-md-2">
                        <span class="black-title">Наименование:</span>
                    </div>
                    <div class="col-md-10">
                        <strong>{{ isset($company->full_name) ? $company->full_name : $company->short_name }}</strong>
                    </div>
                </div>
                
                <div class="row info-row mb-4">
                    <div class="col-md-2">
                        <span class="black-title">ИНН:</span>
                    </div>
                    <div class="col-md-10">
                        {{ isset( $company->inn) ? $company->inn : 'не задан'  }}
                    </div>
                </div>

                <div class="row info-row mb-4">
                    <div class="col-md-2">
                        <span class="black-title">Правовая форма:</span>
                    </div>
                    <div class="col-md-10">{{ isset( $company->opf->full) ? $company->opf->full : 'не задана'  }}</div>
                </div>

                @if( isset( $company->web ) )
                <div class="row info-row mb-4">
                    <div class="col-md-2">
                        <span class="black-title">Сайт:</span>
                    </div>
                    <div class="col-md-10">
                        <a href="{{ $company->web }}">{{ $company->web }}</a>
                    </div>
                </div>
                @endif

                @if( isset( $company->email ))
                <div class="row info-row">
                    <div class="col-md-2 mb-4">
                        <span class="black-title">Почта:</span>
                    </div>
                    <div class="col-md-10"><a href="mailto:{{ $company->email }}">{{ $company->email }}</a></div>
                </div>
                @endif

                <div class="row info-row mb-4">
                    <div class="col-md-2">
                        <span class="black-title">Адрес:</span>
                    </div>
                    <div class="col-md-10">{{ isset( $company->address) ? $company->address : 'не задан'  }}</div>
                </div>

                @if ( isset( $company->phones ))
                <div class="row info-row mb-4">
                    <div class="col-md-2">
                        <span class="black-title">Телефоны:</span>
                    </div>
                    <div class="col-md-10">
                        <ul class="list-inline">
                            @foreach( $company->phones as $phone )
                                <li>{{ $phone->number }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="row info-row mb-4">
                    <div class="col-md-2">
                        <span class="black-title">Описание:</span>
                    </div>
                    <div class="col-md-10">{{ $company->description }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection