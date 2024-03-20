@extends('layouts.base')
@section('title', 'Список клиентов')
@section('content')

    <div class="container">



        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <a href="/department">Добавить отдел/подразделение</a>
                </div>
                <form action="{{route('clients.upload')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="department">Выберите отдел/подразделение</label>
                        <select name="department" id="department" class="form-select @error('department') is-invalid @enderror">
                            @forelse($departments as $department)
                                @if($loop->first)
                                    <option selected value="{{ $department->id }}"> {{ $department->name }}  </option>
                                @else
                                    <option value="{{ $department->id }}"> {{ $department->name }}  </option>
                                @endif
                            @empty
                                <option value="">Значение не найдены</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="clients">Выберите файл для загрузки</label>
                        <input class="form-control @error('clients') is-invalid @enderror"
                               type="file"
                               id="clients"
                               name="clients"
                               accept=' .csv , .xls , .xlsx'
                        >
                        @error('clients')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-info" type="submit" name="upload" value="Загрузить список клиентов">
                    </div>
                </form>
            </div>
        </div>
        @if($error <> '')
        <div class="row m-4">
            <div class="col-12 text-center text-danger">
                {{$error}}
            </div>
        </div>
        @endif
        <div class="row m-4">
            <div class="col-12 text-center">
                Загрузка файла производится частями в фоновом режиме. Полная загрузка зависит от размера файла.
            </div>
        </div>



    </div>
@endsection
