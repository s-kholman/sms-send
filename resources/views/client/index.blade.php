@extends('layouts.base')
@section('title', 'Список клиентов')
@section('content')

    <div class="container">

        <form class="d-flex mb-4" action="{{route('clients.search')}}" method="post">
            @csrf
            <input class="form-control me-2 @error('search') is-invalid @enderror"
                   name="search"
                   type="search"
                   placeholder="Поиск"
                   aria-label="Найти"
                   value="@if(!empty($search)){{$search}}@endif"
            >

            <button class="btn btn-outline-success" type="submit">Найти</button>

        </form>

        <div class="row  mb-4">
            <div class="col-md-12 ">
                Клиентов: {{$count}} <a href="/client/load" class="btn btn-success">Добавить</a>
            </div>
        </div>

        <div class="row m-4">

                @forelse($clients as $client)
                @if($loop->first)
                    <div class="row">
                        <div class="col-2 text-center border border-1">
                            <form action="{{route('clients.sort')}}" method="post">
                                @csrf
                                <input hidden name="sort" value="phone">
                                <input class="btn btn-link" type="submit" value="Телефон">
                            </form>

                        </div>
                        <div class="col-3 text-center border border-1">
                            <form action="{{route('clients.sort')}}" method="post">
                                @csrf
                                <input hidden name="sort" value="clientFullName">
                                <input class="btn btn-link" type="submit" value="ФИО">
                            </form>
                        </div>
                        <div class="col-2 text-center border border-1">
                            <form action="{{route('clients.sort')}}" method="post">
                                @csrf
                                <input hidden name="sort" value="birth">
                                <input class="btn btn-link" type="submit" value="Дата рождения">
                            </form>

                        </div>
                        <div class="col-3 text-center border border-1">
                            <form action="{{route('clients.sort')}}" method="post">
                                @csrf
                                <input hidden name="sort" value="created_at">
                                <input class="btn btn-link" type="submit" value="Дата добавления">
                            </form>

                        </div>
                    </div>
                @endif
                    <div class="row">
                        <div class="col-2 text-center border border-1">
                            {{$client->phone}}
                        </div>
                        <div class="col-3 text-center border border-1">
                            {{$client->clientFullName}}
                        </div>
                        <div class="col-2 text-center border border-1">
                            @if($client->birth <> null)
                                {{\Illuminate\Support\Carbon::parse($client->birth)->format('d.m.Y')}}
                            @endif
                        </div>
                        <div class="col-3 text-center border border-1">
                            {{\Illuminate\Support\Carbon::parse($client->created_at)->format('d.m.Y')}}
                        </div>
                    </div>

                @empty
                <div class="row m-4">
                    <div class="col-12 text-center">
                        Записей не найдено
                    </div>
                </div>
                @endforelse
            <div class="row m-4">
                <div class="col-12 text-center">
                    {{$clients->links()}}
                </div>
            </div>

        </div>

    </div>
@endsection
