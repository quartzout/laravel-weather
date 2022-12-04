<!DOCTYPE html>
<html lang="ru">
<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    <title>Погода {{$city->name}}</title>

    <style>
        html {
            background-image: url("{{ GetBackgroundGifUrl($city) }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }
    </style>

</head>
<body>

    <header>
        <a href="/" class="logo" title="Store">
            <img src="{{ asset('/images/logoza 5.png') }}" alt="Logo">
        </a>

        <div id="links">
            @foreach ($allCities as $loopcity)
                @if ($city->id == $loopcity->id)
                    <a class="city active" href="#">{{$loopcity->name}}</a>
                @else
                    <a class="city" href=" {{ url("/{$loopcity->id}") }}">{{$loopcity->name}}</a>
                @endif
            @endforeach
        </div>

    </header>
    <nav>
        <div id="center-elem_1">
            <p> {{ $hourForecast->temperature }}° </p>
        </div>
        <div id="center-elem_2">
            <p class="city_Moscow">{{$city->name}}</p>

            <p class="data"> {{ GetDateString($city->timezoneShift) }}</p>
        </div>
    </nav>
    <section>
        <div id="blocks">
            <article>
                <img src="{{ asset('/images/осадки.png') }}" class="symbols">
                <p class="label">Осадки</p>
                <p class="line"></p>
                <p class="infobox"> {{ $hourForecast->precipitation }} мм</p>
        </article>
        <article>
            <img src="{{ asset('/images/ветер.png')}}" class="symbols">
            <p class="label">Ветер</p>
            <p class="line"></p>
            <p class="infobox"> {{ $forecast->wind }} м/c</p>
        </article>
        <article>
            <img src="{{ asset('/images/влажность.png')}}" class="symbols">
            <p class="label">Влажность</p>
            <p class="line"></p>
            <p class="infobox"> {{ $forecast->humidityPercent }}%</p>
        </article>
        <article>
            <img src="{{ asset('/images/давление.png')}}" class="symbols">
            <p class="label">Давление</p>
            <p class="line"></p>
            <p class="infobox"> {{ $forecast->airPressure }} мм</p>
        </article>
        <article>
            <img src="{{ asset('/images/ощущается как.png')}}" class="symbols">
            <p class="label">Ощущается как</p>
            <p class="line"></p>
            <p class="infobox"> {{ $forecast->feelsLike }}°</p>
        </article> 
        </div>
        <div id="lastblocks">
        <a href="{{ url("/{$city->id}/day") }}" class="lastlinks">Прогноз погоды на день</a>
        <a href="{{ url("/{$city->id}/week") }}" class="lastlinks">Прогноз погоды на неделю</a>
        <a href="{{ url("/{$city->id}/month") }}" class="lastlinks">Прогноз погоды на месяц</a>
        </div>
    </section>
    <footer>
    </footer>
</body>
</html>