@if(session()->has('success'))
    <div class="alert alert-success col-md-6 offset-3 text-center">
        {{session()->get('success')}}
    </div>
@endif
@if(session()->has('danger'))
    <div class="alert alert-danger col-md-6 offset-3 text-center">
        {{session()->get('danger')}}
    </div>
@endif