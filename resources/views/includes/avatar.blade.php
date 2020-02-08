@if(Auth::user()->image)
    <img src="{{url('avatar/'.Auth::user()->image)}}" class="avatar" alt="">

@endif