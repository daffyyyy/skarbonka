@extends('layouts.app')

@section('title')Dodaj ogłoszenie @endsection

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    @if (auth()->user()->announcements->count() >= 5)
                        <div class="alert alert-danger" role="alert">
                            Maksymalna ilość ogłoszeń wynosi <span class="badge bg-dark text-white fs-7">5</span>
                        </div>
                    @else
                        <form method="POST" action="{{ route('announcement.store') }}">

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
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Opis') }}
                                    <sup class="text-muted">(VIP może używać HTML)</sup></label>

                                <textarea id="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror tinymce-editor"
                                    name="description" autocomplete="description" rows="4"
                                    cols="20">{{ old('description') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contact" class="col-md-4 col-form-label text-md-right">{{ __('Kontakt') }}
                                    <sup class="text-muted">(VIP może używać HTML)</sup></label>

                                <textarea id="contact" type="text"
                                    class="form-control @error('contact') is-invalid @enderror tinymce-editor"
                                    name="contact" autocomplete="contact" rows="4"
                                    cols="20">{{ old('contact') }}</textarea>

                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Ilość') }}</label>

                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                    <input id="amount" type="number"
                                        class="form-control @error('amount') is-invalid @enderror" name="amount"
                                        value="{{ old('amount') }}" autofocus>
                                </div>

                                <input type="checkbox" name="unlimited_amount" id="unlimited_amount" />
                                <label for="unlimited_amount"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Bez limitu') }}</label>

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cost"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cena za 1 WPLN') }}</label>

                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">$</span>
                                    <input id="cost" type="number" step=".01"
                                        class="form-control @error('cost') is-invalid @enderror" name="cost"
                                        value="{{ old('cost') }}" autofocus>
                                </div>

                                <input type="checkbox" name="unlimited_cost" id="unlimited_cost" />
                                <label for="unlimited_cost"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Bez limitu') }}</label>

                                @error('cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Typ') }}</label>

                                <select id="type" type="number" class="form-control @error('type') is-invalid @enderror"
                                    name="type" required autofocus>
                                    <option value="1">Kup</option>
                                    <option value="2">Sprzedaj</option>
                                </select>

                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="category_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Kategoria') }}</label>

                                <select id="category_id" type="number"
                                    class="form-control @error('category_id') is-invalid @enderror" name="category_id"
                                    required autofocus>
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

                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@if (auth()->user()->is_admin || auth()->user()->is_vip)

@section('scripts')
    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea.tinymce-editor',
            language: 'pl',
            height: 300,
            forced_root_block : false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
        });
    </script>
@endsection

@endif
