
@extends('layouts.app')


@section('content')
<div class="wrapper">
			<p>
	        	@include('toast::messages')
				@if(Session::has('toasts'))
				        {{Session::forget('toasts')}}
				@endif
	 		</p> 
	 	
<div class="col-md-6">
  <div class="panel panel-default" style=" padding:10px">
         <div class="panel-title" > <span id="" class="glyphicon glyphicon-briefcase"></span> General Settings </div>        

         <div class="panel-body" >
	        <div class="row" style="padding-bottom: 10px">
				<div class="col-md-4">
					Autorun Location
	            </div>     
				<div class="col-md-8">
					{{session()->get('autorun_location')}}
	            </div>     
			</div>	

	        <div class="row" style="padding-bottom: 10px">
				<div class="col-md-4">
					Last Opened Project
	            </div>     
				<div class="col-md-8">
				{{session()->get('project_name')}}
	            </div>     
			</div>	

         </div>
    </div>    
</div>
</div>
@endsection
