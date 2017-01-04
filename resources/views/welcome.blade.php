
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>

<html lang="en">
<head>
<title>Testing Manager</title>
    <meta http-equiv="pragma" content="no-cache">
    <!-- CSS And JavaScript -->
    <!-- style sheets -->

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/base.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery.fileupload.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/jquery.fileupload-ui.css')}}">

    <!-- javascript lib -->
    <script type="text/javascript" src="{{ URL::asset('assets/js/jquery-1.11.3.min.js')}}"></script>          
    <script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/jquery.ui.widget.js')}}"></script> 

    <!-- For rss feed -->
    <link rel="alternate" href="{{URL::asset('assets/feed/rss.xml')}}" title="My RSS feed" type="application/rss+xml" />

    <script type="text/javascript">
        function signOff() {
            document.location.href = "{{URL::route('logout')}}";
        }
    </script>
</head>

<body>
    <div class="col-sm-12 hamburger" style="padding: 0;">
        <ul class="hamburgerMenu">
            <a href="{{URL::route('home')}}">
                <li style="background-color:#7d4627; text-align: center; font-weight: bold; font-size: 18px">
                  AUTOMANAGER                
              </li>        
          </a> 
      </ul>
</div>   
<div class="col-lg-3 col-sm-12"></div>
<div class="col-sm-9">
       <div class="row">
            <div class="wrapper" style="margin-top: 20px">
   
    <div class="col-lg-6 col-sm-12 panel panel-default" style="margin-top: 70px; padding:20px">
       <div class="panel-title" >Login</div>
       <hr/>        
       <div class="panel-body">
        <form action="{{URL::route('login')}}" method ="POST" class="">
            <div class="form-group">    
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
            </div>           
            <div class="form-group">
                @if(isset($message))                           
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($message as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <button type="submit" id="loginButton" class="btn btn-primary" >Login</button>
        </form>
    </div>
</div>
        </div>

    </div>
</div>
</div>
</body>
</html>