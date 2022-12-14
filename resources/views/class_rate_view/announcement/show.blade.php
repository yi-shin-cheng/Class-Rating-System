<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NCU課程評鑑系統</title>
        
        <!-- use boostrap5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script>
            $(function(){
                var len = 50; // 超過50個字以"..."取代
                $(".JQellipsis").each(function(i){
                    if($(this).text().length>len){
                        $(this).attr("title",$(this).text());
                        var text=$(this).text().substring(0,len-1)+"...";
                        $(this).text(text);
                    }
                });
            });
        </script>

        <style>
            .pagination{
                float: right;
                margin-top: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('homepage') }}">課程評鑑系統</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                功能
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('show_announcement') }}">公告專區</a></li>
                                <li><a class="dropdown-item" href="{{ route('show_all_class') }}">課程評價專區</a></li>
                                <li><a class="dropdown-item" href="{{ route('show_search') }}">搜尋課程</a></li>
                                <li><a class="dropdown-item" href="{{ route('show_leaderboard') }}">課程排行榜</a></li>
                                @if(Session::get("privilege")!=3)
                                <li><a class="dropdown-item" href="{{ route('announcement_post') }}">發布公告</a></li>
                                <li><a class="dropdown-item" href="{{ route('add_classInfo') }}">新增課程</a></li>
                                @endif
                                @if(Session::get("privilege")==1)
                                <li><a class="dropdown-item" href="{{ route('show_users') }}">管理使用者</a></li>
                                @endif
                            </ul>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                帳戶
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('registerpage') }}">註冊</a></li>
                                <li><a class="dropdown-item" href="{{ route('change_password_page') }}">更改密碼</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">登出</a></li>
                            </ul>
                            </li>
                        </ul>
                    </div>  
                </div>
            </nav>

            <h2 class="text-center">公告專區</h2>
            <figure class="text-end">
                <blockquote class="blockquote">
                    <p class="text-end">使用者: {{ Session::get('user_name') }}</p>
                </blockquote>
            </figure>

            @if(Session::has("message"))
            <div class = "alert alert-success" role="alert">{{ Session::get("message") }}</div>
            @endif

            <br>
            <div class="container-sm">
            @forelse($announcements as $announcement)
                <div class="card border-dark mb-3 text-center">
                    <div class="card-header">
                        發布者: {{ $announcement->announcer }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $announcement->title }}</h5>
                        <p class="card-text JQellipsis">{{ $announcement->content }}</p>
                        <a href="{{ route('show_single_announcement', $announcement->id) }}" class="btn btn-primary">完整公告內容</a>
                        @if(Session::get("privilege") == 1 || (Session::get("privilege") == 2 && Session::get("user_name") == $announcement->announcer))
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <a href="{{ route('edit_announcement' , $announcement->id ) }}" class="btn btn-outline-success">Edit</a>
                            <form action="{{ route('delete_announcement' , $announcement->id ) }}" method="post">
                                @csrf
                                @method("delete")
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('確認刪除?')">Delete</button>
                            </form>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer text-muted">
                        發布時間: {{ $announcement->created_at }}
                    </div>
                </div>
                @empty
                <div class="card">
                    <div class="card-header">
                        發布者: Admin
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                        <p>暫無公告</p>
                        </blockquote>
                    </div>
                </div>
            @endforelse
            {{ $announcements->links() }}
            </div>
            
            
            
        </div>
        


    </body>



</html>