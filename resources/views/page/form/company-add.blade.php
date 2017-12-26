@extends('layouts.main')

@section('content')
    <section class="content-header">
        <h1>
            Добавление организации
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-5 col-md-push-7">
                <div class="box box-danger">
                    <div class="box-header">
                        <div class="box-title">
                            Автозаполнение
                        </div>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        Вы можете заполнить часть данных вашей организации автоматически, воспользовавашись поиском ниже.
                        <search
                                name="company"
                                url="/ajax/search/company_profile"
                                on-select="getCompany"
                                placeholder="Название организации"
                                v-on:get-company="getCompany"
                        >
                        </search>
                    </div>
                </div>

                @if (count($errors) > 0)
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <div class="box-title">
                                Исправьте ошибки!
                            </div>
                        </div>
                        <div class="box-body">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

            </div>
            <div class="col-md-7 col-md-pull-5">
                <div class="box box-default">
                    <div class="box-header">
                        <div class="box-title">
                            Заполните форму
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="" method="post" role="form" class="form form-default">
                            <legend>Добавление организации в справочник</legend>
                            {{ csrf_field() }}
                            <div class="form-group" :class="isNameValid">
                                <label for="short_name">Краткое наименование</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        name="short_name"
                                        placeholder="Рога и копыта"
                                        v-model="value.name"
                                        required
                                >
                            </div>

                            <div class="form-group" :class="isFullNameValid">
                                <label for="full_name">Полное наименование</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        name="full_name"
                                        placeholder='ООО "Рога и копыта"'
                                        v-model="value.full_name"
                                >
                            </div>

                            <div class="form-group" :class="isInnValid">
                                <label for="inn">ИНН</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        name="inn"
                                        placeholder="10 или 12 цифр"
                                        v-model="value.inn"
                                >
                            </div>

                            <div class="form-group" :class="isOpfValid">
                                <label for="opf_select">Форма собственности</label>
                                <search
                                        name="opf_select"
                                        url="/ajax/search/opf"
                                        on-select="select"
                                        target="opf_id"
                                        placeholder=""
                                        v-on:update-value="setValue"
                                        v-model="value.opf"
                                ></search>
                                <input
                                        type="hidden"
                                        name="opf_id"
                                        v-model="value.opf_id"
                                >
                            </div>

                            <div class="form-group" :class="isAddressValid">
                                <label for="address">Адрес</label>
                                <search
                                        name="address"
                                        url="/ajax/search/address"
                                        render="address"
                                        ref="search"
                                        v-model="value.address"
                                        on-select="update_address"
                                        v-on:update-value="setValue"
                                        target="address"
                                ></search>
                            </div>

                            <div class="form-group" :class="isWebValid">
                                <label class="control-label" for="web">Сайт</label>
                                <div class="input-group">
                                    <span class="input-group-addon">www</span>
                                    <input type="text" name="web" class="form-control" v-model="value.web">
                                </div>
                            </div>

                            <div class="form-group" :class="isEmailValid">
                                <label class="control-label" for="email">Электронная почта</label>
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" name="email" class="form-control" v-model="value.email" required >
                                </div>
                            </div>

                            <phone></phone>

                            <div class="form-group">
                                <label for="description">Краткое описание</label>
                                <textarea name="description" rows="3" class="form-control" v-model="value.description"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" :disabled="!isFormValid">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('footer-scripts')
    @if ( old() )
    <script type="text/javascript">
        var data = {
            name:           '{{ old('short_name') }}',
            full_name:      '{{ old('full_name') }}',
            inn:            '{{ old('inn') }}',
            opf:            '{{ old('opf_select') }}',
            opf_id:         '{{ old('opf_id') }}',
            address:        '{{ old('address') }}',
            web:            '{{ old('web') }}',
            email:          '{{ old('email') }}',
            description:    '{{ old('description') }}',
        }
    </script>
    @endif
@endpush