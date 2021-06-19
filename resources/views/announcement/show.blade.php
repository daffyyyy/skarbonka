@extends('layouts.app')

@section('title') {{ $announcement->title }} @endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($announcement->user->scammer == true)
            <div class="text-center mb-2 border p-2">
                <button class="btn btn-danger btn-sm"><i class="fas fa-exclamation-circle"></i> &nbsp;Użytkownik oznaczony jako oszust</button>
            </div>
            @endif
            <div class="text-center border p-2">dodane przez <span class="fw-bold">{{ $announcement->user->name }}</span> <span class="badge bg-dark">{{ $announcement->created_at->diffForHumans() }}</span></div>

            <div class="row">

                <div class="col-md-12">

                    <div class="card text-center {{ $announcement->user->scammer == true ? 'border-danger' : '' }}">
                        <div>
                            <img src="{{ $announcement->category()->image }}" class="img-fluid" />
                            <br />
                            Hosting <a href="{{ $announcement->category()->url }}"><span class="fw-bold">{{ Str::upper($announcement->category()->name) }}</span></a>
                        </div>
                        <div class="card-body">
                            <h3 class="card-header mb-3 fw-bold">Informacje</h3>
                            <h4 class="card-title">{{ $announcement->title }}</h4>
                            <p class="card-text">
                                {{ $announcement->description }}
                            <div class="d-flex justify-content-center mb-3">
                                <h5 class="text-bold"><span class="badge bg-info text-dark">{{ $announcement->amount }}
                                        WPLN<sup>{{ $announcement->cost * $announcement->amount }} zł</sup></span></h5>
                                <h5 class="text-bold"><span class="badge bg-warning text-dark">{{ $announcement->cost }}
                                        zł
                                        / 1 WPLN</span></h5>
                            </div>
                            <h3 class="card-header mb-3 fw-bold">Kontakt</h3>
                            {!! nl2br($announcement->contact) !!}
                            </p>
                        </div>
                    </div>
                    @if ($announcement->user_id === auth()->id())
                    <div class="row mt-3">
                        <div class="d-flex justify-content-center">
                            <div class="card-header">Akcje</div>
                            
                                <button id="addTransaction" class="btn btn-success">Dodaj transakcje</button>
                                <button data-bs-toggle="modal" data-bs-target="#editAnnon"
                                    class="btn btn-warning">Edytuj</button>
                                <form method="POST" action="{{ route('ogloszenie.destroy', $announcement) }}"
                                    class="row g-1">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Zakończ</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>


    {{-- Modals --}}
    <div class="modal fade" id="editAnnon" tabindex="-1" aria-labelledby="editAnnon" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAnnon">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('ogloszenie.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tytuł') }}</label>

                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                name="title" value="{{ $announcement->title }}" required autocomplete="title" autofocus>

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
                                class="form-control @error('description') is-invalid @enderror" name="description" required
                                autocomplete="description" autofocus>{{ $announcement->description }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contact"
                                class="col-md-4 col-form-label text-md-right">{{ __('Kontakt') }}</label>

                            <textarea id="contact" type="text" class="form-control @error('contact') is-invalid @enderror"
                                name="contact" required autocomplete="contact" autofocus>{{ $announcement->contact }}</textarea>

                            @error('contact')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Ilość') }}</label>

                            <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror"
                                name="amount" value="{{ $announcement->amount }}" required autofocus>

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
                                value="{{ $announcement->cost }}" required autofocus>

                            @error('cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                    <button type="button" class="btn btn-primary">Zapisz</button>
                </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

@endsection
