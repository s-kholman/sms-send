@extends('layouts.base')
@section('title', 'Создание отдела')
@section('content')

    <div class="row">
        <div class="col-md-3">
            <form action="{{route('department.store')}}" method="post">
                @csrf
                <div class="col ml-3">
                    <label class="form-label" for="name">Введите название отдела</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                           value="{{old('name')}}"
                           name="name">
                    @error('name')
                    <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-3 m-4">
                    <input class="btn btn-success " type="submit" value="Сохранить">
                </div>

            </form>

        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @forelse($departments as $department)
                    <div >
                        {{$department->name}}
                    </div>

                @empty
                    Записей не обнаруженно
                @endforelse
            </div>
        </div>
    </div>
@endsection
