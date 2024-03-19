@extends('layouts.base')
@section('title', 'Список клиентов')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4">
                <form action="{{route('test')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <input class="btn btn-success" type="submit" value="TEST">
                    </div>

                </form>
            </div>
       </div>

    </div>
@endsection
