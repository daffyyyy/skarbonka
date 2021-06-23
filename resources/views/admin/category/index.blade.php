@extends('layouts.app')

@section('title')Utwórz kategorię @endsection

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    <button data-bs-toggle="modal" data-bs-target="#createCategory" class="btn btn-success">Utwórz
                        kategorię</button>

                    <div class="table-responsive mt-3">
                        <table class="table align-middle">
                            <thead>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Link</th>
                                <th scope="col">Obrazek</th>
                                <th scope="col">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td><a href="{{ $category->url }}">{{ $category->url }}</a></td>
                                        <td><img src="{{ $category->image }}" class="img-fluid" width="110" /></td>
                                        <td>
                                            <form action="{{ route('admin.category.destroy', $category) }}" method="post">
                                                @method('DELETE')

                                                @csrf

                                                <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#editCategory-{{ $category->id }}" id="editCategory"
                                                    data-id="{{ $category->id }}"
                                                    class="btn btn-warning btn-sm">Edytuj</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createCategory" tabindex="-1" aria-labelledby="createCategory" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.category.store') }}">

                        @csrf

                        <div class="mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nazwa') }}</label>

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="url" class="col-md-4 col-form-label text-md-right">{{ __('Link') }}</label>

                            <input id="url" type="url" class="form-control @error('url') is-invalid @enderror" name="url"
                                value="{{ old('url') }}" required autocomplete="url" autofocus>

                            @error('url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Obrazek') }}</label>

                            <input id="image" type="url" class="form-control @error('image') is-invalid @enderror"
                                name="image" value="{{ old('image') }}" required autocomplete="image" autofocus>

                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                    <button type="submit" class="btn btn-primary">Dodaj</button>
                </div>

            </div>
            </form>
        </div>
    </div>

    @foreach ($categories as $category)
        <div class="modal fade" id="editCategory-{{ $category->id }}" tabindex="-1"
            aria-labelledby="editCategory-{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.category.put', $category) }}">
                            @method('PUT')

                            @csrf

                            <div class="mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nazwa') }}</label>

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $category->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="url" class="col-md-4 col-form-label text-md-right">{{ __('Link') }}</label>

                                <input id="url" type="url" class="form-control @error('url') is-invalid @enderror"
                                    name="url" value="{{ $category->url }}" required autocomplete="url" autofocus>

                                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Obrazek') }}</label>

                                <input id="image" type="url" class="form-control @error('image') is-invalid @enderror"
                                    name="image" value="{{ $category->image }}" required autocomplete="image" autofocus>

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                        <button type="submit" class="btn btn-primary">Dodaj</button>
                    </div>

                </div>
                </form>
            </div>
        </div>
    @endforeach

@endsection
