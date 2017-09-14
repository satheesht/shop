
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta property="categoryUrl" content="{{url('ajax/get/categories')}}">
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1256">
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-6">
    <META HTTP-EQUIV="Content-language" CONTENT="ar">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Bamilo | Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    

 
  </head>

  <body>
    <!-- store helper url to be accessed from javascript -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#"><b>Bamilo</b></a>
      <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="{{url('dashboard/0/0/0')}}"><span class="glyphicon glyphicon-cloud" aria-hidden="true"></span> Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="{{url('categories')}}">Categories</a>
        </li>
          
          <li class="nav-item">
            <a class="nav-link" href="{{url('attributes')}}">Attributes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('products')}}">Products</a>
          </li>
        </ul>
       
          <a href="{{url('logout')}}"><button class="btn btn-default my-2 my-sm-0" type="submit">Logout</button></a>
       
      </div>
    </nav>
    <div class="container-fluid">
    @yield('content')
    </div>
    
  

 

  </body>
</html>
