
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    @include("error/common_style")

    @stack('moduleStyles')

    @include("error/common_script")

    @stack('moduleScripts')

</head>
<body>
<script>
    var _CSRF = '{{ csrf_token() }}';
</script>


@yield('app')

</body>
</html>