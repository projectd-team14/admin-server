<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                駐輪場管理システム - 管理団体 - CSV
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
                <div class="card-name card-header">駐輪場管理者 - 検索</div>
                <div class="col-12 my-3 mx-5">
                    <form method="POST" action="?">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="row">
                                <div class="col-12">
                                    <div>▼駐輪場</div>
                                </div>                     
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <select id="create_spots" class="form-control" name="create_spots">
                                    <option value="">選択無し</option>
                                    <option value="0">全て</option>
                                        @if(isset($spot))
                                            @foreach($spot as $spots)
                                                <option value="{{ $spots['spots_id'] }}">{{ $spots['spots_name'] }}</option>
                                            @endforeach                                     
                                        @endif
                                    </select>                        
                                </div>
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <button type="submit" class="btn btn-primary" formaction="/create_user">
                                                {{ '検索' }}
                                            </button>                                     
                                        </div>
                                        <div class="col-9">
                                            <a href="javascript:void(0)" class="btn btn-primary" onclick="csvDownload()" id="csv_download">{{ 'CSV出力' }}</a>
                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-14">
        <div class="card">
            <div class="card-name card-header">検索結果</div>
                <div class="overflow-auto" style="height: 640px;">
                    <table id="perfume" class="table">
                        <thead>
                            <tr>
                            <th scope="col">管理者ID</th>
                            <th scope="col">管理者名（団体）</th>
                            <th scope="col">連絡先</th>
                            <th scope="col">管理中の駐輪場</th>
                            <th scope="col">登録日時</th>
                            <th scope="col">更新日時</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($usersList))
                                @foreach($usersList as $usersLists)
                                <tr>
                                    <td>{{ $usersLists['users_id'] }}</td>
                                    <td>{{ $usersLists['users_name'] }}</td>
                                    <td>{{ $usersLists['users_email'] }}</td>
                                    <td>{{ $usersLists['spots_name'] }}</td>
                                    <td>{{ $usersLists['created_at'] }}</td>
                                    <td>{{ $usersLists['updated_at'] }}</td>
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