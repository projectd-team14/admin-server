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
      <div class="d-flex align-items-end position-absolute bottom-0 end-0">
        <a class="my-5 mx-5 btn btn-primary btn-lg rounded-pill" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </div>
      <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item navigation">
          <h2 class="accordion-header navbar" id="flush-headingOne">
            <button class="accordion-button collapsed navbar text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
              <span class="title">ホーム</span>
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body sub">
              <a href="/home">
                <div class="text-white">
                  ・ダッシュボード
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="accordion-item navigation">
          <h2 class="accordion-header navbar" id="flush-headingTwo">
            <button class="accordion-button collapsed navbar text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
              <span class="icon"><ion-icon name="bar-chart-outline"></ion-icon></span>
              <span class="title">グラフ</span>
            </button>
          </h2>
          <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body sub">
              <a href="/chart">
                <div class="text-white">
                  ・条件検索
                </div>
              </a>
            </div>
            <div class="accordion-body sub">
              <a href="/chart_spot">
                <div class="text-white">  
                  ・駐輪場分析
                </div>  
              </a>
            </div>
          </div>
        </div>
        <div class="accordion-item navigation">
          <h2 class="accordion-header navbar" id="flush-headingThree">
            <button class="accordion-button collapsed navbar text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
              <span class="icon"><ion-icon name="image-outline"></ion-icon></span>
              <span class="title">カメラ</span>
            </button>
          </h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body sub">
              <a href="/camera">
                <div class="text-white">   
                  ・条件検索
                </div>  
              </a>
            </div>
          </div>
        </div>
        <div class="accordion-item navigation">
          <h2 class="accordion-header navbar" id="flush-headingFour">
            <button class="accordion-button collapsed navbar text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
            <span class="icon"><ion-icon name="bicycle-outline"></ion-icon></span>
            <span class="title">ダウンロード</span>
            </button>
          </h2>
          <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body sub">
              <a href="/download">
                <div class="text-white">  
                  ・駐輪場-条件検索-CSV
                </div>  
              </a>
            </div>
            <div class="accordion-body sub">
              <a href="/download">
                <div class="text-white">  
                  ・グラフ-条件検索-JPG
                </div>  
              </a>
            </div>
          </div>
        </div>
        <div class="accordion-item navigation">
          <h2 class="accordion-header navbar" id="flush-headingFive">
            <button class="accordion-button collapsed navbar text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
            <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
            <span class="title">ユーザー</span>
            </button>
          </h2>
          <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body sub">
              <a href="/download">
                <div class="text-white">  
                  ・駐輪場管理団体
                </div>  
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
