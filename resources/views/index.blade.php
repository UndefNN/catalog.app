@extends('layouts.main')

@section('content')
    <section class="content-header">
        <h1>
            Главная страница
            <small>быстрый поиск</small>
        </h1>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title">
                    Поиск организаций
                </div>
                <div class="box-body">
                    <label for="search">Компания</label>
                    <search
                            name="search"
                            placeholder="Название организации..."
                            url="/ajax/search/company"
                            on-select="openLink">
                    </search>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Widget box -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{!! $count !!}</h3>
                        <p>Компаний в справочнике</p>
                    </div>
                    <div class="icon">
                          <i class="fa fa-bank"></i>
                    </div>
                    <a href="{{ url('/company') }}" class="small-box-footer">
                        Посмотреть <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
                <!-- Widget box -->
            </div>

            <div class="col-md-3">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Последние добавленные</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <uL class="list-unstyled">
                        @foreach( $latest as $company )
                            <li class="mb-1">
                                <a href="{{url('/company/'.$company->id)}}">{{ $company->short_name }}</a>
                            </li>
                        @endforeach
                        </uL>
                    </div>
                          <!-- /.box-body -->
                </div>
                        <!-- /.box -->
            </div>
            <!-- row -->
        </div>
    </section>
@endsection

@section('sidebar')
    @include('sidebar')
@endsection
