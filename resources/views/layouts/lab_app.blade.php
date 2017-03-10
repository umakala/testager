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
    



    <!-- treeview libs-->
    <link href="{{ URL::asset('assets/css/bootstrap-treeview.css')}}" rel="stylesheet">
    <script src="{{ URL::asset('assets/js/jquery.js')}}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap-treeview.js')}}"></script>
  
  <script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap_multiselect.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/jquery_multiselect.js')}}"></script> 

  <!-- datatable scripts -->
    <script type="text/javascript" src="{{ URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('assets/js/dataTables.bootstrap.min.js')}}"></script>

    
    
    <!-- common methods -->
    <script type="text/javascript">
        function signOff() {
            document.location.href = "{{URL::route('logout')}}";
        }

        function hideSummary() {      
          if( $('#icontoggle').hasClass('glyphicon-eye-close')){
             $('#icontoggle').removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
          }else if( $('#icontoggle').hasClass('glyphicon-eye-open')){
              $('#icontoggle').removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
          }        
        }      
    </script>
</head>

<body>
        <div class="col-md-9 col-sm-12" >
          @include('layouts.header')
        </div>
        <div class="col-md-3 col-sm-12" >
            <ul class="hamburgerMenu">
                <a href="{{URL::route('profile')}}">
                    <li style="background-color:#7d4627;font-size: 16px; font-weight: bold ">
                      AUTOMANAGER </span>               
                  </li>      
                </a>              
            </ul>  
        </div>
    <div class="col-md-12 fixed" >
             <div class="dynTemplate" style="margin-top: 20px;">
                 @if(isset($info)) 
                <p class="alert alert-info" >{{$info}}</p>
                @endif

                

                @yield('content')
                </div>
            </div>
        </div>            
        
    </div>
</body>
</html>
