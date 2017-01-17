
@extends('layouts.app')


@section('content')
<div class="wrapper">
			<p>
	        	@include('toast::messages')
				@if(Session::has('toasts'))
				        {{Session::forget('toasts')}}
				@endif
	 		</p> 
	 	
<!--   <div class="panel panel-default" style=" padding:10px">


         <div class="panel-body" >
         	


         </div>
    </div>  -->   
</div>
@endsection
