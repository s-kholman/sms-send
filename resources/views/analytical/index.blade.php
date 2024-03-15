@extends('layouts.base')
@section('title', 'Создание рассылки')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

            </div>
        </div>


                        @forelse($mailing as $key => $value)
                            @if($loop->first)
                                <div class="row text-center">
                                    <div class="col-4 border border-1">
                                        Наименование
                                    </div>
                                    <div class="col-2 border border-1">
                                        Статус
                                    </div>
                                    <div class="col-2 border border-1">
                                        Отправленно
                                    </div>
                                    <div class="col-2 border border-1">
                                        Доставлено
                                    </div>
                                </div>
                            @endif
                                <div class="row">
                                    <div class="col-4 border border-1">
                                        {{\App\Models\Mailing::query()->where('id', $key)->value('mailing_name')}}
                                    </div>
                                    <div class="col-2 border border-1">
                                        @if(\App\Models\Mailing::query()->where('id', $key)->value('mailing_type') == 2)
                                            Разовая
                                        @else
                                            Работает
                                        @endif

                                    </div>
                                    <div class="col-2 border border-1">
                                        {{$value['all']}}
                                    </div>
                                    <div class="col-2 border border-1">
                                        {{$value['yes']}}
                                    </div>
                                </div>

                        @empty
                            <div class="row">
                                <div class="col-12 text-center">
                                    Рассылок не найденно
                                </div>
                            </div>
                        @endforelse
    </div>

@endsection
