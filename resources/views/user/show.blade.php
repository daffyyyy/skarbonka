@extends('layouts.app')

@section('title')Profil {{ $user->name }} @endsection

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            @if ($user->scammer == true)
                <div class="text-center mb-2">
                    <span class="badge bg-danger"><i class="fas fa-exclamation-circle"></i> &nbsp;Użytkownik oznaczony jako
                        oszust</span>
                </div>
            @endif
            <div class="row text-center justify-content-md-center">
                <div class="col col-md-3 fs-5">
                    <i class="fas fa-thumbs-up"></i> Reputacja <span class="badge bg-success">{{ $user->reputation }} <a
                            href="{{ route('uzytkownik.addReputation', $user) }}"
                            class="text-white fs-5 text-center ">+</a>
                </div>
                <div class="col-md-auto">
                    <span class="fs-1 fw-bold">
                        {!! getUserName($user, false) !!}

                        @if ($user->is_admin)
                            <span class="badge bg-danger fs-6 align-middle"><i class="fas fa-shield-alt"></i> ADMIN</span>
                        @endif

                        @if ($user->is_vip)
                            <span class="badge bg-warning fs-6 align-middle"><i class="far fa-gem"></i> VIP</span>
                        @endif

                        @if ($user->is_bot)
                            <span class="badge bg-info fs-6 align-middle"><i class="fas fa-robot"></i> BOT</span>
                        @endif

                        {!! $user->reputation >= 10 ? '<span class="badge bg-success fs-6 align-middle"><i class="far fa-thumbs-up"></i> Dobra reputacja</span>' : '' !!}
                    </span>
                </div>
                <div class="col col-md-3 fs-5">
                    <i class="fas fa-bullhorn"></i> Ogłoszeń <span
                        class="badge bg-dark align-middle">{{ $announcements->total() }}</span>
                </div>
            </div>

            @if ($user->id === auth()->id())
                <div class="row mt-5">
                    <span class="fs-5 mb-2"><i class="fas fa-phone-square-alt"></i> Kontakt</span>
                    <div class="col-md-12 mb-3">
                        <div class="card border text-center h-100">
                            <div class="card-body">
                                <p class="card-text">
                                <form action="{{ route('uzytkownik.updateContact') }}" method="post">

                                    @csrf

                                    <textarea name="contact"
                                        class="form-control tinymce-editor">{{ $user->contact }}</textarea>
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Zapisz</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row mt-5">
                <span class="fs-5 mb-2"><i class="fas fa-archive"></i> Historia ogłoszeń <sup>Aktywne <span
                            class="badge bg-dark">{{ $announcements_active }}</span></sup></span>
                @foreach ($announcements as $announcement)
                    <div class="col-md-4 mb-3">
                        <div
                            class="card border text-center h-100 {{ $announcement->deleted_at ? 'border-warning' : '' }}">
                            <div class="card-header">
                                <img src="{{ $announcement->category()->image }}" class="img-fluid" height="300"
                                    width="300" />
                                Kategoria <a href="{{ $announcement->category()->url }}"><span
                                        class="fw-bold">{{ Str::upper($announcement->category()->name) }}</span></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $announcement->title }}</h5>
                                <p class="card-text">

                                <h5 class="text-bold">{{ $announcement->amount }}
                                    WPLN<sup>{{ $announcement->amount * $announcement->cost }} zł</sup></h5>
                                <h6 class="text-bold">{{ $announcement->cost }} PRZELICZNIK</h6>
                                </p>
                                @if (!$announcement->deleted_at)
                                    <a href="{{ route('announcement.show', $announcement) }}"
                                        class="btn btn-primary">Zobacz</a>
                                @endif
                            </div>
                            <div class="card-footer text-muted">
                                @if ($announcement->deleted_at)
                                    <span class="badge bg-warning">Ogłoszenie archiwalne</span>
                                    <br />
                                @endif
                                <span class="badge bg-dark">{{ $announcement->created_at->diffForHumans() }}</span>
                            </div>

                        </div>

                    </div>
                @endforeach

                {{-- Pagination --}}
                @if ($announcements->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $announcements->links() }}
                    </div>
                @endif
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
                image_class_list: [{
                    title: 'Responsive',
                    value: 'img-fluid'
                }],
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
