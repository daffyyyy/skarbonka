@extends('layouts.app')

@section('title')Strona główna @endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">


            <div class="px-4 py-5 my-5 text-center">
                <img class="d-block mx-auto mb-4 img-fluid" height="200" width="200"
                    src="/img/logo.png"
                    alt="" />
                <h1 class="display-5">Witaj na <span class="fw-bold">{{ config('app.name', 'Laravel') }}</span></h1>
                <div class="col-lg-6 mx-auto">
                    <p class="lead mb-4"> {{ config('app.name', 'Laravel') }} to miejsce gdzie możesz zamieszczać
                        ogłoszenia kupna/sprzedaży wirtualnej gotówki na różnych serwisach. Poszukujesz wirtualnej gotówki
                        lub chcesz taką sprzedać? Załóż konto i wyszukuj okazji!</p>
                    @auth
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="{{ route('ogloszenie.index') }}" type="button" class="btn btn-light btn-lg px-4 gap-3">Lista ogłoszeń</a>
                            <a href="{{ route('ogloszenie.create') }}" type="button"
                                class="btn btn-dark btn-lg px-4 gap-3">Dodaj ogłoszenie</a>
                        </div>
                    @endauth
                    @guest
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="{{ route('login') }}" type="button" class="btn btn-success btn-lg px-4 gap-3">Zaloguj
                                się</a>
                            <a href="{{ route('register') }}" type="button"
                                class="btn btn-warning btn-lg px-4 gap-3">Zarejestruj się</a>
                        </div>
                    @endguest
                </div>
            </div>



        </div>
    </div>
@endsection
