<div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                駐輪場管理システム - ホーム - ダッシュボード
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('ログアウト') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="container">
    <div id="chart_card" class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-name card-header">自転車利用推移</div> 
                    <div class="my-3 mx-5" style="height: 300px;">
                    <canvas id="line_chart" style="max-height: 300px;"></canvas>
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
<div class="container">
    <div id="chart_card" class="row justify-content-center">
        <div class="col-3">
            <div class="card">
                <div class="card-name card-header">駐輪場一覧</div> 
                    <div class="overflow-auto" style="height: 400px;">
                    <table id="perfume" class="table">
                    <thead>
                        <tr>
                        <th class="text-center" scope="col">駐輪場名</th>
                        <th class="text-center" scope="col">非表示/表示</th>
                        </tr>
                    </thead>
                    @php
                        $count = 0;
                    @endphp
                        @if(isset($spot))
                            @foreach($spot as $spots)
                            <tr>
                                <td class="text-center">{{ $spots['spots_name'] }}</td>
                                <td class="text-center">
                                    <div class="form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="{{ $spots['spots_id'] }}" onclick="onClickSpotChart({{ $count }})"> 
                                    </div>
                                </td>
                            </tr>
                            @php
                                $count = $count + 1;
                            @endphp
                            @endforeach 
                        @endif
                    </table>                    
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>  
        <div class="col-9">
            <div class="card">
                <div class="card-name card-header">駐輪場マップ</div> 
                    <div style="height: 400px;">
                        <div id="mapid" style="height: 400px;"></div>
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
 <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
   integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
   crossorigin="">
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = @json($data['labels']);
    const countMonthAll = @json($data['month_list']);
    const countViolationAll = @json($data['violation_list']);
    const spotData = @json($spot);
    const datasets =  [
            {
                id: 0,
                label: '全国（平均利用者）',
                data: countMonthAll,
                borderColor: 'rgba(100, 100, 255, 1)'
            },
            {
                id: 0,
                label: '全国（合計放置車両）',
                data: countViolationAll,
                borderColor: 'rgba(255, 100, 100, 1)'
            }
        ];
    var ctx = document.getElementById('line_chart');
    var line_chart;

    // グラフ
    function createChart() {
        line_chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            }
        });
    }

    function onClickSpotChart(a) {
        var update = true;

        for (i = 0; i < datasets.length; i++) {
            if (datasets[i]['id'] === spotData[a]['spots_id']) {
                datasets.splice(i, 2);
                update = false;
            }
        }

        if (update) {
            var r = Math.floor( Math.random() * (254 + 1 - 100) ) + 100 ;
            var g = Math.floor( Math.random() * (254 + 1 - 100) ) + 100 ;
            var b = Math.floor( Math.random() * (254 + 1 - 100) ) + 100 ;

            var newData = {
                id: spotData[a]['spots_id'],
                label: spotData[a]['spots_name'] + '（平均利用者）',
                data: spotData[a]['spots_count_month1'].split(','),
                borderColor: 'rgba(' + r + ',' + g +',' + b + ', 1)'
            }

            datasets.push(newData);

            var r = Math.floor( Math.random() * (254 + 1 - 100) ) + 100 ;
            var g = Math.floor( Math.random() * (254 + 1 - 100) ) + 100 ;
            var b = Math.floor( Math.random() * (254 + 1 - 100) ) + 100 ;

            var newData = {
                id: spotData[a]['spots_id'],
                label: spotData[a]['spots_name'] + '（合計放置車両）',
                data: spotData[a]['spots_violations'].split(','),
                borderColor: 'rgba(' + r + ',' + g +',' + b + ', 1)'
            }

            datasets.push(newData);
            line_chart.update();
        } else {
            line_chart.update();
        }

    }

    createChart();

    // 地図
    var map = L.map('mapid', {
    center: [35.66572, 139.73100],
    zoom: 10,
    });
    var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
    });
    tileLayer.addTo(map);

    for (i = 0; i < spotData.length; i++) {
        var marker = L.marker([spotData[i]['spots_latitude'], spotData[i]['spots_longitude']]).addTo(map);
        var urlReplace =  spotData[i]['spots_url'].replace('watch?v=', 'embed/');
        var cameraHtml = '<iframe width="560" height="315"src="' + urlReplace + '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

        marker.bindPopup("<div>" + spotData[i]['spots_name'] + "</div>" + 
        "<div>" + cameraHtml + "</div>", {maxWidth: 560, closeOnClick: true});
    }

</script>