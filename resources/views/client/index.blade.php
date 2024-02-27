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
            <div class="col-md-8">
                <form action="{{route('clients.upload')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control" type="file" name="clients">
                    <input class="btn btn-info" type="submit" name="upload" value="Загрузить список клиентов">
                </form>
            </div>
        </div>
    </div>
@endsection
