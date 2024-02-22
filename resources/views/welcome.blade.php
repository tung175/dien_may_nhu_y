<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" href="{{ asset('storage/images/logo.png') }}">
        <title>Điện Máy Như Ý</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />

        <style>
            a {
                text-decoration: none !important;
            }
            body {
                font-family: 'Nunito', sans-serif;
            }
            .form-control {
                background-color: #fff;
            }
            .router-link-active {
                text-decoration: unset;
            }
            /* con trỏ khi chỉ vào checkbox */
            label.custom-control-label {
                cursor: pointer;
            }
            /* Độ rộng của cột hành động ở bảng product */
            .width-actions {
                min-width: 110px;
                max-width: 110px;
            }
            /* Đổi màu cho hành động xóa */
            .fa-trash-alt {
                color: #dc3545;
                cursor: pointer;
            }
            .fa-trash-alt:hover {
                color: #bd2130;
            }
            .fa-file-pdf {
                color: whitesmoke;
            }
            .fa-eye {
                color: #ffc107;
                cursor: pointer;
            }
            .fa-eye:hover {
                color: #dda802;
            }
            /* ép ảnh trong thông tin sản phẩm */
            .info-product img {
                width: 100%;    
            }
        </style>
    </head>
    <body style="background-color: white" class="hold-transition sidebar-mini layout-fixed">
        <div id="app">

        </div>
        <!-- ./wrapper -->
        <script src="{{ mix("js/app.js") }}"></script>

    </body>
</html>
