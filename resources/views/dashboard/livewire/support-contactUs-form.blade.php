@push('support')
    <link rel="stylesheet" href="{{asset('/assets/user/contactUs.css')}}">
@endpush
<div class="my-4">
    <h3 class="text-white">{{__('Menu Setting')}}</h3>
    <hr class="bg-white">
    <div class="contact1">
		<div class="container-contact1 row">
            <div class="d-none d-md-block col-md-6">

                <div class="contact1-pic text-center">
                    <img src="{{asset('/assets/dashboard/img/mail.png')}}" alt="minemenu-email">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <form  wire:submit.prevent="submitForm" action="/contact" method="POST" class="contact1-form">
                    @csrf
				<span class="contact1-form-title">
					{{__('Contact US')}}
				</span>
                <p class="text-white text-center mb-3">{{__('Use the form below to share your questions, ideas, comments and feedback')}}</p>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" id="name_con" name="name" wire:model="name" placeholder="{{__('Name')}}" oninput="checkForm()">
                    @error('name')<span class="form-error">{{$message}}</span>@enderror
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" id="email_con" name="email" wire:model="email" placeholder="{{__('Email')}}" oninput="checkForm()">
                    @error('email')<span class="fprm-error">{{$message}}</span>@enderror
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input">
					<input class="input1" type="tele" id="phone_con" name="phone" wire:model="phone" placeholder="+964xxx" oninput="checkForm()">
                    @error('phone')<span class="fprm-error">{{$message}}</span>@enderror
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" id="subject_con" name="subject" wire:model="subject" placeholder="{{__('Subject')}}" oninput="checkForm()">
                    @error('subject')<span class="form-error">{{$message}}</span>@enderror
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input">
					<textarea class="input1" id="message_con" name="message" wire:model="message" placeholder="message" oninput="checkForm()"></textarea>
                    @error('message')<span class="form-error">{{$message}}</span>@enderror
					<span class="shadow-input1"></span>
				</div>

				<div class="container-contact1-form-btn">
					<button id="submitButton_con" type="submit" class="contact1-form-btn" disabled>
						<span>{{__('Send Email')}}<i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
					</button>
				</div>
			</form>
        </div>
		</div>
	</div>
    <hr>
    <div>
        <h6>{{__('Contact Information')}}</h6>
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3 border-m">
                <p class="text-white">{{__('Team Support:')}} <br><a class="text-white" href="mailto:support@minemenu.com">support@minemenu.com</a></p>
            </div>
            <div class="col-12 col-sm-4 col-lg-3 border-m">
                <p class="text-white">{{__('Developer Support:')}} <br><a class="text-white" href="mailto:support@metiraq.com">support@metiraq.com</a></p>
            </div>
            <div class="col-12 col-sm-4 col-lg-3 border-m">
                <p class="text-white">{{__('Whats App Support:')}} <br><a class="text-white" href="https://wa.me/9647506814144">+9647501903720</a></p>
            </div>
        </div>
    </div>
    <script>
        function checkForm() {
            var name = document.getElementById('name_con').value;
            var email = document.getElementById('email_con').value;
            var phone = document.getElementById('phone_con').value;
            var subject = document.getElementById('subject_con').value;    
            var message = document.getElementById('message_con').value;    


            var button_con = document.getElementById('submitButton_con');
    
            if (name.trim() !== '' && email.trim() !== '' && phone.trim() !== '' && subject.trim() !== '' && message.trim() !== '') {
                button_con.disabled = false;
            } else {
                button_con.disabled = true;
            }
        }
    </script>

</div>
