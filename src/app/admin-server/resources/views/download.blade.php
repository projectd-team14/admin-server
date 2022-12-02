<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                駐輪場管理システム-ダウンロード
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
                <div class="card-name card-header">情報検索・ダウンロード</div>
                <div class="col-12 my-3 mx-5">
                    <form method="POST" action="?">
                    @csrf
                        <div class="form-group row">
                            <div class="row">
                                <div class="col-4">
                                        <div>▼駐輪場</div>
                                        <select class="form-control" name="spots_id">
                                            <option value="0">全て</option>
                                            @foreach($spot as $spots)
                                            <option value="{{ $spots['spots_id'] }}">{{ $spots['spots_name'] }}</option>
                                            @endforeach 
                                        </select>                                                  
                                </div>                        
                                <div class="col-4">
                                        <div>▼状態</div>
                                        <select class="form-control" name="spots_category">
                                            <option value="0">全て</option>
                                            <option value="1">放置車両</option>
                                        </select>                                                
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div>▼種別</div>
                                    <select class="form-control" name="spots_status">
                                        <option value="3">全て</option>
                                        <option value="1">自転車</option>
                                        <option value="2">バイク</option>
                                    </select>                        
                                </div>
                                <div class="col-8">
                                    <div>▼期間（必須）</div>
                                    <div class="row">
                                        <div class="col-3">
                                            <input class="form-control" type="date" name="created_at" />
                                        </div>
                                        <div class="col-3">
                                            <input class="form-control" type="date" name="updated_at" />
                                        </div> 
                                        <div class="col-2">
                                            <button type="submit" class="btn btn-primary" formaction="/create_list">
                                                {{ '　検索　' }}
                                            </button>
                                        </div>
                                        <div class="col-2">
                                        <a href="javascript:void(0)" class="btn btn-primary" onclick="csvDownload()" id="csv_download">{{ 'CSV出力' }}</a>
                                        </div>
                                    </div>
                                </div>                  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
            <div class="card-name card-header">検索結果</div>
                <div class="overflow-auto" style="height: 580px;">
                    <table id="perfume" class="table">
                        <thead>
                            <tr>
                            <th scope="col">自転車ID</th>
                            <th scope="col">駐輪場</th>
                            <th scope="col">状態</th>
                            <th scope="col">登録日時</th>
                            <th scope="col">更新日時</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($bicycleList))
                                @foreach($bicycleList as $bicycleLists)
                                <tr>
                                    <td>{{ $bicycleLists['bicycles_id'] }}</td>
                                    <td>{{ $bicycleLists['spots_name'] }}</td>
                                    <td>{{ $bicycleLists['bicycles_status'] }}</td>
                                    <td>{{ $bicycleLists['created_at'] }}</td>
                                    <td>{{ $bicycleLists['updated_at'] }}</td>
                                </tr>
                                @endforeach 
                            @endif
                        </tbody>
                    </table>            
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script>
    const csvDownload = () => {
      const table = document.getElementById('perfume')
      const escaped = /,|\r?\n|\r|"/;
      const e = /"/g;
      const bom = new Uint8Array([0xEF, 0xBB, 0xBF])
      const csv = []
      const row = []

      for (let r = 0; r < table.rows.length; r++) {
        row.length = 0
        for (let c = 0; c < table.rows[r].cells.length; c++) {
          const field = table.rows[r].cells[c].textContent
          row.push(escaped.test(field) ? '"' + field.replace(e, '""') + '"' : field)
        }
        csv.push(row.join(','))
      }

      const blob = new Blob([bom, csv.join('\n')], {
        'type': 'text/csv'
      })

      const a = document.getElementById('csv_download')

      a.download = 'bicycle_data.csv'

      a.href = window.URL.createObjectURL(blob)

    }
  </script>