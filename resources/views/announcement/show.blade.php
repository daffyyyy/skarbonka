@extends('layouts.app')

@section('title') {{ $announcement->title }} @endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($announcement->user->scammer == true)
                <div class="text-center mb-2 border p-2">
                    <button class="btn btn-danger btn-sm"><i class="fas fa-exclamation-circle"></i> &nbsp;Użytkownik
                        oznaczony jako oszust</button>
                </div>
            @endif
            <div class="text-center border p-2">dodane przez
                <span class="fw-bold">
                    {!! getUserName($announcement->user) !!}
                </span>
                <span class="badge bg-dark">{{ $announcement->created_at->diffForHumans() }}</span>
            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="card text-center {{ $announcement->user->scammer == true ? 'border-danger' : '' }}">
                        <div class="mt-3">
                            <img src="{{ $announcement->category()->image }}" class="img-fluid" height="500"
                                width="500" />
                            <br />
                            Kategoria <a href="{{ $announcement->category()->url }}"><span
                                    class="fw-bold">{{ Str::upper($announcement->category()->name) }}</span></a>
                        </div>
                        <div class="card-body">
                            <h3 class="card-header mb-3 fw-bold">Informacje</h3>
                            <h4 class="card-title">
                                {!! $announcement->type === 1 ? '<span class="badge bg-success">Kupię</span>' : '<span class="badge bg-info">Sprzedam</span>' !!}
                                <br />
                                <br />
                                {{ $announcement->title }}
                            </h4>
                            <p class="card-text">
                                @if ($announcement->user->is_vip)
                                    {!! nl2br($announcement->description) !!}
                                @else
                                    {!! nl2br(strip_tags($announcement->description)) !!}
                                @endif
                            <div class="d-flex justify-content-center mb-3">
                                <h5 class="text-bold"><span class="badge bg-dark text-light">
                                        @if ($announcement->amount)
                                            {{ $announcement->amount }} WPLN
                                            @if ($announcement->cost)
                                                <sup>
                                                    {{ $announcement->cost * $announcement->amount }} zł
                                                </sup>
                                            @endif
                                        @else
                                            Bez limitu
                                        @endif
                                    </span>
                                </h5>
                                <h5 class="text-bold"><span class="badge bg-success text-light">
                                        @if ($announcement->cost)
                                            {{ $announcement->cost }} zł / 1 WPLN
                                        @else
                                            Brak
                                        @endif
                                    </span></h5>
                            </div>
                            <h3 class="card-header mb-3 fw-bold">Kontakt</h3>
                            @if ($announcement->user->is_vip)
                                {!! nl2br($announcement->contact) !!}
                            @else
                                {!! nl2br(linkify(strip_tags($announcement->contact))) !!}
                            @endif
                            </p>
                        </div>
                    </div>
                    @if ($announcement->user_id === auth()->id() || auth()->user()->is_admin)
                        <div class="row mt-3">
                            <div class="d-flex justify-content-center">
                                <div class="card-header">Akcje</div>

                                <button data-bs-toggle="modal" data-bs-target="#editAnnon"
                                    class="btn btn-warning">Edytuj</button>
                                <form method="POST" action="{{ route('announcement.destroy', $announcement) }}"
                                    onsubmit="return confirm ('Czy jesteś pewny?')" class="row g-1">
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
    <div class="modal fade" id="editAnnon" tabindex="" aria-labelledby="editAnnon" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAnnon">Edytuj ogłoszenie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('announcement.put', $announcement) }}">

                        @method('PUT')

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
                                class="form-control @error('description') is-invalid @enderror tinymce-editor"
                                name="description" required autocomplete="description"
                                autofocus>{{ $announcement->description }}</textarea>

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
                                class="form-control @error('contact') is-invalid @enderror tinymce-editor" name="contact"
                                autocomplete="contact" autofocus>{{ $announcement->contact }}</textarea>

                            @error('contact')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Ilość') }}</label>

                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">$</span>
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror"
                                    name="amount" value="{{ $announcement->amount }}" autofocus>
                            </div>

                            <input type="checkbox" name="unlimited_amount" id="unlimited_amount" @if (!$announcement->amount) checked @endif />
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
                                    value="{{ $announcement->cost }}" autofocus>
                            </div>

                            <input type="checkbox" name="unlimited_cost" id="unlimited_cost" @if (!$announcement->cost) checked @endif />
                            <label for="unlimited_cost"
                                class="col-md-4 col-form-label text-md-right">{{ __('Bez limitu') }}</label>

                            @error('cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
                </form>
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
                forced_root_block: false,
                image_class_list: [
                    { title: 'Responsive', value: 'img-fluid' }
                ],
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
            $('iframe').addClass('embed-responsive embed-responsive-1by1');
        </script>

    @endsection

@endif
