
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">


    <title>Authentication</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">


    <link rel="stylesheet" href="{{ URL::asset('css/test.css') }}">





</head>

<body>

<div class="container">
   @include('layouts.top-menu')

    @yield('content')

    <footer class="footer">
        <p>&copy; 2016 Company, Inc.</p>
    </footer>

</div> <!-- /container -->


</body>
</html>
