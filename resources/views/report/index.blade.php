@extends('layouts.base')
@section('title', 'Список клиентов')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <form action="{{route('report.find')}}" method="post">
                    @csrf
                    <label for="date">Выберите дату</label>
                    <input class="form-control" type="date" name="date" id="date" value="{{date('Y-m-d')}}">
                    <input class="btn btn-success" type="submit" value="Найти">
                </form>
            </div>
       </div>
        <div class="row">

                @if($post == 1)
                    @forelse($result as $key => $value)
                    <div class="col">
                        Рассылка: <b>{{\App\Models\Mailing::query()->find($key)->value('mailing_name')}}</b> <br />
                        Отправленно SMS: {{count( !empty($value['failed']) ? $value['failed'] : [] ) + count( !empty($value['send']) ? $value['send'] : [] ) }} <br />
                        Доставленно SMS: {{count( !empty($value['send']) ? $value['send'] : [] ) }}<br />
                        <hr>
                    </div>
                    @empty
                    @endforelse

                @endif

        </div>
    </div>
@endsection
