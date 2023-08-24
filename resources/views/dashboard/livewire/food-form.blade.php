<!-- Image Crop -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.js"></script>
{{-- inline style for modal --}}
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

<div>

<!-- Insert Modal -->
<div wire:ignore.self class="modal fade overflow-auto" id="createFood" tabindex="-1" aria-labelledby="createFoodLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="saveFood">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createFoodLabel">{{__('Add Food')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                            wire:click="closeModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <div class="row mt-3">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Utilities')}}</b>
                            </h2>
                            <div class="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="mb-3">
                                <label>{{ __('Select Menu') }}</label>
                                <select wire:model="cat_id" name="cat_id" id="" class="form-control">
                                    <option value="">Select Menu</option>
                                    @foreach ($menu_select as $menu)
                                    <option value="{{$menu->translation->cat_id}}">{{$menu->translation->name}}</option>
                                    @endforeach
                                </select>
                                <small class="text-info">{{__('Select The Group')}}</small>
                                @error('cat_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="mb-3">
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="" class="form-control">
                                    <option value="">Choose Status</option>
                                    <option value="1">{{__('Active')}}</option>
                                    <option value="0">{{__('Non Active')}}</option>
                                    <small class="tetx-info">{{__('Show or Hide')}}</small>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="mb-3">
                                <label>{{__('Priority')}}</label>
                                <input type="number" wire:model="priority" class="form-control">
                                <small class="text-info">{{__('The less The Higher Priority')}}</small>
                                @error('Priority') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Title & Description')}}</b>
                            </h2>
                            <div class="">
                            </div>
                        </div>
                        @foreach ($filteredLocales as $locale)
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>{{ strtoupper($locale) }}</label>
                                <input type="text" wire:model="names.{{$locale}}" class="form-control"
                                    style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                                @error('names.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Desctip{{ strtoupper($locale) }}</label>
                                <textarea wire:model="description.{{$locale}}" class="form-control"
                                    style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}"></textarea>
                                @error('description.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            Single Price
                            <label class="switch"> <input type="checkbox" wire:model="showTextarea"
                                    id="customSwitch1"><span class="slider"></span></label>
                            Multi Price
                        </div>
                        @if ($showTextarea)
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Multiple Prices')}}</b>
                            </h2>
                            <div class="">
                                <button type="button" class="btn btn-primary" wire:click="addOption">Add New Option</button>
                            </div>
                        </div>
                        @foreach ($filteredLocales as $locale)
                        <div class="col-12 col-sm-6 border">
                            <h3>{{ strtoupper($locale) }}</h3>
                            @foreach ($options[$locale] as $index => $option)
                            <h6>{{__('Opntion No.')}} {{$index+1}}</h6>
                            <div class="row align-items-bottom">
                                <div class="form-group col-12 col-md-6 col-lg-5">
                                    <label>Option Description</label>
                                    <input type="text" wire:model="options.{{ $locale }}.{{ $index }}.key"
                                        class="form-control">
                                        <small class="text-info">{{__('exp:(Small, Medium and Large)')}}</small>
                                </div>
                                <div class="form-group col-12 col-md-6 col-lg-5">
                                    <label>Price</label>
                                    <input type="number" wire:model="options.{{ $locale }}.{{ $index }}.value"
                                        class="form-control">
                                        <small class="text-info">{{__('(Original Price)')}}</small>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <label class="d-lg-block d-none">Remove</label>
                                    <button type="button" class="btn btn-danger "
                                        wire:click="removeOption('{{ $locale }}', {{ $index }})"><i
                                            class="fas fa-minus-square"></i></button>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                        </div>
                        @endforeach

                        @else
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Single Price')}}</b>
                            </h2>
                            <div class="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="number" wire:model="price" class="form-control" id="price">
                                <small class="text-info">{{__('(Original Price)')}}</small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label for="oldPrice">Old Price</label>
                                <input type="number" wire:model="oldPrice" class="form-control" id="oldPrice">
                                <small class="text-info">{{__('(Discount Price)')}}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row mt-5">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Upload Food Image')}}</b>
                            </h2>
                            <div class="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="img">Upload Image</label>
                            <input type="file" name="foodImg" id="foodImg" class="form-control" style="height: auto">
                            <small class="text-info">The Image Size Should be <b>(640px X 360px)</b> or <b>(1280px X 720px)</b></small>
                            @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                            <input type="file" name="croppedFoodImg" id="croppedFoodImg" style="display: none;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 d-flex justify-content-center mt-1">
                                <img id="showFoodImg" class="img-thumbnail rounded" src="{{$imgFlag ? $tempImg : app('fixedimage_640x360')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="updateFoodModal" tabindex="-1" aria-labelledby="updateFoodModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl text-white">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="updateFood">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateFoodModalLabel">{{__('Edit Menu')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                            aria-label="Close"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="row mt-5">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Utilities')}}</b>
                            </h2>
                            <div class="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="mb-3">
                                <label>{{ __('Select Menu') }}</label>
                                <select wire:model="cat_id" name="cat_id" id="" class="form-control">
                                    <option value="">Select Menu</option>
                                    @foreach ($menu_select as $menu)
                                    <option value="{{$menu->translation->cat_id}}">{{$menu->translation->name}}</option>
                                    @endforeach
                                </select>
                                <small class="text-info">{{__('Select The Group')}}</small>
                                @error('cat_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="mb-3">
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="" class="form-control">
                                    <option value="">Choose Status</option>
                                    <option value="1">{{__('Active')}}</option>
                                    <option value="0">{{__('Non Active')}}</option>
                                </select>
                                <small class="text-info">{{__('Show or Hide')}}</small>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="mb-3">
                                <label>{{__('Priority')}}</label>
                                <input type="number" wire:model="priority" class="form-control">
                                <small class="text-info">{{__('The less The Higher')}}</small>
                                @error('Priority') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Title & Description')}}</b>
                            </h2>
                            <div class="">
                            </div>
                        </div>
                        @foreach ($filteredLocales as $locale)
                        <div class="col-12 col-sm-6 border">
                            <div class="mb-3">
                                <label>{{ strtoupper($locale) }}</label>
                                <input type="text" wire:model="names.{{$locale}}" class="form-control"
                                    style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                                @error('names.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Desctip{{ strtoupper($locale) }}</label>
                                <textarea wire:model="description.{{$locale}}" class="form-control"
                                    style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}"></textarea>
                                @error('description.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            Single Price
                            <label class="switch"> <input type="checkbox" wire:model="showTextarea"
                                    id="customSwitch1"><span class="slider"></span></label>
                            Multi Price
                        </div>
                        @if ($showTextarea)
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Multiple Prices')}}</b>
                            </h2>
                            <div class="">
                                <button type="button" class="btn btn-primary" wire:click="addOption">Add New Option</button>
                            </div>
                        </div>
                        @foreach ($filteredLocales as $locale)
                        <div class="col-12 col-sm-6 border">
                            <h3>{{ strtoupper($locale) }}</h3>
                            @foreach ($options[$locale] as $index => $option)
                            <h6>{{__('Opntion No.')}} {{$index+1}}</h6>
                            <div class="row align-items-bottom">
                                <div class="form-group col-12 col-md-6 col-lg-5">
                                    <label>Option Description</label>
                                    <input type="text" wire:model="options.{{ $locale }}.{{ $index }}.key"
                                        class="form-control">
                                        <small class="text-info">{{__('exp:(Small, Medium and Large)')}}</small>
                                </div>
                                <div class="form-group col-12 col-md-6 col-lg-5">
                                    <label>Price</label>
                                    <input type="text" wire:model="options.{{ $locale }}.{{ $index }}.value"
                                        class="form-control">
                                        <small class="text-info">{{__('(Original Price)')}}</small>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <label class="d-lg-block d-none">Remove</label>
                                    <button class="btn btn-danger "
                                        wire:click="removeOption('{{ $locale }}', {{ $index }})"><i
                                            class="fas fa-minus-square"></i></button>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                        </div>
                        @endforeach

                        @else
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Single Price')}}</b>
                            </h2>
                            <div class="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="number" wire:model="price" class="form-control" id="price">
                                <small class="text-info">{{__('(Original Price)')}}</small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label for="oldPrice">Old Price</label>
                                <input type="number" wire:model="oldPrice" class="form-control" id="oldPrice">
                                <small class="text-info">{{__('(Discount Price)')}}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="d-flex justidy-content-between mb-4 col-12">
                            <h2 class="text-lg font-medium mr-auto">
                                <b class="text-uppercase text-white">{{__('Upload Food Image')}}</b>
                            </h2>
                            <div class="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="img">Upload Image</label>
                            <input type="file" name="editFoodImg" id="editFoodImg" class="form-control" style="height: auto">
                            @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 d-flex justify-content-center mt-1">
                                <img id="showEditFoodImg" class="img-thumbnail rounded" src="{{ $tempImg ? $tempImg : app('cloudfront').$imgReader}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
 
 
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
</div>

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
        var modal = new bootstrap.Modal(document.getElementById('modal'));
        var cropper;
    
        $('#foodImg').change(function (event) {
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
                    aspectRatio: 640 / 360,
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
    

                    // Livewire.emit('updateCroppedFoodImg', data);
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modal.hide();
                        // $('#showFoodImg').attr('src', base64data);
                        Livewire.emit('updateCroppedFoodImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('foodImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met_about.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('croppedFoodImg');
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
    
        $('#editFoodImg').change(function (event) {
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
                    aspectRatio: 640 / 360,
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
    

                    // Livewire.emit('updateCroppedFoodImg', data);
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modal.hide();
                        // $('#showEditFoodImg').attr('src', base64data);
                        Livewire.emit('updateCroppedFoodImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('editFoodImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('editCroppedFoodImg');
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
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('toggleTextarea', () => {
            // Toggle the switch and the input/textarea
            let customSwitch1 = document.getElementById('customSwitch1');
            let textarea = document.querySelector('[wire:model="options"]');
            let priceInputs = document.querySelectorAll('[wire:model="price"], [wire:model="oldPrice"]');

            if (customSwitch1.checked) {
                textarea.style.display = 'block';
                priceInputs.forEach(input => input.style.display = 'none');
            } else {
                textarea.style.display = 'none';
                priceInputs.forEach(input => input.style.display = 'block');
            }
        });
    });
</script>
{{-- Delete Puoposes --}}
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('fixx', () => {
            window.location.reload(); 
        });
    });
</script>
@endpush


