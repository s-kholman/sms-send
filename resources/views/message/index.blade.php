@extends('layouts.base')
@section('title', 'Создание рассылки')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                Запланировать рассылку
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <form action="{{route('message.store')}}" method="post">
                    @csrf
                    <div class="col ml-3">
                        <label class="form-label" for="name">Название рассылки</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                               value="{{old('name')}}"
                               name="name">
                        @error('name')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <label class="form-label" for="text">Текст рассылки</label>
                        <textarea class="form-control @error('text') is-invalid @enderror" name="text">{{old('mailing_text')}}</textarea>
                        @error('text')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col text-center g-4">
                        <label class="form-label "></label>
                    </div>
                    <div class="row">
                        <div class="form-switch form-check col-4">
                            <input class="form-check-input" type="radio" id="type" name="type" value="1"
                                   checked>
                            <label class="form-label" for="type">День рождение</label>
                        </div>
                        <div class="col-2">
                            <label class="form-label" for="birth_time">Время отправки</label>
                            <input class="form-control" type="time" id="birth_time" name="birth_time">
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="birth_to_day">За сколлько дней до ДР</label>
                            <input class="form-control @error('birth_to_day') is-invalid @enderror"
                                   type="number"
                                   step="1"
                                   name="birth_to_day"
                                   id="birth_to_day"
                                   value="{{old('mailing_to_day') ?? 0}}">
                            @error('birth_to_day')
                            <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                 {{--   <div class="row g-6">
                        <div class="form-switch form-check mb-7 col-3">
                            <input class="form-check-input" type="radio" id="mailing_today" name="mailing_type"
                                   value="2">
                            <label class="form-label" for="mailing_today">Немедленная отправкаSMS</label>
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="">Подразделение</label>
                            <select class="form-select" name="department" id="department">
                            @forelse($departments as $department)
                                @if($loop->first)
                                        <option value="0">Отправить все - {{$count}} SMS</option>
                                    @endif
                                    <option value="{{$department->id}}">{{$department->name}} - "к отправке
                                        {{\App\Models\Client::query()
                                                ->where('user_id', $department->user_id)
                                                ->where('department_id', $department->id)
                                                ->count()}}"
                                    </option>
                            @empty
                            @endforelse


                            </select>
                        </div>
                    </div>--}}
                    <input class="btn btn-success " type="submit" value="Сохранить">
                </form>

            </div>
        </div>
    </div>
@endsection
