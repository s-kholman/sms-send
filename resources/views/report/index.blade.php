@extends('layouts.base')
@section('title', 'Список клиентов')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4">
                <form action="{{route('report.index')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="date">Выберите дату</label>
                        <input class="form-control" type="date" name="date" id="date" value="{{\Carbon\Carbon::parse($date)->format('Y-m-d')}}">
                    </div>

                    <div class="mb-3">
                        <input class="btn btn-success" type="submit" value="Найти">
                    </div>

                </form>
            </div>
       </div>
        <div class="row">
                @if($post == 1)
                    @forelse($result as $key => $value)
                    <div class="col">
                        Рассылка: <b>{{\App\Models\Mailing::query()->where('id', $key)->value('mailing_name')}}</b> <br />
                        Отправленно SMS: {{$value['all']}} <br />
                        Доставленно SMS: {{$value['yes']}}<br />
                        <hr>
                    </div>
                    @empty
                    @endforelse
                @endif
        </div>
    </div>
@endsection
