

<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    @include("core/common_style")

    @stack('moduleStyles')

    @include("core/common_script")

    @stack('moduleScripts')

</head>
<body>
<script>
    var _CSRF = '{{ csrf_token() }}';
</script>

@include("core/header")

@yield('app')

@include("core/tpl")
</body>
</html>