@extends('layouts.base')
@section('title', 'Интеграция с SMSC')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form action="{{route('smsc.store')}}" method="post" >
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="login">Логин</label>
                        <input class="form-control" type="text" name="login" id="login">
                        <label class="form-label" for="api_key">API ключ</label>
                        <input class="form-control" type="text" name="api_key" id="api_key">
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-info" type="submit" name="store" value="Сохранить">
                    </div>
                </form>
                <div class="mb-3">
                    <label class="form-label">{{$check}}</label>
                </div>
            </div>
        </div>
    </div>
@endsection
