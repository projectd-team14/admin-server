<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                駐輪場管理システム - グラフ - 駐輪場分析
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
    <div class="row justify-content-center">
        <div class="col-md-14">
            <div class="card">
                <div class="card-name card-header">分析データ</div>
                <div class="my-3 mx-5">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="row">
                            <div class="col-12">
                                <div>▼駐輪場（選択でグラフを生成）</div>
                            </div>                     
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <select id="create_spots" class="form-control" name="create_spots">
                                <option value="0">選択無し</option>
                                    @if(isset($spot))
                                        @foreach($spot as $spots)
                                            <option value="{{ $spots['spots_id'] }}">{{ $spots['spots_name'] }}</option>
                                        @endforeach                                 
                                    @endif
                                </select>                        
                            </div>
                            <div class="col-9">
                                <button type="submit" class="btn btn-primary" onclick="onClickChartButton()">
                                    {{ 'グラフ出力' }}
                                </button>             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div id="chart_card" class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-name card-header">
                    <div class="row">
                        <div class="col-10">
                            時間別 - 混雑状況
                        </div>    
                            <div class="col-2">
                                <form>
                                    <select id="change_chart" class="form-control" name="create_spots" onChange="changeChart()">
                                        <option value="0">１日間</option>
                                        <option value="1">１週間</option>
                                        <option value="2">1ヶ月間</option>
                                        <option value="3">3ヶ月間</option>
                                    </select>                                    
                                </form>
                            </div>
                        </div>                         
                    </div>
                    <div class="my-3 mx-5" style="height: 250px;">
                    <canvas id="line_chart" style="max-height: 250px;"></canvas>
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
<div class="container">
    <div id="chart_card" class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-name card-header">時間別 - 混雑状況</div> 
                    <div class="my-3 mx-5" style="height: 250px;">
                    <canvas id="bar_chart" style="max-height: 250px;"></canvas>
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const createList = [];
    var update = true;
    var lineCtx;
    var lineData
    var lineOptions;
    var lineChart;
    var barCtx;
    var barData;
    var barOptions;
    var barChart;
    var jsonObj;

    function  onClickChartButton() {
        var createSpots = document.getElementById("create_spots").value;
        var xhr = new XMLHttpRequest();

        if (createSpots !== '0') {
            xhr.open('get', "{{ env('LARAVEL_URL') }}/api/spot_data/" + createSpots, true);
            xhr.responseType = 'json';
        }

        xhr.onerror = function() {
            alert("error!");
        }

        xhr.onload = function() {
            jsonObj = this.response;

            lineData = {
                labels: jsonObj['situationChartData'][0]['labels'],
                datasets: [{
                    label: jsonObj['situationChartData'][0]['label'],
                    data: jsonObj['situationChartData'][0]['data'],
                    borderColor: jsonObj['situationChartData'][0]['backgroundColor']
                }]
            };
            lineOptions = {};

            barData = {
                labels: ["0","1","2","3","4","5","6","7","8","9","10","10~"],
                datasets: [{
                    label: jsonObj['numberChartData'][0]['label'],
                    data: jsonObj['numberChartData'][0]['data'],
                    backgroundColor: jsonObj['numberChartData'][0]['backgroundColor']
                }]
            };

            barOptions = {
                indexAxis: 'y'
            };

            if (update) {
                update = false;
                lineCtx = document.getElementById('line_chart').getContext('2d');
                lineCtx.canvas.height = 300;
                barCtx = document.getElementById('bar_chart').getContext('2d');
                barCtx.canvas.height = 300;            
                createChart(); 
            } else {        
                lineChart.destroy();
                barChart.destroy();
                createChart();   
            }
        };

        xhr.send();
    }

    function createChart() {
        lineChart = new Chart(lineCtx, {
            type: 'line',
            data: lineData,
            options: lineOptions
        });

        barChart = new Chart(barCtx, {
            type: 'bar',
            data: barData,
            options: barOptions
        });     
    }

    function changeChart() {
        var changeChart = document.getElementById("change_chart").value;

        lineData = {
            labels: jsonObj['situationChartData'][changeChart]['labels'],
            datasets: [{
                label: jsonObj['situationChartData'][changeChart]['label'],
                data: jsonObj['situationChartData'][changeChart]['data'],
                borderColor: jsonObj['situationChartData'][changeChart]['backgroundColor']
            }]
        };

        lineChart.destroy();
        barChart.destroy();
        createChart();
    }
</script>