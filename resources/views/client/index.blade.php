@extends('layouts.base')
@section('title', 'Список клиентов')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                Список клиентов
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <form action="{{route('clients.upload')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="department">Выберите отдел/подразделение</label>
                        <select name="department" id="department" class="form-select @error('department') is-invalid @enderror">
                            @forelse($departments as $department)
                                @if($loop->first)
                                    <option selected value="{{ $department->id }}"> {{ $department->name }}  </option>
                                @else
                                    <option selected value="{{ $department->id }}"> {{ $department->name }}  </option>
                                @endif
                            @empty
                                <option value="">Значение не найдены</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="department">Выберите файл для загрузки</label>
                        <input class="form-control" type="file" name="clients">
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-info" type="submit" name="upload" value="Загрузить список клиентов">
                    </div>
                </form>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-12 text-center">
                Загрузка файла производится частями в фоновом режиме. Полная загрузка зависит от размера файла.
            </div>
        </div>

        <div class="row m-4">

                @forelse($clients as $client)
                @if($loop->first)
                    <div class="row">
                        <div class="col-2 text-center border border-1">
                            Телефон
                        </div>
                        <div class="col-3 text-center border border-1">
                            ФИО
                        </div>
                        <div class="col-2 text-center border border-1">
                            Дата рождения
                        </div>
                        <div class="col-2 text-center border border-1">
                            Дата появления гостя в БД
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
                        <div class="col-2 text-center border border-1">
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
