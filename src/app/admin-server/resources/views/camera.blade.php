<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                駐輪場管理システム - カメラ - 条件検索
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
                <div class="card-name card-header">カメラ検索</div>
                <div class="col-12 my-3 mx-5">
                <form method="POST" action="?">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="row">
                            <div class="col-12">
                                <div>▼駐輪場（選択でグラフを生成）</div>
                            </div>                     
                        </div>
                        <div class="row">
                            <div class="col-3">
                            <select id="create_spots" class="form-control" name="spots_id">
                                <option value="0">選択無し</option>
                                @foreach($spot as $spots)
                                    <option value="{{ $spots['spots_id'] }}">{{ $spots['spots_name'] }}</option>
                                @endforeach 
                            </select>   
                            </div>
                            <div class="col-9">
                                <button type="submit" class="btn btn-primary" formaction="/create_camera">
                                    {{ 'カメラ接続' }}
                                </button>
                            </div>
                        </div>                
                    </div>                    
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($camera))
<div class="container">
    <div id="chart_card" class="row justify-content-center">
    @foreach($camera as $cameras)
    @php
        $urlReplace = str_replace('watch?v=', 'embed/', $cameras['cameras_url']);
    @endphp
        <div class="col-6">
            <div class="card">
                <div class="card-name card-header">{{ $spotName[0]['spots_name'] }}（{{ $cameras['cameras_name'] }}）</div> 
                    <div class="my-3 mx-5">
                    <div class="row">
                        <iframe width="100%" height="315"
                         src="{{ $urlReplace }}"
                         title="YouTube video player" frameborder="0" 
                         allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>    
    @endforeach 
    </div>
</div>
@endif
