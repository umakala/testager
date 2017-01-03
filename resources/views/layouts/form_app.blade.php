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




    <!-- For Tree view -->
    <!-- Required Stylesheets -->
    <link href="{{ URL::asset('assets/css/bootstrap-treeview.css')}}" rel="stylesheet">
     <!-- Required Javascript -->
    <script src="{{ URL::asset('assets/js/jquery.js')}}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap-treeview.js')}}"></script>



    <script type="text/javascript">
        function signOff() {
            document.location.href = "{{URL::route('logout')}}";
        }
    </script>
</head>

<body>
    <div class="col-lg-9 fixed" >
        <header class="header" style="display: block;">
        <span id="headerTitle" class="headerTitle">Welcome</span>
        <span class="headerMenus">  
            <a href="{{URL::route('home')}}">
                <span class="highlights">
                </span>
            </a>                 
            <span class="dropdown"> 
             <ul class="dropdown-menu">
                    <li > <a href="{{url('project/create')}}" style="">
                         <!-- <span class="glyphicon glyphicon-plus" ></span> -->
                         Add Project
                    </a></li>

                     <li > <a href="{{url('functionality/create')}}"  style="">
                         Add Functionality
                    </a>
                    </li>

                    <li > <a href="{{url('scenario/create')}}" style="">
                         Add Scenario
                    </a>
                    </li>
                    <li > <a href="{{url('testcase/create')}}"  style="">
                         Add Testcase
                    </a>
                    </li>
                    <li onclick="signOff()" ><a>Sign out</a></li>
                </ul> 
                                     
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    <span class="glyphicon glyphicon-user" style="color: #000"></span>
                    <b class="caret" style="color: #000;"></b>
                </a>               
            </span>
            </span>
        </header>
        </div>

        <div class="col-lg-3 hamburger" >
            <ul class="hamburgerMenu">
                <a href="{{URL::route('profile')}}">
                    <li style="background-color:#7d4627;font-size: 16px; ">
                      TESTAGER  <span id="" class="glyphicon glyphicon-menu-hamburger hamburgerIcons" onclick="toggleHamburger()"></span>               
                  </li>        
                </a>
            </ul>  
        </div>
        <div class="col-lg-12 fixed" >
                 @if(isset($info)) 
                <p class="alert alert-info" >{{$info}}</p>
                @endif
                @yield('content')
            </div>
        </div>

      
    </div>
</body>
</html>
