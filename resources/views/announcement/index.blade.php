@extends('layouts.app')

@section('title')Lista ogłoszeń @endsection

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-center mb-3">
                <ul class="nav nav-pills">
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link border {{ str_contains(url()->current(), $category->name) ? 'active' : '' }}"
                                aria-current="page"
                                href="{{ route('category.show', $category->name) }}">{{ Str::upper($category->name) }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="row">

                @foreach ($announcements as $announcement)
                    <div class="col-md-4 mb-3">
                        <div
                            class="card border text-center h-100 {{ $announcement->user->reputation >= 10 ? 'border-success' : '' }} {{ $announcement->user->scammer == true ? 'border-danger' : '' }}">
                            <div class="card-header">
                                <img src="{{ $announcement->category()->image }}" class="img-fluid" height="300"
                                    width="300" />
                                Hosting <a href="{{ $announcement->category()->url }}"><span
                                        class="fw-bold">{{ Str::upper($announcement->category()->name) }}</span></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    {!! $announcement->type === 1 ? '<span class="badge bg-success">Kupię</span>' : '<span class="badge bg-info">Sprzedam</span>' !!}
                                    <br /><br />
                                    {{ $announcement->title }}
                                </h5>
                                <p class="card-text">
                                <h5 class="text-bold">
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
                                <h6 class="text-bold">
                                    @if ($announcement->cost)
                                        {{ $announcement->cost }} zł / 1 PLN PRZELICZNIK
                                    @else
                                        Bez przelicznika
                                    @endif
                                </h6>
                                </p>
                                <a href="{{ route('announcement.show', $announcement) }}"
                                    class="btn btn-primary">Zobacz</a>

                            </div>
                            <div class="card-footer text-muted">
                                {!! $announcement->user->scammer == true ? '<button class="btn btn-danger btn-sm mb-2"><i class="fas fa-exclamation-circle"></i> &nbsp;Użytkownik oznaczony jako oszust</button>' : '' !!}
                                <br />
                                <span class="badge bg-dark">{{ $announcement->created_at->diffForHumans() }}</span>
                                &nbsp;
                                przez <span class="fw-bold"><a
                                        href="{{ route('uzytkownik.show', $announcement->user) }}">{{ $announcement->user->name }}</a>
                                    @if ($announcement->user->is_vip)
                                        <span class="badge bg-warning"><i class="far fa-gem"></i> VIP</span>
                                    @endif
                                    {!! $announcement->user->reputation >= 10 ? '<span class="badge bg-success"><i class="far fa-thumbs-up"></i> Dobra reputacja</span>' : '' !!}
                                </span>

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
