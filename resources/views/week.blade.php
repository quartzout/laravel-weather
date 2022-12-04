<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset("/css/week.css") }}">
    
    <style>
        html {
            background:url( "{{ GetBackgroundGifUrl($city) }}" );
	        background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500&display=swap" rel="stylesheet">


    <title>Погода на неделю {{$city->name}}</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src=" {{ asset("/images/logo.png") }}" class="logo_img"  alt="Logo">
        </div>
        

        <div id="center-elem">
            <div class="city">{{$city->name}}</div>
            <div class="data">{{ GetMonthString() }}</div>
            
        </div>
    
    
        <table border="1">

            @foreach($forecasts as $forecast)   
                <tr>
                    <td class="data_1">{{ FormatDate($forecast->date) }}</td>
                    <td class="dayOfWeek"> {{ GetWeekday($forecast->date) }}</td>
                    <td class="picture"> 
                        <div class="flex">
                            <img src="{{ GetIconForDayForecast($forecast) }}" alt="icon" class="icon">
                            <span class="precip"> {{ $forecast->humidityPercent }}%  </span>
                        </div>
                     </td>
                    <td class="elem1"> {{ $forecast->minTemperature }}°</td>
                    <td class="elem1"> {{ $forecast->maxTemperature }}°</td>
                </tr>
            @endforeach

    
        </table>
        <div id="links">
            <a href="{{ url("/{$city->id}/day/") }}"><img class="img" src="{{ asset("/images/back.png") }} "></a>
            <a href="{{ url("/{$city->id}/month/") }}"><img class="img" src="{{ asset("/images/forward.png") }}"></a>
        </div>
    </header>
    
</body>
</html>