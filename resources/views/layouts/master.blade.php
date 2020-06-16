<!DOCTYPE html>
<html>
<head>
  <title>@yield('title', 'Blog')</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  @notifyCss
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-warning">
    <div class="container">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="{{ url('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('blog') }}">Blog</a>
          </li>
          @if(auth()->check() && auth()->user()->role == 'admin')
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin') }}">Admin</a>
          </li>
          @endif
        </ul>
        <div class="form-inline my-2 my-lg-0">
          @if(!auth()->check())
          <a class="btn btn-light my-2 mr-2 my-sm-0" href="{{ route('login') }}">Login</a>
          <a class="btn btn-light my-2 my-sm-0" href="{{ route('register') }}">Register</a>
          @else
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <a class="btn btn-light my-2 mr-2 my-sm-0" onclick="document.getElementById('logout-form').submit();">Logout</a>
          @endif
        </div>
      </div>
    </div>
  </nav>

  @include('notify::messages')
  @yield('content')
  
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  @notifyJs
</body>
</html>