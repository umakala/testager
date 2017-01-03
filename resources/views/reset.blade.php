@extends('layouts.register_app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Reset Password</div>
				<div class="panel-body">
					@if( isset($status) && $status == "failed")
					<div class="alert alert-danger">
							<p>{{ $info }}</p>							
					</div>					

					@else

						@if( isset($status) && $status == "success")
						<div class="alert alert-success">
								<p>{{ $info }}</p>							
						</div>
						@elseif( isset($status) && $status == "validation_failed")
						<div class="alert alert-danger">
								<p>{{ $info }}</p>							
						</div>
						@endif
					<form class="form-horizontal" role="form" method="POST" action="{{ url('reset_password') }}">
						<div class="form-group">
							<label class="col-md-4 control-label">Email</label>
							<div class="col-md-6">
								<label  class="form-control"> {{$email}}</label>
								<input type="hidden" name ="email" value="{{$email}}"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" value="">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="confirm_password" value="">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Update
								</button>
								
							</div>
						</div>
					</form>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
