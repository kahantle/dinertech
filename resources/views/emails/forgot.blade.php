<h1>
	Hello {{$user->first_name}}
</h1>
<p>
	Please Click the Password Reset Button to reset your password
	<a href=" {{ url('web/reset-password'. '/' .$token) }} ">Reset Password</a>
</p>