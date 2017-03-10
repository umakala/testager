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
    <span class=" btn headerButt dropdown">  
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
            Manage
            <b class="caret" style="color: #000;"></b>
        </a>
    </span>


    <!-- Test lab dropdown options  -->
    <span class="btn headerButt dropdown"> 
        <a href="{{url('sc_lab_list/functionality')}}" >
            Testlab 
        </a>
    </span>

    <!-- <span class=" btn headerButt dropdown">  
      <ul class="dropdown-menu">
            <li > <a href="{{url('project/create')}}" style="">
                 Add Project
            </a></li>
            Add more options here

        </ul>                   
        <a href="#" data-toggle="dropdown" class="dropdown-toggle">                    
            DEFECT <b class="caret" style="color: #000;"></b>
        </a>
    </span> -->

    <!-- Reports dropdown options  -->
     <span class="btn headerButt dropdown">
     <!--  <ul class="dropdown-menu">
            <li > <a href="{{url('lab')}}" style="">
                 Lab
            </a></li>
        </ul>  <b class="caret" style="color: #000;"></b>-->                  
        <a href="{{url('summary')}}" ><!--  data-toggle="dropdown" class="dropdown-toggle">   -->    Reports 
        </a>
    </span>

    <!-- Defect dropdown options  -->
     <span class="btn headerButt dropdown">
        <a href="{{url('defect')}}" >                  
            Defects 
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