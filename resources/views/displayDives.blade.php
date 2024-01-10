@extends("template")


@section("content")
@php
    $id=0;
    use Carbon\Carbon;
@endphp
    @if(!empty(session('errors')))
        @foreach (session('errors')->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif
    @foreach($months as $month)
        <h2>{{ $month->mois_mot }}</h2>

        @foreach($dives[$month->mois_mot] as $dive)
            @php
                //$newDate = new Carbon($dive->DIV_DATE);
                $date = Carbon::parse($dive->DIV_DATE)->locale('fr_FR')->translatedFormat('l j F Y');
                $heureStart = date_Format(DateTime::createFromFormat('H:i:s',$dive->PER_START_TIME), 'G');
                $heureFin = date_Format(DateTime::createFromFormat('H:i:s',$dive->PER_END_TIME), 'G');
                $buttonText = "S'inscrire"
            @endphp
            <form
            @if (auth()->user()->dives->contains("DIV_NUM_DIVE", $dive->DIV_NUM_DIVE))
                action="{{ route('membersDivesUnregister') }}"
                @php
                    $buttonText = "Se désinscrire"
                @endphp
            @else
                action="{{ route('membersDivesRegister') }}"
            @endif
            method="POST">
                @csrf
                @method('post')
                <p>
                    <a href="{{route('dives_informations',$dive->DIV_NUM_DIVE)}}">
                        <input
                        type='hidden'
                        name='dive'
                        value={{$dive->DIV_NUM_DIVE}}
                        >
                        {{ $date }}
                        de {{ $heureStart }}h à {{ $heureFin }}h
                        Site prevu : {{ $dive->SIT_NAME }}
                        ( {{ $dive->SIT_DESCRIPTION }} )
                        Niveau : {{$dive->PRE_LABEL}}
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>
                </p>
                <input type="submit" value="{{ $buttonText }}">
            </form>
        @endforeach
    @endforeach
@endsection
