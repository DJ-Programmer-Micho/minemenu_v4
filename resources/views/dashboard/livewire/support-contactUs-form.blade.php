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
					Contact US
				</span>
                <p class="text-white text-center mb-3">{{__('Use the form below to share your questions, ideas, comments and feedback')}}</p>
				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="name" wire:model="name" placeholder="Name">
                    @error('name')<span class="form-error">{{$message}}</span>@enderror
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="email" wire:model="email" placeholder="Email">
                    @error('email')<span class="fprm-error">{{$message}}</span>@enderror
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input">
					<input class="input1" type="number" name="phone" wire:model="phone" placeholder="+964xxx">
                    @error('phone')<span class="fprm-error">{{$message}}</span>@enderror
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input">
					<input class="input1" type="text" name="subject" wire:model="subject" placeholder="Subject">
                    @error('subject')<span class="form-error">{{$message}}</span>@enderror
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input">
					<textarea class="input1" name="message" wire:model="message" placeholder="message"></textarea>
                    @error('message')<span class="form-error">{{$message}}</span>@enderror
					<span class="shadow-input1"></span>
				</div>

                {{-- <div class="wrap-input1 validate-input">
                    <input class="input1" type="file" wire:model="attachments" multiple>
                    <span class="shadow-input1"></span>
                </div> --}}

				<div class="container-contact1-form-btn">
					<button class="contact1-form-btn">
						<span>
							Send Email
							<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						</span>
					</button>
				</div>
			</form>
        </div>
		</div>
	</div>
    <hr>
    <div>
        <h6>Contact Information</h6>
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3 border-m">
                <p class="text-white">Team Support: <br><a class="text-white" href="mailto:support@minemenu.com">support@minemenu.com</a></p>
            </div>
            <div class="col-12 col-sm-4 col-lg-3 border-m">
                <p class="text-white">Developer Support: <br><a class="text-white" href="mailto:support@metiraq.com">support@metiraq.com</a></p>
            </div>
            <div class="col-12 col-sm-4 col-lg-3 border-m">
                <p class="text-white">Whats App Support: <br><a class="text-white" href="tel:+9647501903720">+9647501903720</a></p>
            </div>
            <div class="col-12 col-sm-4 col-lg-3 border-m">
                <p class="text-white">Team Support: <br><a class="text-white" href="mailto:support@minemenu.com">support@minemenu.com</a></p>
            </div>
            <div class="col-12 col-sm-4 col-lg-3 border-m">
                <p class="text-white">Developer Support: <br><a class="text-white" href="mailto:support@metiraq.com">support@metiraq.com</a></p>
            </div>
            <div class="col-12 col-sm-4 col-lg-3 border-m">
                <p class="text-white">Whats App Support: <br><a class="text-white" href="tel:+9647501903720">+9647501903720</a></p>
            </div>
        </div>
    </div>
</div>
