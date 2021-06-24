@if (Request::segment(1) !== 'uzytkownik')
    <div class="card text-center">
        <div class="card-body">
            <p class="card-text">
            <div class="text-center">
                <i class="bi bi-exclamation-circle d-block mx-auto" style="font-size: 64px;"></i>
                <h1 class="display-5 fw-bold">Uważaj</h1>
                <div class="col-lg-12 mx-auto">
                    <p class="lead mb-4">Pamiętaj, że <span class="fw-bold">{{ config('app.name', 'Laravel') }}</span>
                        nie odpowiada za ogłoszenia tutaj zamieszczone i wszelkie informacje w nich zawarte są treścią
                        dodaną przez użytkowników.</p>
                </div>
            </div>
        </div>
    </div>
@else
    @if (auth()->user()->is_admin)
        <div class="card text-center border border-danger mb-5">
            <div class="card-header fs-5"><i class="fas fa-tools"></i> Administrator</div>
            <div class="card-body">
                <p class="card-text">
                <div class="text-center">
                    <p>
                    <div class="btn-group" role="group" aria-label="">
                        <form method="POST" action="{{ route('uzytkownik.destroy', $user) }}" onsubmit="return confirm ('Czy jesteś pewny?')" class="form-inline">
                            @method("DELETE")

                            @csrf

                            <button type="submit" class="btn btn-danger btn-sm m-1"><i class="fas fa-minus-circle"></i>
                                Usuń</button>
                        </form>
                        <form method="POST" action="{{ route('uzytkownik.hide', $user) }}" onsubmit="return confirm ('Czy jesteś pewny?')" class="form-inline">

                            @csrf

                            <button type="submit" class="btn btn-dark btn-sm m-1"><i class="fas fa-trash-alt"></i> Ukryj
                                ogłoszenia</button>
                        </form>
                    </div>
                    <div class="btn-group" role="group" aria-label="">
                        <form method="POST" action="{{ route('uzytkownik.scammer', $user) }}" onsubmit="return confirm ('Czy jesteś pewny?')" class="form-inline">

                            @csrf

                            <button type="submit" class="btn btn-danger btn-sm m-1"><i class="fas fa-stamp"></i>
                                Oznacz jako oszusta</button>
                        </form>
                        <form method="POST" action="{{ route('uzytkownik.vip', $user) }}" class="form-inline">

                            @csrf

                            <button type="submit" class="btn btn-warning btn-sm m-1"><i class="far fa-gem"></i>
                                Ustaw status VIP</button>
                        </form>

                    </div>
                    </p>
                </div>
            </div>
        </div>
    @endif


    <div class="card text-center">
        <div class="card-header fs-5"><i class="fas fa-phone-square-alt"></i> Kontakt</div>
        <div class="card-body">
            <p class="card-text text-center">
                @if ($user->is_vip)
                    {!! $user->contact ? $user->contact : 'Użytkownik nie uzupełnił jeszcze pola kontaktu.' !!}
                @else
                    {!! $user->contact ? nl2br(linkify(strip_tags($user->contact))) : 'Użytkownik nie uzupełnił jeszcze pola kontaktu.' !!}
                @endif
                @if (auth()->user()->is_admin)
                    <br />
                    <br />
                    <label>E-Mail</label>
                    <input type="text" value="{{ $user->email }}" readonly class="form-control" />
                @endif
            </p>
        </div>
    </div>


@endif
