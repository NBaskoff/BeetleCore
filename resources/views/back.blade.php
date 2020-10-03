<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title') :: BeetleCMS</title>
    <script>
        if (history.length > 3 && history.length >= {{$count+1}}) {
            window.history.go(-{{$count+1}});
        } else {
            window.location = "{{$back}}";
        }
    </script>
</head>
<body>


</body>
</html>
