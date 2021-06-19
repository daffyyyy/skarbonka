@extends('layouts.app')

@section('title')Lista ogłoszeń @endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center mb-3">
                <ul class="nav nav-pills">
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link border"
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
                            class="card text-center h-100 {{ $announcement->user->scammer == true ? 'border border-danger' : '' }}">
                            <div class="card-header">
                                <img src="{{ $announcement->category()->image }}" class="img-fluid"
                                    style="height: 100px;" />
                                Hosting <a href="{{ $announcement->category()->url }}"><span
                                        class="fw-bold">{{ Str::upper($announcement->category()->name) }}</span></a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $announcement->title }}</h5>
                                <p class="card-text">

                                <h5 class="text-bold">{{ $announcement->amount }}
                                    WPLN<sup>{{ $announcement->amount * $announcement->cost }} zł</sup></h5>
                                <h6 class="text-bold">{{ $announcement->cost }} PRZELICZNIK</h6>
                                </p>
                                <a href="{{ route('ogloszenie.show', $announcement) }}"
                                    class="btn btn-primary">Zobacz</a>

                            </div>
                            <div class="card-footer text-muted">
                                {!! $announcement->user->scammer == true ? '<button class="btn btn-danger btn-sm mb-2"><i class="fas fa-exclamation-circle"></i> &nbsp;Użytkownik oznaczony jako oszust</button>' : '' !!}
                                <br />
                                <span class="badge bg-dark">{{ $announcement->created_at->diffForHumans() }}</span>
                                przez <span class="fw-bold">{{ $announcement->user->name }}</span>

                            </div>

                        </div>

                    </div>
                @endforeach

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $announcements->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
