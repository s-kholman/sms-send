@extends('layouts.base')
@section('title', 'Создание рассылки')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

            </div>
        </div>

        <div class="row p-4">
            <div class="col-2">
                <form action="{{route('analytical.between')}}" method="post">
                    @csrf
                    <input hidden name="type" value="1">
                    <input class="form-control @error('between') is-invalid @enderror" type="date" name="between"
                           value="{{\Carbon\Carbon::parse($between)->format('Y-m-d')}}">
                    <input class="form-control @error('date') is-invalid @enderror" type="date" name="date"
                           value="{{\Carbon\Carbon::parse($end_date)->format('Y-m-d')}}">
                    <input class="form-control" type="submit" value="Показать">
                </form>
            </div>

            <div class="col-2">
                <form action="{{route('analytical.between')}}" method="post">
                    @csrf
                    <input hidden name="between" value="{{\Carbon\Carbon::now()->subWeek()->format('Y-m-d')}}">
                    <input class="btn btn-success" type="submit" value="за 7 дней">
                </form>
            </div>

            <div class="col-2">
                <form action="{{route('analytical.between')}}" method="post">
                    @csrf
                    <input hidden name="between" value="{{\Carbon\Carbon::now()->subMonth()->format('Y-m-d')}}">
                    <input class="btn btn-success" type="submit" value="за 30 дней">
                </form>
            </div>

            <div class="col-2">
                <form action="{{route('analytical.between')}}" method="post">
                    @csrf
                    <input hidden name="between" value="{{\Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')}}">
                    <input class="btn btn-success" type="submit" value="Текущий месяц">
                </form>
            </div>

            <div class="col-2 ">
                <form action="{{route('analytical.between')}}" method="post">
                    @csrf
                    <input hidden name="between" value="{{\Carbon\Carbon::now()->startOfQuarter()->format('Y-m-d')}}">
                    <input class="btn btn-success" type="submit" value="Текущий квартал">
                </form>
            </div>

            <div class="col-2 ">
                <form action="{{route('analytical.between')}}" method="post">
                    @csrf
                    <input hidden name="between" value="{{\Carbon\Carbon::now()->startOfYear()->format('Y-m-d')}}">
                    <input class="btn btn-success" type="submit" value="Текущий год">
                </form>
            </div>
        </div>

        @forelse($analytical as $key => $value)
            @if($loop->first)
                <div class="row text-center">
                    <div class="row mb-4">
                        <div class="col-8">
                            <h4>Список рассылок пользователя</h4>
                        </div>
                    </div>
                    <div class="col-4 border border-1">
                        Наименование
                    </div>
                    <div class="col-2 border border-1">
                        Статус
                    </div>
                    <div class="col-2 border border-1">
                        Запуск на
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-4 border border-1">
                    {{$value['name']}}
                </div>
                <div class="col-2 border border-1">
                    @if($value['cron']->status)
                        Работает
                    @else
                        Отключена
                    @endif

                </div>
                <div class="col-2 border border-1">
                    @if($value['cron']->status)

                        {{\Illuminate\Support\Carbon::parse($value['cron']->run_date)->format('d-m-Y H:i')}}
                    @else
                        Запуск не запланирован
                    @endif
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-12 text-center">
                    Рассылок не найденно
                </div>
            </div>
        @endforelse



        @forelse($analytical as $item)
            @if($loop->first)
                <div class="row mb-4"></div>
                <div class="row mb-4">
                    <div class="col-8 text-center">
                        <h4>Аналитика рассылок</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                @if(!empty($item['count']) && $item['count'] > 0)
                    <div class="col-12">
                        <b>{{$item['name']}}</b> - отправленно: <b>{{$item['count']}}</b>, доставленно: <b>{{$item['send']}}</b>
                    </div>
                @endif
            </div>

        @empty
        @endforelse

    </div>

@endsection
