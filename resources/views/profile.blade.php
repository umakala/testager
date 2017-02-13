
@extends('layouts.app')


@section('content')
<div class="wrapper">
			<p>
	        	@include('toast::messages')
				@if(Session::has('toasts'))
				        {{Session::forget('toasts')}}
				@endif
	 		</p> 
	 	
<div class="col-md-8">
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

@if(Session::get('email') == 'admin')

<div class="col-md-8">
  <div class="panel panel-default" style=" padding:10px">
         <div class="panel-title" > <span id="" class="glyphicon glyphicon-plus"></span> Add New User </div>        

         <div class="panel-body" >
					<form action="{{URL::route('user.store')}}" method ="POST" class="form-horizontal">
						
						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-mail</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" value="">
							</div>
						</div>
						
						 		 <div class="form-group">
                @if(isset($_GET['message']))                           
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($_GET['message'] as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
              </div>
              <div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>								
							</div>
						</div>

					</form>




         </div>
    </div>    
</div>
</div>
@endif
@endsection
