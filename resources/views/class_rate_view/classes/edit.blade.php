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

            <div class="container-sm">
                <br>
                <h3 class="text-center">編輯課程資訊</h3>
            
                @if(Session::has("message"))
                <div class = "alert alert-success" role="alert">{{ Session::get("message") }}</div>
                @endif
                <br>
                <form action="{{ route('update_classInfo' , $classInfo->id) }}" method="post">
                    @csrf
                    @method("put")
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">課號</span>
                            <input type="text" class="form-control" name="class_id" value="{{ $classInfo->class_id }}" aria-label="class_id" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">課程名稱</span>
                            <input type="text" class="form-control" name="class_name" value="{{ $classInfo->class_name }}" aria-label="class_name" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">授課教師</span>
                            <input type="text" class="form-control" name="teacher" value="{{ $classInfo->teacher }}" aria-label="teacher" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">學分</span>
                            <input type="text" class="form-control" name="credit" value="{{ $classInfo->credit }}" aria-label="credit" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="form-check form-check-inline">
                            @if($classInfo->Required == "R")
                            <input class="form-check-input" type="radio" name="class_type" id="required_class" value="R" checked>
                            @else
                            <input class="form-check-input" type="radio" name="class_type" id="required_class" value="R">
                            @endif
                            <label class="form-check-label" for="required_class">必修</label>
                        </div>
                        <div class="form-check form-check-inline">
                            @if($classInfo->Required == "S")
                            <input class="form-check-input" type="radio" name="class_type" id="selective_class" value="S" checked>
                            @else
                            <input class="form-check-input" type="radio" name="class_type" id="selective_class" value="S">
                            @endif
                            <label class="form-check-label" for="selective_class">選修</label>
                        </div>
                        <br><br>
                        <label for="outline">課程綱要</label>
                        <textarea class="form-control" name="outline" rows="3" required>{{ $classInfo->outline }}</textarea>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-secondary">提交</button>
                </form>
                
                <br>
            </div>


        </div>
    </body>
</html>