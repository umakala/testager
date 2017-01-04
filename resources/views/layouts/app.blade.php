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
    
    <!-- common methods -->
    <script type="text/javascript">
        function signOff() {
            document.location.href = "{{URL::route('logout')}}";
        }

       function make_tree(path) {
           $.ajax({
             type: "GET",
             url: path,
             success: function(result){
                  defaultData = result;
                  $('#tree').treeview({
                    data: defaultData,
                    color: "#428bca",
                    backColor: '#7d4627',
                    //backColor: '#c9d8c5',
                    onhoverColor: "#a8b6bf",
                    selectedBackColor:"#a8b6bf",
                    showBorder: false,
                    expandIcon: 'glyphicon glyphicon-chevron-right',
                    collapseIcon: 'glyphicon glyphicon-chevron-down',
                    enableLinks: true,
                    levels :3
                  });
              }
          });
      }
    </script>
</head>

<body>
    <div class="col-lg-9 fixed" >
        <header class="header" style="display: block;">
        <span id="headerTitle" class="headerTitle"></span>
        <span class="headerMenus">  
          <span class="dropdown">  
              <ul class="dropdown-menu">                    
                    <li onclick="signOff()" ><a>Sign out</a></li>
                </ul> 
                  
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    <span class="glyphicon glyphicon-user" style="color: #000"></span>
                    <b class="caret" style="color: #000;"></b>
                </a>
            </span>
            <a href="{{URL::route('profile')}}">      
                <span class="highlights">
                  Hi {{session()->get('name')}}
                </span>
            </a>            
            </span>

            <!-- Management  -->
            <span class=" btn headerButt dropdown"> MANAGEMEMENT 
              <ul class="dropdown-menu">
                    <li > <a href="{{url('project/create')}}" style="">
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
                </ul> 
                  
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    
                    <b class="caret" style="color: #000;"></b>
                </a>
            </span>


            <!-- Test lab dropdown options  -->
            <span class=" btn headerButt dropdown"> TESTLAB 
              <ul class="dropdown-menu">
                    <li > <a href="{{url('project/create')}}" style="">
                         Add Project
                    </a></li>
                </ul>                   
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">                    
                    <b class="caret" style="color: #000;"></b>
                </a>
            </span>

            <!-- Defect dropdown options  -->
            <span class=" btn headerButt dropdown"> DEFECT 
              <ul class="dropdown-menu">
                    <li > <a href="{{url('project/create')}}" style="">
                         Add Project
                    </a></li>
                    <!-- Add more options here -->

                </ul>                   
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">                    
                    <b class="caret" style="color: #000;"></b>
                </a>
            </span>

            <!-- Reports dropdown options  -->
            <span class=" btn headerButt dropdown"> REPORTS 
              <ul class="dropdown-menu">
                    <li > <a href="#" style="">
                         SHOW 
                    </a></li>
                    <!-- Add more options here -->
                </ul>                   
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">                    
                    <b class="caret" style="color: #000;"></b>
                </a>
            </span>

              @if(isset($projects))
              <span class="dropdown" style="float: right; margin-right: 5px"> 
              <ul class="dropdown-menu">
                @foreach($projects as $project)
                <?php 
                  $url = URL::route('tree_value',['id'=> $project->tp_id]);
                ?>
                <li onclick="make_tree('{{$url}}')"><a>{{$project->tp_name}}</a></li>
                @endforeach
              </ul>
              <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    All Projects
                    <!-- <span class="glyphicon glyphicon-bookmark" style="color: #000"></span>
                     --><b class="caret" style="color: #000;"></b>
              </a>
              </span> 
              @endif

        </header>
             <div class="dynTemplate">
                 @if(isset($info)) 
                <p class="alert alert-info" >{{$info}}</p>
                @endif
                @yield('content')
                </div>
            </div>
        </div>

             
        <div class="col-lg-3 col-sm-4 hamburger" >
            <ul class="hamburgerMenu">
                <a href="{{URL::route('profile')}}">
                    <li style="background-color:#7d4627;font-size: 16px; font-weight: bold ">
                      AUTOMANAGER  <span id="" class="glyphicon glyphicon-menu-hamburger hamburgerIcons" onclick="toggleHamburger()"></span>               
                  </li>      
                </a>
               @if(session()->has('open_project'))
               <script type="text/javascript">
                        <?php 
                          $url = URL::route('tree_value',['id'=> session()->get('open_project')]);
                        ?>
                        make_tree('{{$url}}');
                      </script>
                    <div id="tree" style="margin:0px">                
                    </div>
                @endif 
            </ul>  
        </div>
    </div>
</body>
</html>
