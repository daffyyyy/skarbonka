@extends('layouts.app')

@section('title')Dodaj ogłoszenie @endsection

@section('content')
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('ogloszenie.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tytuł') }}</label>

                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Opis') }}</label>

                                <textarea id="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror" name="description"
                                    required autocomplete="description" autofocus>{{ old('description') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contact"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Kontakt') }}</label>

                                <textarea id="contact" type="text"
                                    class="form-control @error('contact') is-invalid @enderror" name="contact" required
                                    autocomplete="contact" autofocus>{{ old('contact') }}</textarea>

                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Ilość') }}</label>

                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror"
                                    name="amount" value="{{ old('amount') }}" required autofocus>

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cost"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cena za 1 WPLN') }}</label>

                                <input id="cost" type="number" step=".01"
                                    class="form-control @error('cost') is-invalid @enderror" name="cost"
                                    value="{{ old('cost') }}" required autofocus>

                                @error('cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Kategoria') }}</label>

                                <select id="category_id" type="number"
                                    class="form-control @error('category_id') is-invalid @enderror" name="category_id" required
                                    autofocus>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="row">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Dodaj') }}
                                </button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
@endsection
