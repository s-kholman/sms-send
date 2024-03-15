@extends('layouts.base')
@section('title', 'Создание рассылки')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                Создать рассылку
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <form action="{{route('mailing.store')}}" method="post">
                    @csrf
                    <div class="col ml-3">
                        <label class="form-label" for="mailing_name">Название рассылки</label>
                        <input class="form-control @error('mailing_name') is-invalid @enderror" type="text"
                               value="{{old('mailing_name')}}"
                               name="mailing_name">
                        @error('mailing_name')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <label class="form-label" for="mailing_text">Текст рассылки</label>
                        <textarea class="form-control @error('mailing_text') is-invalid @enderror" name="mailing_text">{{old('mailing_text')}}</textarea>
                        @error('mailing_text')
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
                            <input class="form-check-input" type="radio" id="mailing_type" name="mailing_type" value="1"
                                   checked>
                            <label class="form-label" for="mailing_type">День рождение</label>
                        </div>
                        <div class="col-3">
                            <input class="form-control" type="time" name="mailing_send_birth">
                        </div>
                        <div class="col-4">
                            <select class="form-control" name="mailing_to_day">
                                <option value="7">За семь дней до дня рождения</option>
                                <option value="5">За пять дней до дня рождения</option>
                                <option value="2">За два дня до дня рождения</option>
                                <option value="0">В день рождения</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-6">
                        <div class="form-switch form-check mb-3 ">
                            <input class="form-check-input" type="radio" id="mailing_today" name="mailing_type"
                                   value="2">
                            <label class="form-label" for="mailing_today">Немедленная отправка, {{$count}} SMS</label>
                        </div>
                    </div>
                    <input class="btn btn-success " type="submit" value="Сохранить">
                </form>
            </div>
        </div>
    </div>
@endsection
