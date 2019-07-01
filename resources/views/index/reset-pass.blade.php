<!doctype html>
<html class="no-js h-100" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Войти - Komir.kz</title>
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="/admin/styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="/admin/styles/extras.1.1.0.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <link rel="stylesheet" href="/admin/styles/additional.css">
</head>
<body class="h-100">
<div class="main-content-container h-100 px-4 container-fluid">
    <div class="h-100 no-gutters row">
        <div class="auth-form mx-auto my-auto col-md-5 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <img class="auth-form__logo d-table mx-auto mb-3" src="/admin/images/main-logo.svg" alt="Komir.kz">
                    <h5 class="auth-form__title mb-4">Изменение пароля</h5>
                    <form class="login-form" method="post" id="reset_pass_form">
                        @if(@count($user_row) > 0)
                            <input type="hidden" value="{{$user_row->user_id}}" name="user_id">
                            <input type="hidden" value="{{$user_row->reset_token}}" name="reset_token">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="forgot-password-form-email">Новый пароль</label>
                                <input type="password" name="password" id="forgot-password-form-email" placeholder="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="forgot-password-form-email">Повтор пароля</label>
                                <input type="password" name="repeat_password" id="forgot-password-form-email" placeholder="" class="form-control">
                            </div>
                            <button type="button" onclick="resetPass()" name="submit" id="forgot-password-form-submit" class="mb-2 btn btn-primary mr-2">Сменить пароль</button>
                            <span style="color: red; display:block;" class="email-result-span"></span>
                        @else
                            <div class="form-group">
                                <h5 class="auth-form__title mb-4"> Ваша ссылка для восстановления не активна</h5>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="auth-form__meta d-flex mt-4">
                <a class="mx-auto" href="/login">Вернуться к авторизации</a>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
<script src="/admin/scripts/extras.1.1.0.min.js"></script>
<script src="/admin/scripts/shards-dashboards.1.1.0.min.js"></script>
<script src="/admin/scripts/app/app-components-overview.1.1.0.js"></script>
<script src="/admin/scripts/jquery.validate.js"></script>

<script>
    $(document).ready(function(){
        $("#reset_pass_form").validate({
            rules : {
                password: {required : true},
                repeat_password: {required : true}
            },
            messages:{
                password: {required : "Укажите Пароль"},
                repeat_password: {required : "Укажите Повтор пароля"}
            }
        });
    });

    function resetPass(){
        if (!$("#reset_pass_form").valid()){
            return false;
        }

        $.ajax({
            type: 'POST',
            url: "/set-new-pass",
            data: $("#reset_pass_form").serialize(),
            success: function(data){
                if(data.result == true){
                    $(".email-result-span").html("Пароль успешно изменен");
                }
                else if(data.result == false){
                    $(".email-result-span").html("Ошибка при изменении пароля")
                }
                else{
                    $(".email-result-span").html(data.value);
                }
            }
        });
    }
</script>
</body>
</html>
