<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Прогноз на месяц {{$city->name}} </title>
        <meta charset="UTF-8">
        

        <style>
            body {
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

        <link rel="stylesheet" href="{{ asset("/css/month.css") }}">

    </head>

    <body>
        <div class="body"></div>
        <div class="body_2"></div>
        <div class="header">
            <img class="logo-header" src="{{ asset("/images/logo.png") }}" alt="logo">

            <div class="header-row">
                <div class="header-block">
                    <div class="text-header">{{$city->name}}</div>
                    <div class="text-header_2">{{ GetMonthString() }}</div>
                </div>
            </div>
           
        </div>

        <div class="table">
            <table width="90%" border="2" cellpadding="10" bordercolor="#0000000" style="background-color:#ffffff00" margin-top="-100px" right="200px">
                
                @php
                    $daysInColumn = 7;
                    $firstDayColumn = (new Carbon\Carbon($forecasts[0]->date))->isoWeekDay();
                    $cells = count($forecasts) + $firstDayColumn-1;
                    $rows = ceil($cells / 7);
                @endphp

                @for($rowIndex=0; $rowIndex<$rows; $rowIndex++)
                    <tr>
                        
                        {{-- Добавляем в первый ряд пустые ячейки, чтобы начало таблицы сдвинулось на соответствующую неделю--}}
                        @if($rowIndex == 0)
                            @for($columnIndex = 0; $columnIndex < $firstDayColumn-1; $columnIndex++)
                                <td></td>
                            @endfor
                        @endif

                        {{-- Добавляем ячейки с данными в ряд. Если ряд первый, начальный индекс сдвинут до номера соответствующей недели. 
                            Цикл завершается, если дошел до конца ряда или если все дни были добавлены --}}
                        @for($columnIndex = ($rowIndex == 0) ? $firstDayColumn : 1;

                            $day = ($rowIndex * $daysInColumn) + $columnIndex - ($firstDayColumn-1),
                            $columnIndex <= $daysInColumn && $day <= count($forecasts); 
                            $columnIndex++)

                            @php $forecast = $forecasts[$day-1]; @endphp

                            <td>
                                <div class="tr_1">{{$day}}</div>
                                <div class="image">
                                    <div class="img__wrap">
                                        <img class="img__img" src="{{ GetIconForDayForecast($forecast) }}" />
                                        <p class="img__description"> 
                                            {{ GetDateStringFromDay($day) }} <br>
                                            <br> День: {{$forecast->avgTemperatureDay}}° 
                                            <br> Ночь: {{$forecast->avgTemperatureNight}}°
                                            <br> Ветер: {{$forecast->wind}} м/с
                                            <br> Давление: {{$forecast->airPressure}} мм.
                                            <br> Осадки: {{$forecast->avgPrecipitation}} мм.
                                        </p>
                                    </div>
                                </div>
                            </td>
                        @endfor
                    </tr>
                @endfor
            

            </table>

        </div>
        <div class="footer">

                <a href="{{ url("/{$city->id}/week") }}" class="image_buttons">
                    <img src="{{ asset("images/back.png") }}">
                </a>
                
                <a href="{{ url("/{$city->id}/") }}" class="image_buttons"> 
                    <img src="{{ asset("images/forward.png") }}"> 
                </a> 

        </div>
    </body>
</html>