<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <div class="container py-5">
            <form id="form-send" method="post" action="{{ route('send') }}">
                <div class="mb-3">
                    <label for="" class="form-label">Ім’я</label>
                    <input type="text" name="first_name" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Прізвище</label>
                    <input type="text" name="last_name" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Пароль</label>
                    <input type="password" name="password" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Повторення пароля</label>
                    <input type="password" name="password_confirmation" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <button type="submit" class="btn btn-primary">Відправити</button>
            </form>
            <div id="form-success" class="alert alert-success d-none"></div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script type="application/javascript">
            $(document).ready(function() {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $('#form-send').submit(function (e) {
                    e.preventDefault();
                    var form = $(this);

                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function (response) {
                            validate(response);
                            success(response);
                            //console.log(response);
                        }
                    });
                });

                function validate(response) {
                    $('input').removeClass('is-invalid');
                    if(response.errors) {
                        $.each(response.errors, function(index, value) {
                            $('[name="'+index+'"]').addClass('is-invalid');
                            $('[name="'+index+'"] + .invalid-feedback').text(value);
                        });
                        //console.log(response.errors);
                    }
                }

                function success(response) {
                    if(response.success) {
                        $('#form-send').addClass('d-none');
                        $('#form-success').removeClass('d-none').addClass('d-block').text(response.success);
                        //console.log(response.errors);
                    }
                }
            });
        </script>
    </body>
</html>
