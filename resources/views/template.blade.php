@php
    use App\Models\web\AcnMember;
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{URL::asset('/css/app.css')}}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <header>
        <nav>
            <img src="{{URL::asset('images/logo.png')}}" alt="Logo Carentec Nautisme">
            <div id="headerLinks">
                @if(Auth::check())
                    @php
                        $isUserSecretary = AcnMember::isUserSecretary(auth()->user()->MEM_NUM_MEMBER);
                        $isUserManager = AcnMember::isUserManager(auth()->user()->MEM_NUM_MEMBER);
                        $isUserDirector = AcnMember::isUserDirector(auth()->user()->MEM_NUM_MEMBER);
                    @endphp
                    @if($isUserSecretary || $isUserManager)
                        <a href="">Adhérent</a>
                    @endif
                    @if($isUserManager)
                            <a href="">Archives</a>
                    @elseif($isUserDirector)
                        <a href="">Mes séances</a>
                    @endif
                        <a href="{{ route('dives') }}">Plongée</a>
                        <a href="">Bilan</a>
                        <a href="">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Déconnexion') }}
                        </x-dropdown-link>
                    </form>
                @elseif(!Route::is('login'))
                    <a href="{{ route('login') }}">Connexion</a>
                @endif
            </div>
        </nav>
    </header>

    @yield('content')
</body>
</html>
