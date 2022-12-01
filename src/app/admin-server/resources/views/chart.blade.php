<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                駐輪場管理システム-管理者用
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
                <div class="col-12 my-3 mx-5">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <div>▼駐輪場（選択でグラフを生成）</div>
                            <select id="create_spots" class="form-control" name="create_spots">
                            <option value="0">選択無し</option>
                                @foreach($spot as $spots)
                                    <option value="{{ $spots['spots_id'] }}">{{ $spots['spots_name'] }}</option>
                                @endforeach 
                            </select>                        
                        </div>
                        <div class="col-3">
                        <div>▼表示中（選択でグラフを削除）</div>
                            <select id="delete_spots" class="form-control" name="delete_spots">
                            <option value="0">選択無し</option>
                                @foreach($spot as $spots)
                                    <option value="{{ $spots['spots_id'] }}">{{ $spots['spots_name'] }}</option>
                                @endforeach 
                            </select>                        
                        </div>
                        <div class="col-6">
                            <div>▼グラフ種類</div>
                            <div class="row">
                                <div class="col-4">
                                    <select id="spots_chart_type" class="form-control" name="spots_chart_type">
                                        <option value="0">放置自転車</option>
                                        <option value="1">１日</option>
                                        <option value="2">7日</option>
                                        <option value="3">30日</option>
                                        <option value="4">90日</option>
                                    </select>   
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary" onclick="createChart()">
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
</div>
<div class="container">
    <div id="chart_card" class="row justify-content-center">
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const createList = [];
    const adminURL = process.env.ADMIN_URL

    function  createChart() {
        var createSpots = document.getElementById("create_spots").value;
        var deleteSpots = document.getElementById("delete_spots").value;
        var spotsChartType = document.getElementById("spots_chart_type").value;

        var type = '';
        var color = '';

        if (spotsChartType == '0') {
            type = '（放置自転車）'
            color = 'rgba(255, 100, 100, 1)';
        } else if (spotsChartType === '1') {
            type = '（１日間）'
            color = 'rgba(100, 255, 100, 1)';
        } else if (spotsChartType === '2') {
            type = '（７日間）'
            color = 'rgba(100, 100, 255, 1)';
        } else if (spotsChartType === '3') {
            type = '（1ヶ月間）'
            color = 'rgba(200, 200, 100, 1)';
        } else if (spotsChartType === '4') {
            type = '（3ヶ月間）'
            color = 'rgba(100, 200, 200, 1)';
        }

        const data = {
            "create_spots" : createSpots,
            "delete_spots" : deleteSpots,
            "spots_chart_type" : spotsChartType
        }

        var json_text = JSON.stringify(data);
        var xhr = new XMLHttpRequest();

        if (createSpots !== '0') {
            xhr.open('post', "/api/create_chart", true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(json_text);  
        }

        if (deleteSpots !== '0') {
            var list_element = document.getElementById(deleteSpots);
            list_element.remove();
        }

        xhr.onerror = function(){
            alert("error!");
        }

        xhr.onload = function(){
            const jsonObj = JSON.parse(xhr.responseText);
            console.log(jsonObj['spots_data']);

            var listCode = '<div id='+ createSpots + ' class="col-6">' + '<div class="card">' + 
            '<div class="card-name card-header">' + jsonObj['spots_name'] + type + '</div>' + 
            '<div class="my-3 mx-5">' + '<div class="row">' + '<canvas id="ex_chart" class="w-100">' + '</canvas>' + 
            '</div>' + '</div>' + '</div>' + '</div>';
            var contentBlock = document.getElementById('chart_card');
            contentBlock.insertAdjacentHTML('afterbegin', listCode);

            // グラフ生成
            var ctx = document.getElementById('ex_chart').getContext('2d');
            ctx.canvas.height = 300;
            var data = {
                labels: jsonObj['labels'],
                datasets: [{
                    label: jsonObj['spots_name'],
                    data: jsonObj['spots_data'],
                    borderColor: color
                }]
            };
            var options = {};
            var ex_chart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: options
            });
        };
    }
</script>