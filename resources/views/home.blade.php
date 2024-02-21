@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Добро пожаловать</div>
                <div class="card-body">
                    {{\Illuminate\Support\Facades\Auth::user()->name}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
