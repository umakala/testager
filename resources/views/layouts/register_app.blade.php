<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>

<html lang="en">
<head>
    <title>Newstand Portal</title>
    <meta http-equiv="pragma" content="no-cache">
    <!-- style sheets -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/base.css')}}">
    <!-- For rss feed -->
    <link rel="alternate" href="{{URL::asset('assets/feed/rss.xml')}}" title="My RSS feed" type="application/rss+xml" />
</head>

<body>
    <div class="col-sm-12 hamburger" style="padding: 0;">
        <ul class="hamburgerMenu">
            <a href="{{URL::route('home')}}">
                <li style="background-color:#953138; text-align: center;">
                 NEWSTAND            
             </li>        
         </a>              
     </ul>
 </div>   

 <div class="col-sm-12">
    <header class="header" style="display: block;">
        <span id="headerTitle" class="headerTitle"></span>
        <span class="headerMenus">  
            <a href="{{URL::route('home')}}">
                <span class="highlights">
                    Top Highlights</span>
                </a> 
            </span>
        </header>
        <div class="row">
                <div class="col-lg-9 col-sm-12">
                    <div class="dynTemplate" >
                        @yield('content')
                    </div>
                </div>                
            </div>
        </div>
    </body>
    </html>
