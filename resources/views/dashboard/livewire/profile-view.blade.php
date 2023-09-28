<!-- Begin Page Content -->
<div>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between my-4">
        <h1 class="h3 mb-0 text-white">{{__('Profile')}}</h1>

    </div>

    @if($profile['plan_id'] == 1)
    <div class="alert alert-danger" role="alert">
        You Are In {{$profile['plan_name']}} To Upgrade Click here<a href="#" class="alert-link"> Upgrade</a>
    </div>
    @endif
    <!-- Content Row -->
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row m-0 p-0 dash-card">
                <div class="col-12 col-xl-2 m-0 p-0">
                    <div class="card--profile text-center">
                        <img src="{{$profile['avatar']}}" alt="Responsive Image" class="img-fluid p-3"
                            style="max-width: 150px">
                    </div>
                </div>
                <div class="col-md-10 m-0 p-0">
                    <div class="card-body dash-card border-0">
                        <div class="row text-white">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 mb-3">
                                {{-- <h5>Profile</h5> --}}
                                <p class="card-title">Restaurant Name: {{$profile['restName']}}</p>
                                <p class="card-title">Country: {{$profile['country']}}</p>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 mb-3">
                                {{-- <h5>Initial Information</h5> --}}
                                <p class="card-title">Name: {{$profile['name']}}</p>
                                <p class="card-title">Email: {{$profile['email']}}</p>
                                <p class="card-title">Phone: {{$profile['phone']}}</p>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 mb-3">
                                {{-- <h5>Menu Active Time</h3> --}}
                                <p class="card-title text-success">Start: {{$profile['create']}}</p>
                                <p class="card-title text-danger">Expire: {{$profile['expire']}}</p>
                                @if($profile['plan_id'] == 1)
                                <p class="card-title text-info">Subscription: <span
                                        class="text-danger">{{$profile['plan_name']}}</span></p>
                                @else
                                <p class="card-title text-info">Subscription: {{$profile['plan_name']}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-5">
            <div class="accordion" id="accordionExample">
                <div class="card bg-dark text-white">
                  <div class="card-header bg-dark text-white" id="headingOne">
                    <h2 class="mb-0">
                      <button class="btn btn-danger text-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        {{__('Change Password')}}
                      </button>
                    </h2>
                  </div>
              
                  <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" wire:ignore.self>
                    <div class="card-body">
                        <form wire:submit.prevent="changePassword" >
                            <div class="mb-3">
                                <label for="oldPass">{{__('Old Password')}}</label>
                                <div class="input-group">
                                    <input type="text" name="old_pass" wire:model="old_pass" class="form-control" id="old_pass">
                                    <button type="button" class="input-group-text" id="show_hide_old_password"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                </div>
                                <small class="text-info">{{__('(Write Your Current Pasword)')}}</small>
                                @error('old_pass') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                            <div class="mb-3">
                                <label for="newPass">{{__('New Password')}}</label>
                                <div class="input-group">
                                    <input type="text" name="new_pass" wire:model="new_pass" class="form-control" id="new_pass">
                                    <button type="button" class="input-group-text" id="show_hide_new_password"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                </div>
                                <small class="text-info">{{__('(Write New Pasword)')}}</small>
                                @error('new_pass') <span class="text-danger">{{ $message }}</span> @enderror
                                <span id="newPassError" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPass">{{__('Confirm Password')}}</label>
                                <div class="input-group">
                                    <input type="text" name="confirm_pass" wire:model="confirm_pass" class="form-control" id="confirm_pass">
                                    <button type="button" class="input-group-text" id="show_hide_con_password"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                </div>
                                <small class="text-info">{{__('(Re-Write New Pasword)')}}</small>
                                @error('confirm_pass') <span class="text-danger">{{ $message }}</span> @enderror
                                <span id="confirmPassError" class="text-danger"></span>

                            </div>
                            <button id="submitButton" class="btn btn-success" type="submit">{{__('Update Password')}}</button>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>


<!-- /.container-fluid -->
<script src="{{asset('assets/dashboard/vendor/jquery/jquery.min.js')}}"></script>
<script>
$(document).ready(function() {
    $("#show_hide_old_password").on('click', function(event) {
        event.preventDefault();
        if($('#old_pass').attr("type") == "text"){
            $('#old_pass').attr('type', 'password');
            $('#show_hide_old_password i').addClass( "fa-eye-slash" );
            $('#show_hide_old_password i').removeClass( "fa-eye" );
        }else if($('#old_pass').attr("type") == "password"){
            $('#old_pass').attr('type', 'text');
            $('#show_hide_old_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_old_password i').addClass( "fa-eye" );
        }
    });
});

$(document).ready(function() {
    $("#show_hide_new_password").on('click', function(event) {
        event.preventDefault();
        if($('#new_pass').attr("type") == "text"){
            $('#new_pass').attr('type', 'password');
            $('#show_hide_new_password i').addClass( "fa-eye-slash" );
            $('#show_hide_new_password i').removeClass( "fa-eye" );
        }else if($('#new_pass').attr("type") == "password"){
            $('#new_pass').attr('type', 'text');
            $('#show_hide_new_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_new_password i').addClass( "fa-eye" );
        }
    });
});

$(document).ready(function() {
    $("#show_hide_con_password").on('click', function(event) {
        event.preventDefault();
        if($('#confirm_pass').attr("type") == "text"){
            $('#confirm_pass').attr('type', 'password');
            $('#show_hide_con_password i').addClass( "fa-eye-slash" );
            $('#show_hide_con_password i').removeClass( "fa-eye" );
        }else if($('#confirm_pass').attr("type") == "password"){
            $('#confirm_pass').attr('type', 'text');
            $('#show_hide_con_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_con_password i').addClass( "fa-eye" );
        }
    });
});
</script>
</div>