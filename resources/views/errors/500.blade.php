@extends('layouts.app')

@section('content')

<div class="alert alert-danger"  >
	<p style="font-size: 16px; text-align: center;" > 
	   Automanager faced some internal issue. 
	</p>
	<p style="font-size: 14px; text-align: center;">
		<a  href="{{URL::route('profile')}}"> 
		   Please click here to go to Profile page.             
		</a>
	</p>
</div>
@endsection