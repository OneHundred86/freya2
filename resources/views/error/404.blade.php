<!DOCTYPE html>
<html>
<head>
  
  <title>{{ $title }}</title>
  <style>
    body {
      color: #666;
      text-align: center;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      margin: auto;
      font-size: 14px;
    }

    h1 {
      font-size: 56px;
      line-height: 100px;
      font-weight: 400;
      color: #456;
    }

    .container {
      margin: auto 20px;
    }

    .go-back {
      display: none;
    }

  </style>
</head>

<body>
  <h1>
    404 页面不存在
  </h1>
  <div class="container">
    <a href="javascript:history.back()" class="js-go-back go-back">返回</a>
  </div>
  <script>
    (function () {
      var goBack = document.querySelector('.js-go-back');

      if (history.length > 1) {
        goBack.style.display = 'inline';
      }
    })();
  </script>
</body>
</html>
