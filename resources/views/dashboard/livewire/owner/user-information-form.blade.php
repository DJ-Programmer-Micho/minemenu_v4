<div>
<link rel="stylesheet" href="{{asset('assets/general/lib/teleSelect/demo.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
<link rel="stylesheet" href="{{asset('assets/general/lib/country_select/country_select.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.js"></script>


<style>
    .image_area { position: relative; }
    img { display: block; max-width: 100%; }
    .preview { overflow: hidden; width: 160px;  height: 160px; margin: 10px; border: 1px solid red;}
    .modal-lg{max-width: 1000px !important;}
    .overlay { position: absolute; bottom: 10px; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5); overflow: hidden; height: 0; transition: .5s ease; width: 100%;}
    .image_area:hover .overlay { height: 50%; cursor: pointer; }
    .text { color: #333; font-size: 20px; position: absolute; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%); text-align: center;}
    .switch input { display:none; }
    .switch { display:inline-block; width:60px; height:20px; margin:8px; position:relative; }
    .slider { position:absolute; top:0; bottom:0; left:0; right:0; border-radius:30px; box-shadow:0 0 0 2px #cc0022, 0 0 4px #cc0022; cursor:pointer; border:4px solid transparent; overflow:hidden; transition:.4s; }
    .slider:before { position:absolute; content:""; width:100%; height:100%; background:#cc0022; border-radius:30px; transform:translateX(-30px); transition:.4s; }
    input:checked + .slider:before { transform:translateX(30px); background:limeGreen; }
    input:checked + .slider { box-shadow:0 0 0 2px limeGreen,0 0 2px limeGreen; }
</style>



<!-- Insert Modal  -->
<div wire:ignore.self class="modal fade overflow-auto" id="createUser" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="addRegister">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createFoodLabel">{{__('Add New Register')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <div class="row mt-3">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('User Information')}}</b>
                            </h2>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="mb-3">
                                <label>{{ __('Select Plan') }}</label>
                                <select wire:model="add_plan_id" name="add_plan_id" id="" class="form-control">
                                    <option value="">Select Plan</option>
                                    @foreach ($planSelect as $plan)
                                        <option value="{{$plan->id}}">{{$plan->name['en']}}</option>
                                    @endforeach
                                </select>
                                <small class="text-info">{{__('Select The Plan')}}</small>
                                @error('add_plan_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
    

                        <div class="col-12 col-sm-8">
                            <label for="avatarImg">Upload Image</label>
                            <input type="file" name="avatarImg" id="avatarImg" class="form-control" style="height: auto">
                            <small class="text-info">The Ratio Should be <b>(1/1)</b> and prefer to have background solid</small>
                            @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                            <input type="file" name="croppedAvatarImg" id="croppedAvatarImg" style="display: none;">
                            <div class="mb-3 d-flex justify-content-center mt-1 ">
                                <img id="showAvatarImg" class="img-thumbnail rounded bg-dark" src="{{$tempImg ?? $default_img}}" width="150px">
                            </div>
                        </div>

                    </div>
                    <div class="row mt-5">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Initial Information')}}</b>
                            </h2>
                        </div>

                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Full Name</label>
                                <input type="text" wire:model="add_fullname" class="form-control" required>
                                @error('add_fullname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Business Name</label>
                                <input type="text" wire:model="add_businessname" class="form-control" required>
                                @error('add_businessname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Email Address</label>
                                <input type="email" wire:model="add_email" class="form-control" required>
                                @error('add_businessname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border" wire:ignore>
                            <div class="mb-3 phone">
                                <label for="inputPhone">Phone Number</label>
                                <input id="inputPhone" type="tel" name="inputPhone" wire:model="add_phone" class="form-control" dir="ltr" required>
                                @error('add_phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" wire:model="add_password" class="form-control" required>
                                @error('add_password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border" wire:ignore>
                            <div class="mb-3 country">
                                <label for="country_selector">Country</label>
                                <input type="text" name="country_selector" id="country_selector" wire:model="add_country" class="form-control" required>
                                @error('add_country') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>State</label>
                                <input type="text" wire:model="add_state" class="form-control" required>
                                @error('add_state') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" wire:model="add_address" class="form-control" required>
                                @error('add_address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 mt-5 options">
                    <label for="add_type" class="font-weight-bold">{{__("Brand Type")}}</label>
                            <div class="row">
                                @foreach ($brand_type as $type)
                                <div class="col-4 col-lg-3 form-check">
                                    <input class="form-check-input" type="checkbox" id="{{$type}}" name="add_type.{{$type}}" wire:model="add_type" value="{{$type}}">
                                    <label class="form-check-label" for="add_type.{{$type}}">{{__($type)}}</label>
                                </div>
                                @endforeach
                            </div>
                    </div>

                    <div class="form-group col-12 mt-5 options">
                        <label for="add_language" class="font-weight-bold">{{__("Languages")}}</label>
                        <div class="row">
                            @foreach ($languages as $type)
                            <div class="col-4 col-lg-3 form-check">
                                <input class="form-check-input" type="checkbox" id="{{$type}}" name="add_language.{{$type}}"  wire:model="add_language" value="{{$type}}">
                                <label class="form-check-label" for="add_language.{{$type}}">{{__($type)}}</label>
                            </div>
                            @endforeach

                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitJs">Save</button>
                </div>
            </form>
        </div>
    </div>
    
</div>

<div wire:ignore.self class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="updateUser">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserLabel">{{__('Add New Register')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <div class="row mt-3">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('User Information')}}</b>
                            </h2>
                        </div>

                        <div class="col-12 col-sm-8">
                            <label for="editAvatarImg">Upload Image</label>
                            <input type="file" name="editAvatarImg" id="editAvatarImg" class="form-control" style="height: auto">
                            <small class="text-info">The Ratio Should be <b>(1/1)</b> and prefer to have background solid</small>
                            @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                            <input type="file" name="editCroppedAvatarImg" id="editCroppedAvatarImg" style="display: none;">
                            <div class="mb-3 d-flex justify-content-center mt-1 ">
                                <img id="showEditAvatarImg" class="img-thumbnail rounded bg-dark" src="{{ $tempImg ? $tempImg : ($imgReader2  ?: $default_img) }}" width="150px">
                                {{-- <img id="showEditAvatarImg" class="img-thumbnail rounded bg-dark" src="{{ $tempImg ? $tempImg : (app('cloudfront').$imgReader  ?: $default_img_edit) }}" width="150px"> --}}
                            </div>
                        </div>

                    </div>
                    <div class="row mt-5">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Initial Information')}}</b>
                            </h2>
                        </div>

                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Full Name</label>
                                <input type="text" wire:model="add_fullname" class="form-control" required>
                                @error('add_fullname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Business Name</label>
                                <input type="text" wire:model="add_businessname" class="form-control" required>
                                @error('add_businessname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Email Address</label>
                                <input type="email" wire:model="add_email" class="form-control" required>
                                @error('add_businessname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border" wire:ignore>
                            <div class="mb-3 phone">
                                <label for="inputPhone">Phone Number</label>
                                <input id="inputPhone" type="tel" name="inputPhone" wire:model="add_phone" class="form-control" dir="ltr" required>
                                @error('add_phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" wire:model="add_password" class="form-control" required>
                                @error('add_password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border" wire:ignore>
                            <div class="mb-3 country">
                                <label for="country_selector">Country</label>
                                <input type="text" name="country_selector" id="country_selector" wire:model="add_country" class="form-control" required>
                                @error('add_country') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>State</label>
                                <input type="text" wire:model="add_state" class="form-control" required>
                                @error('add_state') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" wire:model="add_address" class="form-control" required>
                                @error('add_address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Brand Type Checkboxes -->
                    <div class="form-group col-12 mt-5 options">
                        <label for="add_type" class="font-weight-bold">{{__("Brand Type")}}</label>
                        <div class="row">
                            @foreach ($brand_type as $type)
                            <div class="col-4 col-lg-3 form-check">
                                <input class="form-check-input" type="checkbox" id="{{$type}}" name="add_type.{{$type}}" wire:model="has_type" value="{{$type}}" @if(in_array($type, $has_type)) checked @endif>
                                <label class="form-check-label" for="add_type.{{$type}}">{{__($type)}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Languages Checkboxes -->
                    <div class="form-group col-12 mt-5 options">
                        <label for="add_language" class="font-weight-bold">{{__("Languages")}}</label>
                        <div class="row">
                            @foreach ($languages as $type)
                            <div class="col-4 col-lg-3 form-check">
                                <input class="form-check-input" type="checkbox" id="{{$type}}" name="add_language.{{$type}}" wire:model="has_language" value="{{$type}}" @if(in_array($type, $has_language)) checked @endif>
                                <label class="form-check-label" for="add_language.{{$type}}">{{__($type)}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitJs">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div wire:ignore.self class="modal fade" id="moduleUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="updateModuleUser">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserLabel">{{__('Update Register Validation')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="mb-3">
                            <label>{{ __('Select Plan') }}</label>
                            <select wire:model="add_plan_id" name="add_plan_id" id="" class="form-control">
                                <option value="">Select Plan</option>
                                @foreach ($planSelect as $plan)
                                    <option value="{{$plan->id}}">{{$plan->name['en']}}</option>
                                @endforeach
                            </select>
                            <small class="text-info">{{__('Select The Plan')}}</small>
                            @error('add_plan_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Subscription Information')}}</b>
                            </h2>
                        </div>

                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Email Verificartion</label>
                                <select wire:model="email_verified" name="email_verified" id="" class="form-control">
                                    <option value="">Email Status</option>
                                        <option value="1">Submited</option>
                                        <option value="0">Not Submit</option>
                                </select>
                                @error('email_verified') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>SMS Verificartion</label>
                                <select wire:model="phone_verified" name="phone_verified" id="" class="form-control">
                                    <option value="">SMS Status</option>
                                        <option value="1">Submited</option>
                                        <option value="0">Not Submit</option>
                                </select>
                                @error('phone_verified') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <label>Status</label>
                            <select wire:model="status" name="status" id="" class="form-control">
                                <option value="">Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Not Active</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>Expire Date</label>
                                <input type="datetime-local" wire:model="expire_at" name="expire_at" class="form-control" required>
                                <small class="text-danger"><b>
                                    When a plan is selected, the 'Expire Date' is automatically updated in the backend. However, if you manually enter an expiration date, it will be stored as the new expiration date.
                                </b></small>
                                @error('expire_at') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitJs">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div wire:ignore.self class="modal fade" id="infoUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserLabel">{{__('Other Information')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="mb-3">
                            <h5>Name: {{$add_fullname}}</h5>
                            <h6>Email: {{$add_email}}</h6>
                            <h6>Phone: {{$add_phone}}</h6>
                        </div>
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>
 {{--
 
<div wire:ignore.self class="modal fade" id="deleteFoodModal" tabindex="-1" aria-labelledby="deleteFoodModalLabel"
    aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFoodModalLabel">Delete Food</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroyfood">
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this Food?') }}</p>
                    <p>{{ __('Please enter the')}}<strong> "{{$showTextTemp}}" </strong>{{__('to confirm:') }}</p>
                    <input type="text" wire:model="foodNameToDelete" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" wire:disabled="!confirmDelete || $foodNameToDelete !== $showTextTemp">
                            {{ __('Yes! Delete') }}
                        </button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

{{-- IMAGE CROP MODAL --}}
<div class="modal fade" id="modal" tabindex="-2" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg text-white" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image Before Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="" id="sample_image" />
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" id="crop" class="btn btn-primary">Crop</button> --}}
                <button type="button" class="btn btn-primary crop-btn" data-index="">Crop</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div> 
</div>

@push('cropper')

{{-- Add --}}
<script>
    document.addEventListener('livewire:load', function () {
        console.log('asd')
        var modal = new bootstrap.Modal(document.getElementById('modal'));
        var cropper;
        
        $('#avatarImg').change(function (event) {
            var image = document.getElementById('sample_image');
            var files = event.target.files;
            var done = function (url) {
                image.src = url;
                modal.show();
            };
            if (files && files.length > 0) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
            handleCropButtonClick(image);
        });
    
        function handleCropButtonClick(image) {
            $('#modal').on('shown.bs.modal', function () {
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 1 / 1,
                    viewMode: 1,
                    preview: '.preview'
                });
            });
    
            $('.crop-btn').off('click').on('click', function () {
                var canvas = cropper.getCroppedCanvas({
                    width: 640,
                    height: 360
                });
    
                canvas.toBlob(function (blob) {
                    var url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modal.hide();
                        Livewire.emit('updateCroppedAvatarImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('avatarImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met_about.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('croppedAvatarImg');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
    
                    modal.hide();
                }, 'image/jpeg');
            });
        }
    });
</script>
{{-- Edit --}}
<script>
    document.addEventListener('livewire:load', function () {
        var modal = new bootstrap.Modal(document.getElementById('modal'));
        var cropper;
        
        $('#editAvatarImg').change(function (event) {
            var image = document.getElementById('sample_image');
            var files = event.target.files;
            var done = function (url) {
                image.src = url;
                modal.show();
            };
            if (files && files.length > 0) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
            handleCropButtonClick(image);
        });
    
        function handleCropButtonClick(image) {
            $('#modal').on('shown.bs.modal', function () {
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 1 / 1,
                    viewMode: 1,
                    preview: '.preview'
                });
            });
    
            $('.crop-btn').off('click').on('click', function () {
                var canvas = cropper.getCroppedCanvas({
                    width: 640,
                    height: 360
                });
    
                canvas.toBlob(function (blob) {
                    var url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modal.hide();
                        Livewire.emit('updateCroppedAvatarImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('editAvatarImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met_about.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('editCroppedAvatarImg');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
    
                    modal.hide();
                }, 'image/jpeg');
            });
        }
    });
</script>
{{-- Toggle --}}


    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script>
      var input = document.querySelector("#inputPhone");
      window.intlTelInput(input, {
        placeholderNumberType: "MOBILE",
        preferredCountries: ['iq','sa','kw','ae','lb','eg'],
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
      });
    </script>
    <script src="{{asset('assets/general/lib/country_select/countrySelect.min.js')}}"></script>
    <script>
      $("#country_selector").countrySelect({
        preferredCountries: ['iq', 'sa', 'ae']
      });
    </script>
    <script>console.log('other')</script>
@endpush
