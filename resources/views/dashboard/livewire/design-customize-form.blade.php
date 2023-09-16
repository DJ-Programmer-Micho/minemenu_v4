<div class="my-4">
<!-- Image Crop -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.js"></script>
{{-- inline style for modal --}}
<style>
    .image_area { position: relative; }
    img { display: block; max-width: 100%; }
    .preview { overflow: hidden; width: 260px;  height: 260px; margin: 10px; border: 1px solid red;}
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


{{-- MODAL 1--}}
<div wire:ignore.self class="modal fade" id="presetNameModal0" tabindex="-1" aria-labelledby="presetNameModalLabel"
    aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="presetNameModalLabel">Add New Preset</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="saveNewPreset({{0}})">
                <div class="modal-body">
                    <p>{{ __('Saving new preset?, Give a name') }}</p>
                    <p>{{ __('Please enter the Name')}}</p>
                    <input type="text" wire:model="presetNameToSave" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">{{__('Save Preset')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- MODAL 1--}}
{{-- MODAL 2--}}
<div wire:ignore.self class="modal fade" id="presetNameModal1" tabindex="-1" aria-labelledby="presetNameModalLabel"
    aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="presetNameModalLabel">Add New Preset</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="saveNewPreset({{1}})">
                <div class="modal-body">
                    <p>{{ __('Saving new preset?, Give a name') }}</p>
                    <p>{{ __('Please enter the Name')}}</p>
                    <input type="text" wire:model="presetNameToSave" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">{{__('Save Preset')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- MODAL 2--}}
{{-- MODAL 3--}}
<div wire:ignore.self class="modal fade" id="presetNameModal2" tabindex="-1" aria-labelledby="presetNameModalLabel"
    aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="presetNameModalLabel">Add New Preset</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="saveNewPreset({{2}})">
                <div class="modal-body">
                    <p>{{ __('Saving new preset?, Give a name') }}</p>
                    <p>{{ __('Please enter the Name')}}</p>
                    <input type="text" wire:model="presetNameToSave" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">{{__('Save Preset')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- MODAL 3--}}





    <div>
        {{-- <select wire:model="selectedPreset">
            <option value="p1">Preset 1</option>
            <option value="p2">Preset 2</option>
            <!-- Add more preset options as needed -->
        </select>
        <button wire:click="fixedPreset">Apply Preset</button> --}}

        <h3 class="text-white">{{__('MENU CUSTOMIZATION')}}</h3>
        <hr>
       
            <div class="well">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="embed-responsive embed-responsive-16by9 p-0 m-0" style="height:800px">
                            <iframe id="myform" name="iframe1" class="embed-responsive-item"
                                src="{{url('/'. auth()->user()->name)}}" style="border: 1" frameborder="1"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <h3 class="text-white">
                            {{__('Presets')}}
                        </h3>
                        <div class="mb-3 P">
                            <button type="button" class="btn btn-danger mb-1" wire:click="fixedPreset('p1')">CLASSIC</button>
                            <button type="button" class="btn btn-dark mb-1" wire:click="fixedPreset('p2')">DARK</button>
                        </div>
                        <h3 class="text-white mt-3">
                            {{__('User Presets')}}
                        </h3>
                        <div>
                            @for ($i = 0; $i <= 2; $i++)
                            @if (array_key_exists($i, $user_color))
                                <div class="mb-1 btn-group w-100" role="group" aria-label="Basic example">
                                    <button type="button" class="h-100 btn btn-dark w-100 mb-1" wire:click="loadPreset({{$i}})">{{$user_color[$i]['name']}}</button>
                                    <button type="button" class="h-100 btn btn-primary" wire:click="loadPreset({{$i}})"><i class="fas fa-window-restore"></i></button>
                                    <button type="button" class="h-100 btn btn-info" wire:click="saveExistPreset({{$i}},'{{$user_color[$i]['name']}}')"><i class="far fa-save"></i></button>
                                    <button type="button" class="h-100 btn btn-danger" wire:click="deletePreset({{$i}})"><i class="fas fa-ban"></i></button>
                                </div>
                            @else
                                <div class="mb-1 btn-group w-100" role="group" aria-label="Basic example">
                                    <button type="button" class="h-100 btn btn-light w-100 mb-1" data-toggle="modal" data-target="#presetNameModal{{$i}}">{{__('Empty')}}</button>
                                    <button type="button" class="h-100 btn btn-success"><i class="far fa-save"></i></button>
                                </div>
                            @endif
                            @endfor
    
                            
                            </div> 
                    <h3 class="text-white">
                        {{__('Logo And Image')}}
                    </h3>
                    <div class="accordion mb-3" id="accordionImage">
                        <div class="card bg-dark text-white">
                            <div class="card-header bg-dark text-white" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-primary btn-block text-center" type="button"
                                        data-toggle="collapse" data-target="#collapseHeadImage" aria-expanded="true"
                                        aria-controls="collapseHeadImage">
                                        <i class="far fa-images"></i> {{__('Image Control')}}
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseHeadImage" class="collapse" aria-labelledby="headingOne" data-parent="#accordionImage" wire:ignore.self>
                                <div class="card-body">
                                    <h4 class="text-white">{{__('Header Image')}}</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="img">Upload Image</label>
                                            <input type="file" name="headerImg" id="headerImg" class="form-control" style="height: auto">
                                            <small class="text-info">The Image Size Should be <b>(640px X 360px)</b> or <b>(1280px X 720px)</b></small>
                                            @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                                            <input type="file" name="croppedHeaderImg" id="croppedHeaderImg" style="display: none;">
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3 d-flex justify-content-center mt-1">
                                                <img id="showheaderImg" class="img-thumbnail rounded" src="{{$tempImg ?? app('fixedimage_640x360')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card bg-dark text-white">
                            <div class="card-header bg-dark text-white" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-danger btn-block text-center" type="button"
                                        data-toggle="collapse" data-target="#collapseLogoImage" aria-expanded="true"
                                        aria-controls="collapseLogoImage">
                                        <i class="far fa-images"></i> {{__('Logo Control')}}
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseLogoImage" class="collapse" aria-labelledby="headingOne" data-parent="#accordionImage" wire:ignore.self>
                                <div class="card-body">
                                    <h4 class="text-white">{{__('Logo/Avatar')}}</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="img">Upload Image</label>
                                            <input type="file" name="logoImg" id="logoImg" class="form-control" style="height: auto">
                                            <small class="text-info">The Image Size Should be <b>(64px X 64px)</b> or <b>(128px X 128px)</b></small>
                                            @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                                            <input type="file" name="croppedLogoImg" id="croppedLogoImg" style="display: none;">
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3 d-flex justify-content-center mt-1">
                                                <img id="showLogoImg" class="img-thumbnail rounded" src="{{$tempImgLogo ?? app('fixedimage_640x360')}}" style="width: 256px; height: 256px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-white">
                        {{__('Color Control')}}
                    </h3>
                    <form wire:submit.prevent="saveColors">
                        <div class="accordion " id="accordionExample">
                            <div class="card bg-dark text-white">
                                <div class="card-header bg-dark text-white" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-primary btn-block text-center" type="button"
                                            data-toggle="collapse" data-target="#collapseNavbar" aria-expanded="true"
                                            aria-controls="collapseNavbar">
                                            <i class="fas fa-bars"></i> {{__('Navbar Control')}}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseNavbar" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" wire:ignore>
                                    <div class="card-body">
                                        <h4 class="text-white">{{__('Navbar Background Color')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="selected_navbar_top">{{__('Top Background')}}</label>
                                                    <br>
                                                    <input type="color" id="navbar_top"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_navbar_top">
                                                    <small class="text-info">(Ui 3)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="selected_navbar_top_ground">{{__('Top Ground')}}</label>
                                                    <br>
                                                    <input type="color" id="navbar_top_ground"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_navbar_top_ground">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_navbar_bottom_ground">{{__('Bottom Ground')}}</label>
                                                    <br>
                                                    <input type="color" id="navbar_bottom_ground"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_navbar_bottom_ground">
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="text-white">{{__('Navbar Text Color')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="selected_navbar_title">{{__('Title')}}</label>
                                                    <br>
                                                    <input type="color" id="navbar_title"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_navbar_title">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="selected_navbar_toggle">{{__('Toggle')}}</label>
                                                    <br>
                                                    <input type="color" id="navbar_toggle"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_navbar_toggle">
                                                    <small class="text-info">(Ui 1, Ui 2)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="selected_navbar_sub_title">{{__('Sub Title')}}</label>
                                                    <br>
                                                    <input type="color" id="navbar_sub_title"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_navbar_sub_title">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="selected_navbar_text">{{__('Text')}}</label>
                                                    <br>
                                                    <input type="color" id="navbar_text"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_navbar_text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-dark text-white">
                                <div class="card-header bg-dark text-white" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-danger btn-block text-center" type="button"
                                            data-toggle="collapse" data-target="#collapseMain" aria-expanded="true"
                                            aria-controls="collapseMain">
                                            <i class="fas fa-palette"></i> {{__('Main Control')}}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseMain" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample" wire:ignore>
                                    <div class="card-body">
                                        <h4 class="text-white">{{__('Main Background Color')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_main_background">{{__('Background')}}</label>
                                                    <br>
                                                    <input type="color" id="main_background"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_main_background">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_main_body">{{__('Main Background')}}</label>
                                                    <br>
                                                    <input type="color" id="main_body"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_main_body">
                                                    <small class="text-info">(Ui 1, Ui 2)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="text-white">{{__('Main Theme')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_main_theme_text">{{__('Text')}}</label>
                                                    <br>
                                                    <input type="color" id="main_theme_text"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_main_theme_text">
                                                    <small class="text-info">(Ui 3)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_main_theme_background">{{__('Background')}}</label>
                                                    <br>
                                                    <input type="color" id="main_theme_background"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_main_theme_background">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_main_theme_text_active">{{__('Text Active')}}</label>
                                                    <br>
                                                    <input type="color" id="main_theme_text_active"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_main_theme_text_active">
                                                    <small class="text-info">(Ui 3)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_main_theme_background_active">{{__('Background Active')}}</label>
                                                    <br>
                                                    <input type="color" id="main_theme_background_active"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_main_theme_background_active">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_main_theme_border">{{__('Border')}}</label>
                                                    <br>
                                                    <input type="color" id="main_theme_border"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_main_theme_border">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="text-white">{{__('Main Category Card')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="selected_main_card_text">{{__('Card Text')}}</label>
                                                    <br>
                                                    <input type="color" id="main_card_text"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_main_card_text">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_main_card_opacity">{{__('Opacity')}}</label>
                                                    <br>
                                                    <input type="number" id="main_card_opacity"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_main_card_opacity" min="0.00"
                                                        max="1.00" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-dark text-white">
                                <div class="card-header bg-dark text-white" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-success btn-block text-center" type="button"
                                            data-toggle="collapse" data-target="#collapseCart" aria-expanded="true"
                                            aria-controls="collapseCart">
                                            <i class="fas fa-shopping-cart"></i> {{__('Cart Control')}}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseCart" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" wire:ignore>
                                    <div class="card-body">
                                        <h4 class="text-white">{{__('Cart Main')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="selected_cart_icon">{{__('Cart Icon')}}</label>
                                                    <br>
                                                    <input type="color" id="cart_icon"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_cart_icon">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_cart_back_icon">{{__('Cart Icon Background')}}</label>
                                                    <br>
                                                    <input type="color" id="cart_back_icon"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_cart_back_icon">
                                                    <small class="text-info">(Ui 1, Ui 2)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_cart_noti">{{__('Notification Number')}}</label>
                                                    <br>
                                                    <input type="color" id="cart_noti"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_cart_noti">
                                                    <small class="text-info">(Ui 3)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_cart_back_noti">{{__('Notification Background Number')}}</label>
                                                    <br>
                                                    <input type="color" id="cart_back_noti"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_cart_back_noti">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="text-white">{{__('Cart List')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="selected_cart_text">{{__('Cart List Text')}}</label>
                                                    <br>
                                                    <input type="color" id="cart_text"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_cart_text">
                                                    <small class="text-info">(Ui 3)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_cart_background">{{__('Cart List Background')}}</label>
                                                    <br>
                                                    <input type="color" id="cart_background"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_cart_background">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_cart_reset_text">{{__('Reset Button Text')}}</label>
                                                    <br>
                                                    <input type="color" id="cart_reset_text"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_cart_reset_text">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_cart_reset_backgound">{{__('Reset Button Background')}}</label>
                                                    <br>
                                                    <input type="color" id="cart_reset_backgound"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_cart_reset_backgound">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_cart_close_text">{{__('Close Button Text')}}</label>
                                                    <br>
                                                    <input type="color" id="cart_close_text"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_cart_close_text">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_cart_close_backgound">{{__('Close Button Background')}}</label>
                                                    <br>
                                                    <input type="color" id="cart_close_backgound"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_cart_close_backgound">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-dark text-white">
                                <div class="card-header bg-dark text-white" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-info btn-block text-center" type="button"
                                            data-toggle="collapse" data-target="#collapseList"
                                            aria-expanded="true" aria-controls="collapseList">
                                            <i class="fas fa-utensils"></i> {{__('Food List Control')}}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseList" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample" wire:ignore>
                                    <div class="card-body">
                                        <h4 class="text-white">{{__('Food Card')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_category_title">{{__('Food Title')}}</label>
                                                    <br>
                                                    <input type="color" id="category_title"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_category_title">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_category_description">{{__('Food Description')}}</label>
                                                    <br>
                                                    <input type="color" id="category_description"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_category_description">
                                                    <small class="text-info">(Ui 1, Ui 2)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_category_price">{{__('Food Price')}}</label>
                                                    <br>
                                                    <input type="color" id="category_price"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_category_price">
                                                    <small class="text-info">(Ui 3)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_category_old_price">{{__('Food Old Price')}}</label>
                                                    <br>
                                                    <input type="color" id="category_old_price"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_category_old_price">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_category_card_background">{{__('Food Card Color')}}</label>
                                                    <br>
                                                    <input type="color" id="category_card_background"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_category_card_background">
                                                    <small class="text-info">(Ui 3)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_category_shabow">{{__('Food Card Shadow')}}</label>
                                                    <br>
                                                    <input type="color" id="category_shabow"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_category_shabow">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="text-white">{{__('See More Button')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_category_button_text">{{__('Button Text')}}</label>
                                                    <br>
                                                    <input type="color" id="category_button_text"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_category_button_text">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_category_button_background">{{__('Button Background')}}</label>
                                                    <br>
                                                    <input type="color" id="category_button_background"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_category_button_background">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-dark text-white">
                                <div class="card-header bg-dark text-white" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-warning btn-block text-center text-dark" type="button"
                                            data-toggle="collapse" data-target="#collapseFood"
                                            aria-expanded="true" aria-controls="collapseFood">
                                            <i class="fas fa-hamburger"></i> {{__('Food Details Control')}}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseFood" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample" wire:ignore>
                                    <div class="card-body">
                                        <h4 class="text-white">{{__('Main Color')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_background">{{__('Background')}}</label>
                                                    <br>
                                                    <input type="color" id="food_background"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_background">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_image_shadow">{{__('Image Shadow')}}</label>
                                                    <br>
                                                    <input type="color" id="food_image_shadow"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_image_shadow">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_image_shadow_opacity">{{__('Shadow Opacity')}}</label>
                                                    <br>
                                                    <input type="number" id="food_image_shadow_opacity"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_image_shadow_opacity" 
                                                        min="0.00" max="1.00" step="0.01">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <h4 class="text-white">{{__('Text Color')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_title">{{__('Food Title')}}</label>
                                                    <br>
                                                    <input type="color" id="food_title"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_title">
                                                    <small class="text-info">(Ui 1, Ui 2)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_description">{{__('Food Description')}}</label>
                                                    <br>
                                                    <input type="color" id="food_description"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_description">
                                                    <small class="text-info">(Ui 3)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <h4 class="text-white">{{__('Price Color Single & Multi')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_price">{{__('Food Price')}}</label>
                                                    <br>
                                                    <input type="color" id="food_price"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_price">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_old_price">{{__('Food Old Price')}}</label>
                                                    <br>
                                                    <input type="color" id="food_old_price"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_old_price">
                                                    <small class="text-info">(Ui 3)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_price_key">{{__('Food Multi Name')}}</label>
                                                    <br>
                                                    <input type="color" id="food_price_key"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_price_key">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_price_value">{{__('Food Multi Price')}}</label>
                                                    <br>
                                                    <input type="color" id="food_price_value"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_price_value">
                                                    <small class="text-info">(Ui 3)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <h4 class="text-white">{{__('Plus/Minus')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_button_text">{{__('Food Plus/Minus Text')}}</label>
                                                    <br>
                                                    <input type="color" id="food_button_text"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_button_text">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_food_button_background">{{__('Food Plus/Minus Background')}}</label>
                                                    <br>
                                                    <input type="color" id="food_button_background"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_food_button_background">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-dark text-white">
                                <div class="card-header bg-dark text-white" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-light btn-block text-center text-dark" type="button"
                                            data-toggle="collapse" data-target="#collapseUtl"
                                            aria-expanded="true" aria-controls="collapseUtl">
                                            <i class="fas fa-arrow-left"></i> {{__('Utilities')}}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseUtl" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample" wire:ignore>
                                    <div class="card-body">
                                        <h4 class="text-white">{{__('Main Color')}}</h4>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_utl_icon_color">{{__('Icon Color')}}</label>
                                                    <br>
                                                    <input type="color" id="utl_icon_color"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_utl_icon_color">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="selected_utl_icon_background">{{__('Background color')}}</label>
                                                    <br>
                                                    <input type="color" id="utl_icon_background"
                                                        class="form-control color-control p-1"
                                                        wire:model="selected_utl_icon_background">
                                                    <small class="text-info">(All UI's)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="my-4 btn btn-info" wire:click="saveColors">Update Colors</button>
                    </form>
                    </div>
                </div>
            </div>
    </div>


{{-- IMAGE CROP MODAL --}}
<div class="modal fade" id="modal_header_image" tabindex="-2" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                            <img src="" id="sample_image_header_image" />
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
@push('color')
<script>
    // Function to apply the color to the iframe's content
    function applyColorToIframe() {
        //NAVBAR GROUP
        var navbarTitle = document.getElementById("navbar_title").value;
        var navbarToggle = document.getElementById("navbar_toggle").value;
        var navbarTop = document.getElementById("navbar_top").value;
        var navbarSubTitle = document.getElementById("navbar_sub_title").value;
        var navbarText = document.getElementById("navbar_text").value;
        var navbarTopGround = document.getElementById("navbar_top_ground").value;
        var navbarBottomGround = document.getElementById("navbar_bottom_ground").value;
        //Main Group
        var mainBackground = document.getElementById("main_background").value;
        var mainBody = document.getElementById("main_body").value;
        var mainThemeText = document.getElementById("main_theme_text").value;
        var mainThemeBackground = document.getElementById("main_theme_background").value;
        var mainThemeTextActive = document.getElementById("main_theme_text_active").value;
        var mainThemeBackgroundActive = document.getElementById("main_theme_background_active").value;
        var mainThemeBorder = document.getElementById("main_theme_border").value;
        var mainCardText = document.getElementById("main_card_text").value;
        var mainCardOpacity = document.getElementById("main_card_opacity").value;
        //Cart Group   
        var cartIcon = document.getElementById("cart_icon").value;
        var cartBackIcon = document.getElementById("cart_back_icon").value;
        var cartNoti = document.getElementById("cart_noti").value;
        var cartBackNoti = document.getElementById("cart_back_noti").value;
        var cartText = document.getElementById("cart_text").value;
        var cartBackground = document.getElementById("cart_background").value;
        var cartResetext = document.getElementById("cart_reset_text").value;
        var cartResetBackgound = document.getElementById("cart_reset_backgound").value;
        var cartCloseText = document.getElementById("cart_close_text").value;
        var cartCloseBackgound = document.getElementById("cart_close_backgound").value;
        //Category Group   
        var categoryTitle = document.getElementById("category_title").value;
        var categoryDescription = document.getElementById("category_description").value;
        var categoryPrice = document.getElementById("category_price").value;
        var categoryOldPrice = document.getElementById("category_old_price").value;
        var categoryCardBackground = document.getElementById("category_card_background").value;
        var categoryShabow = document.getElementById("category_shabow").value;
        var categoryButtonText = document.getElementById("category_button_text").value;
        var categoryButtonBackground = document.getElementById("category_button_background").value;
        //Food Detail Group   
        var foodBackground = document.getElementById("food_background").value;
        var foodTitle = document.getElementById("food_title").value;
        var foodDescription = document.getElementById("food_description").value;
        var foodPrice = document.getElementById("food_price").value;
        var foodOldPrice = document.getElementById("food_old_price").value;
        var foodPriceKey = document.getElementById("food_price_key").value;
        var foodPriceValue = document.getElementById("food_price_value").value;
        var foodButtonText = document.getElementById("food_button_text").value;
        var foodButtonBackground = document.getElementById("food_button_background").value;
        var foodImageShadow = document.getElementById("food_image_shadow").value;
        var foodImageShadowOpacity = document.getElementById("food_image_shadow_opacity").value;
        //Utilities
        var utlIconColor = document.getElementById("utl_icon_color").value;
        var utlIconBackground = document.getElementById("utl_icon_background").value;


        //Form
        var myframe = document.querySelector("iframe").contentWindow.document;

        //NAVBAR GROUP
        myframe.documentElement.style.setProperty('--navbar-title-color', navbarTitle);
        myframe.documentElement.style.setProperty('--navbar-toggle-color', navbarToggle);
        myframe.documentElement.style.setProperty('--navbar-top-color', navbarTop);
        myframe.documentElement.style.setProperty('--navbar-sub-title-color', navbarSubTitle);
        myframe.documentElement.style.setProperty('--navbar-text-color', navbarText);
        myframe.documentElement.style.setProperty('--navbar-top-ground-color', navbarTopGround); 
        myframe.documentElement.style.setProperty('--navbar-bottom-ground-color', navbarBottomGround); 
        //Main Group
        myframe.documentElement.style.setProperty('--main-background-color', mainBackground);
        myframe.documentElement.style.setProperty('--main-body-color', mainBody);
        myframe.documentElement.style.setProperty('--main-theme-text-color', mainThemeText);   
        myframe.documentElement.style.setProperty('--main-theme-backgroud-color', mainThemeBackground);
        myframe.documentElement.style.setProperty('--main-theme-text-active-color', mainThemeTextActive);   
        myframe.documentElement.style.setProperty('--main-theme-background-active-color', mainThemeBackgroundActive);
        myframe.documentElement.style.setProperty('--main-theme-border-active-color', mainThemeBorder);
        myframe.documentElement.style.setProperty('--main-card-text-color', mainCardText); 
        myframe.documentElement.style.setProperty('--main-card-opacity-color', mainCardOpacity);  
        //Cart Group    
        myframe.documentElement.style.setProperty('--cart-icon-color', cartIcon);
        myframe.documentElement.style.setProperty('--cart-back-icon-color', cartBackIcon);
        myframe.documentElement.style.setProperty('--cart-noti-color', cartNoti);   
        myframe.documentElement.style.setProperty('--cart-back-noti-color', cartBackNoti);
        myframe.documentElement.style.setProperty('--cart-text-color', cartText);   
        myframe.documentElement.style.setProperty('--cart-background-color', cartBackground);
        myframe.documentElement.style.setProperty('--cart-reset-text-color', cartResetext);
        myframe.documentElement.style.setProperty('--cart-reset-backgound-color', cartResetBackgound); 
        myframe.documentElement.style.setProperty('--cart-close-text-color', cartCloseText); 
        myframe.documentElement.style.setProperty('--cart-close-backgound-color', cartCloseBackgound); 
        //Category Group   
        myframe.documentElement.style.setProperty('--category-title-color', categoryTitle);
        myframe.documentElement.style.setProperty('--category-description-color', categoryDescription);
        myframe.documentElement.style.setProperty('--category-price-color', categoryPrice);   
        myframe.documentElement.style.setProperty('--category-old-price-color', categoryOldPrice);
        myframe.documentElement.style.setProperty('--category-card-background-color', categoryCardBackground);   
        myframe.documentElement.style.setProperty('--category-shadow-color', categoryShabow);
        myframe.documentElement.style.setProperty('--category-button-text-color', categoryButtonText);
        myframe.documentElement.style.setProperty('--category-button-background-color', categoryButtonBackground);
        //Food Detail Group   
        myframe.documentElement.style.setProperty('--food-background', foodBackground);
        myframe.documentElement.style.setProperty('--food-title', foodTitle);
        myframe.documentElement.style.setProperty('--food-description', foodDescription);   
        myframe.documentElement.style.setProperty('--food-price', foodPrice);
        myframe.documentElement.style.setProperty('--food-old-price', foodOldPrice); 
        myframe.documentElement.style.setProperty('--food-button-text', foodButtonText);
        myframe.documentElement.style.setProperty('--food-price-key', foodPriceKey);
        myframe.documentElement.style.setProperty('--food-price-value', foodPriceValue);
        myframe.documentElement.style.setProperty('--food-button-background', foodButtonBackground);
        myframe.documentElement.style.setProperty('--food-image-shadow', foodImageShadow);
        myframe.documentElement.style.setProperty('--food-image-shadow-opacity', foodImageShadowOpacity);
        //Utilities
        myframe.documentElement.style.setProperty('--utl-icon-color', utlIconColor);
        myframe.documentElement.style.setProperty('--utl-icon-background', utlIconBackground);
    }

    const cssVariableMapping = {
        navbarTitle: '--navbar-title-color',
        navbarToggle: '--navbar-toggle-color',
        navbarTop: '--navbar-top-color',
        navbarSubTitle: '--navbar-sub-title-color',
        navbarText: '--navbar-text-color',
        navbarTopGround: '--navbar-top-ground-color',
        navbarBottomGround: '--navbar-bottom-ground-color',
        mainBackground: '--main-background-color',
        mainBody: '--main-body-color',
        mainThemeText: '--main-theme-text-color',
        mainThemeBackground: '--main-theme-background-color',
        mainThemeTextActive: '--main-theme-text-active-color',
        mainThemeBackgroundActive: '--main-theme-background-active-color',
        mainThemeBorder: '--main-theme-border-active-color',
        mainCardText: '--main-card-text-color',
        mainCardOpacity: '--main-card-opacity-color',
        cartIcon: '--cart-icon-color',
        cartBackIcon: '--cart-back-icon-color',
        cartNoti: '--cart-noti-color',
        cartBackNoti: '--cart-back-noti-color',
        cartText: '--cart-text-color',
        cartBackground: '--cart-background-color',
        cartResetext: '--cart-reset-text-color',
        cartResetBackgound: '--cart-reset-backgound-color',
        cartCloseText: '--cart-close-text-color',
        cartCloseBackgound: '--cart-close-backgound-color',
        categoryTitle: '--category-title-color',
        categoryDescription: '--category-description-color',
        categoryPrice: '--category-price-color',
        categoryOldPrice: '--category-old-price-color',
        categoryCardBackground: '--category-card-background-color',
        categoryShabow: '--category-shadow-color',
        categoryButtonText: '--category-button-text-color',
        categoryButtonBackground: '--category-button-background-color',
        foodBackground: '--food-background',
        foodTitle: '--food-title',
        foodDescription: '--food-description',
        foodPrice: '--food-price',
        foodOldPrice: '--food-old-price',
        foodPriceKey: '--food-price-key',
        foodPriceValue: '--food-price-value',
        foodButtonText: '--food-button-text',
        foodButtonBackground: '--food-button-background',
        foodImageShadow: '--food-image-shadow',
        foodImageShadowOpacity: '--food-image-shadow-opacity',
        utlIconColor: '--utl-icon-color',
        utlIconBackground: '--utl-icon-background',
    };
  
    // Event listener for input changes
    $('.color-control').on('input', function() {
        applyColorToIframe();
    });

    // Event listener for iframe content load
    var iframe = document.querySelector("iframe");
    iframe.addEventListener("load", function() {
        applyColorToIframe();
    });

    window.addEventListener('userPreset', function () {
        applyColorToIframe();
    });
</script>
<script>
   window.addEventListener('fixedPreset', function (presetData) {
       const presetDataCss = presetData.detail;
       // Get the iframe element
        const iframe = document.getElementById('myform');
        // Access the iframe's content window
        const iframeContent = iframe.contentWindow;
        console.log(presetDataCss);
        console.log('Keys in presetData:', Object.keys(presetDataCss));
        
        // Loop through the presetData and set CSS variables
        for (const key in presetDataCss) {
            if (presetDataCss.hasOwnProperty(key) && cssVariableMapping[key]) {

                // Get the corresponding CSS variable name from the mapping
                const cssVariableName = cssVariableMapping[key];

                // Log the CSS variable name and value for debugging
                console.log('Setting CSS variable:', cssVariableName, 'to value:', presetDataCss[key]);

                // Set CSS variables within the iframe's content
                iframeContent.document.documentElement.style.setProperty(cssVariableName, presetDataCss[key]);
            }
        }
    });

    window.addEventListener('refreshSave', function (presetData) {
        location.reload();
        alert("{{__('Please select the name you provided to confirm your changes')}}");
    });
    window.addEventListener('refreshDelete', function (presetData) {
        location.reload();
    });

</script>
@endpush

@push('cropper')
{{-- Add Image Header--}}
<script>
    document.addEventListener('livewire:load', function () {
        var modal = new bootstrap.Modal(document.getElementById('modal_header_image'));
        var cropper;
    
        $('#headerImg').change(function (event) {
            console.log(document.getElementById('headerImg').value)
            var image = document.getElementById('sample_image_header_image');
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
            $('#modal_header_image').on('shown.bs.modal', function () {
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 1030 / 480,
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
                        Livewire.emit('updateCroppedHeaderImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('headerImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met_about.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('croppedHeaderImg');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
    
                    modal.hide();
                }, 'image/jpeg');
                setTimeout(function () {
                    document.getElementById('myform').contentWindow.location.reload();
                }, 5000); 
            });
        }
    });
</script>
{{-- Add Logo OR Avatar--}}
<script>
    document.addEventListener('livewire:load', function () {
        var modal = new bootstrap.Modal(document.getElementById('modal_header_image'));
        var cropper;
    
        $('#logoImg').change(function (event) {
            // console.log(document.getElementById('logoImg').value)
            var image = document.getElementById('sample_image_header_image');
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
            $('#modal_header_image').on('shown.bs.modal', function () {
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
                    width: 256,
                    height: 256
                });
    
                canvas.toBlob(function (blob) {
                    var url = URL.createObjectURL(blob);
    
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modal.hide();
                        Livewire.emit('updateCroppedLogoImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('logoImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);

                    var file = new File([blob], 'met_about.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('croppedLogoImg');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
    
                    modal.hide();
                }, 'image/jpeg');
                setTimeout(function () {
                    document.getElementById('myform').contentWindow.location.reload();
                }, 5000); 
            });
        }
    });
</script>
@endpush