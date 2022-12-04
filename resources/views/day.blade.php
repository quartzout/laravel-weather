
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">

    <style>
        body {
            background-image: url("{{ GetBackgroundGifUrl($city) }}");
            background-size: cover;
            background-attachment: fixed;
        }

        .forecast-items-row {
            background-image: url("{{ url("/images/pixel.png") }}");
            background-position: center;
            background-repeat: repeat-x;
        }

    </style>

    <title>Погода на день {{$city->name}} </title>

    <link rel="stylesheet" href="{{ asset('/css/day.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500&display=swap" rel="stylesheet">

</head>




<body>
    <div class="container">

        <div class="main">

            <div class="title-row flex">

                <div class="logo">
                    <img src="{{ asset("/images/logo.png") }}" class="logo-img">
                </div>

                <div class="title-box flex">
                    <p class="p-city">{{$city->name}}</p>
                    <p class="p-date"> {{ GetDateString($city->timezoneShift) }} </p>
                </div>

                <div class="logo"></div> 
            </div>
            

            <div class="forecast-row grid">

                @php
                    $labels = ['Ночь', 'Утро', "День", "Вечер"]
                @endphp

                @for($rowIndex = 0; $rowIndex < 4; $rowIndex++)

                    <div class="time-box flex">
                        <img src="images/ночь.png" class="time-box-img" alt="">
                        <div class="span time-box-label"> {{ $labels[$rowIndex] }}  </div>
                    </div>
    
                    <div class="forecast-items-row flex">
    
                        @for ($itemIndex = 0; $itemIndex< 6; $itemIndex++)

                            @php
                                $hour = $rowIndex * 6 + $itemIndex;
                            @endphp

                            <div class="hour-item flex {{ $itemIndex >=3 ? "hidden-at-low-res" : "" }}">
                                <div class="item-time-label"> {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00</div>
                                <img src="{{ GetIconForHourForecast($forecast->hourForecasts[$hour]) }}" class="item-icon" alt="icon">
                                <div class="item-temperature-label">{{$forecast->hourForecasts[$hour]->temperature}}°</div>
                            </div>
                        
                        @endfor

                    </div>

                    <div class="forecast-items-row flex hidden-at-high-res" >
    
                        @for($itemIndex = 3; $itemIndex < 6; $itemIndex++)

                            <div class="hour-item flex {{ $itemIndex >=3 ? "hidden-at-high-res" : "" }}">
                                <div class="item-time-label"> {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00</div>
                                <img src="{{ GetIconForHourForecast($forecast->hourForecasts[$hour]) }}" class="item-icon" alt="icon">
                                <div class="item-temperature-label">{{$forecast->hourForecasts[$hour]->temperature}}°</div>
                            </div>

                        @endfor
                    
                    </div>
                    
                @endfor       

            </div> 

        </div>

        <div class="buttons-row flex">
            <a href="{{ url("/{$city->id}") }}"> <img src="{{ asset("images/back.png") }}" class="nav-button" alt="На главную"> </a>
            <a href="{{ url("/{$city->id}/week/") }}"> <img src="{{ asset("images/forward.png") }}" class="nav-button" alt="На неделю"> </a>
        </div>

    </div>
    

<script
    src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
    crossorigin="anonymous">
</script>

<script src="script.js"></script>

</body>
</html>
