<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </head>
  <body>
    <div class="col-md-2 p-0 navigation side-view">
      <ul>
        <li class="list">
          <a href="/home">
            <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
            <span class="title">ホーム</span>
          </a>
        </li>
        <li class="list">
          <a href="/chart">
            <span class="icon"><ion-icon name="bar-chart-outline"></ion-icon></span>
            <span class="title">グラフ</span>
          </a>
        </li>
        <li class="list">
          <a href="/camera">
          <span class="icon"><ion-icon name="image-outline"></ion-icon></span>
            <span class="title">カメラ</span>
          </a>
        </li>
        <li class="list">
          <a href="/download">
            <span class="icon"><ion-icon name="bicycle-outline"></ion-icon></span>
            <span class="title">ダウンロード</span>
          </a>
        </li>
        <li class="list">
          <a href="/help/{{ $user['id'] }}">
            <span class="icon"><ion-icon name="help-circle-outline"></ion-icon></span>
            <span class="title">ヘルプ</span>
          </a>
        </li>
      </ul>
      <div style="height: 85%;">
      </div>
      <div class="text-center">
          <a class="my-5 mx-5 btn btn-primary btn-lg rounded-pill" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('ログアウト') }}</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
      </div>
    </div>
  </body>
</html>
