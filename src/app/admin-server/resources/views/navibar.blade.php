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
    <div class="navigation">
      <ul>
        <li class="list">
          <li class="nav-item dropdown">
            <a href="/spot/{{ $user['id'] }}">
              <span class="icon"><ion-icon name="bar-chart-outline"></ion-icon></span>
              <span class="title">統計</span>
            </a>
          </li>
        </li>
        </li>
        <li class="list">
          <a href="/information/{{ $user['id'] }}">
            <span class="icon"><ion-icon name="information-circle-outline"></ion-icon></span>
            <span class="title">申請</span>
          </a>
        </li>
        <li class="list">
          <a href="/setting/{{ $user['id'] }}">
            <span class="icon"><ion-icon name="bicycle-outline"></ion-icon></span>
            <span class="title">設定</span>
          </a>
        </li>
        <li class="list">
          <li class="nav-item dropdown">
          <a href="/download">
              <span class="icon"><ion-icon name="map-outline"></ion-icon></span>
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
    </div>
  </body>
</html>
