@extends('layouts.base')
@section('title', 'Список клиентов')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                Список клиентов
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <form action="{{route('clients.upload')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input class="form-control" type="file" name="clients">
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-info" type="submit" name="upload" value="Загрузить список клиентов">
                    </div>
                </form>
            </div>
            <form action="{{route('test')}}" method="post">
                @csrf
                <div class="mb-3">
                    <input class="btn btn-info" type="submit" name="test" value="Tets send sms">
                </div>
            </form>
        </div>
    </div>
@endsection
