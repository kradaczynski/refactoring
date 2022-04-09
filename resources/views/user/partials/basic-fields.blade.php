<label for="fname">Name:</label><br>
<input type="text" id="fname" name="name" value="{{ $userSet ? $user->name : old('name') }}"><br>
<label for="lname">Email:</label><br>
<input type="text" id="lname" name="email" value="{{ $userSet ? $user->email : old('email') }}"><br>
@if($userSet) <input type="hidden" name="id" value="{{ $user->id }}"> @endif
