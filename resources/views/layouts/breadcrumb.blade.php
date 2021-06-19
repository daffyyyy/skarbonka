<nav class="navbar navbar-expand-lg navbar-light bg-light border border-red">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Strona główna</a></li>
                @switch(Request::segment(1))

                    @case('category')
                    <li class="breadcrumb-item"><a href="{{ route('ogloszenie.index') }}">Ogłoszenia</a></li>
                    <li class="breadcrumb-item active fw-bold" aria-current="page">{{ ucfirst(Request::segment(2)) }}</li>
                        @break
                    @case('ogloszenie')
                    @if (Request::segment(2))
                        <li class="breadcrumb-item"><a href="{{ route('ogloszenie.index') }}">Ogłoszenia</a></li>
                            <li class="breadcrumb-item active fw-bold">{{ Request::segment(2) == 'create' ? 'Dodaj ogłoszenie' : ucfirst(Request::segment(2)) }}</li>
                            @else
                            <li class="breadcrumb-item active fw-bold"><a href="{{ route('ogloszenie.index') }}">Ogłoszenia</a></li>
                        @endif
                        @break
                    @default
                        
                @endswitch
                
            </ol>
        </nav>
    </div>
</nav>