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
            <div class="col-md-8">
                <form action="{{route('mailing.store')}}" method="post">
                    @csrf
                    <div class="col ml-3">
                        <label class="form-label" for="mailing_name">Название рассылки</label>
                        <input class="form-control" type="text" name="mailing_name">

                        <label class="form-label" for="mailing_text">Текст рассылки</label>
                        <textarea class="form-control" name="mailing_text"></textarea>
                    </div>

                    <div class="col text-center g-4">
                        <label class="form-label "></label>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <input class="form-check-input" type="radio" id="mailing_frequency" name="mailing_frequency" value="1" checked>
                            <label class="form-label" for="mailing_frequency">День рождение</label>
                        </div>
                        <div class="col-3">
                            <input class="form-control" type="time" name="mailing_send_time">
                        </div>
                        <div class="col-6">
                            <select class="form-control" name="mailing_to_day">
                                <option value="7">За семь дней до дня рождения</option>
                                <option value="5">За пять дней до дня рождения</option>
                                <option value="2">За два дня до дня рождения</option>
                                <option value="0">В день рождения</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                             <input class="form-check-input" type="radio" id="mailing_today" name="mailing_frequency" value="2" checked>
                             <label for="mailing_today">Немедленная отправка</label>
                        </div>
                    </div>
                    <input class="btn btn-success " type="submit" value="Сохранить">
                </form>
            </div>
        </div>
    </div>
@endsection
