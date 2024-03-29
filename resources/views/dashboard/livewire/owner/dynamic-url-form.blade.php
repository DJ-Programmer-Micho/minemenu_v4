<div>
    <link href="{{asset('assets/dashboard/css/qr-style.css')}}" rel="stylesheet">
    <style>
        .accordion {
            background-color: #334165;
        }
    </style>
    <!-- Insert Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createAd" tabindex="-1" aria-labelledby="createAdLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="saveAd">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createAdLabel">{{__('Add New QR Code Ad')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <div class="row mt-3">
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <h2 class="text-lg font-medium mr-auto">
                                    <b class="text-uppercase text-white">{{__('Initiale Information')}}</b>
                                </h2>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Name of the Ad')}}</label>
                                    <input type="text" name="adName" wire:model="adName" class="form-control" required>
                                    @error('adName') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Redirect URL of the ad')}}</label>
                                    <input type="text" wire:model="redirect_url" class="form-control" required>
                                    @error('redirect_url') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
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

    <div wire:ignore.self class="modal fade overflow-auto" id="updateAd" tabindex="-1" aria-labelledby="updateAdLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateAd">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateAdLabel">{{__('Update QR Code Ad')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <div class="row mt-3">
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <h2 class="text-lg font-medium mr-auto">
                                    <b class="text-uppercase text-white">{{__('Initiale Information')}}</b>
                                </h2>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Name of the Ad')}}</label>
                                    <input type="text" name="adName" wire:model="adName" class="form-control" disabled required>
                                    @error('adName') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label>{{__('Redirect URL of the ad')}}</label>
                                    <input type="text" wire:model="redirect_url" class="form-control" required>
                                    @error('redirect_url') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
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



    <div wire:ignore.self class="modal fade" id="deleteAd" tabindex="-1" aria-labelledby="deleteAdLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAdLabel">{{__('Delete Qr Ad')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroyAd">
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this Ad?') }}
                    <small class="text-danger"><b>{{ __('ALL The Data Will be removed about this QR CODE!') }}</b></small>
                    </p>
                    <p>{{ __('Please enter the')}}<strong> "{{$showTextTemp}}" </strong>{{__('to confirm:') }}</p>
                    <input type="text" wire:model="adNameToDelete" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-danger" wire:disabled="!confirmDelete || adNameToDelete !== $showTextTemp">
                            {{ __('Yes! Delete') }}
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade overflow-auto" id="createQr" tabindex="-1" aria-labelledby="createQrLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="addQr" class="col qr-form border text-white" id="form">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createQrLabel">{{__('Generate QR')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <main>
                        <section class="container qr-description d-none" id="qr-description">
                            <div class="col">
                            </div>
                        </section>
                        <section class="container mb-5">
                            <div class="row row--body p-0">
                                {{-- <form > --}}
                                    <button type="button" class="accordion accordion--open">Main Options</button>
                                    <div class="panel panel--open">
                                        <label for="form-data"></label>
                                        {{-- <input node="data" node-change-event="oninput" id="form-data" type="hidden" value="https://minemenu.com/{{auth()->user()->name}}" /><br> --}}
                                        <input node="data" node-change-event="oninput" id="form-data" type="hidden" value="{{env('APP_URL').$qrName}}" /><br>
                                        <label for="form-image-file">Image File</label>
                                        <div class="buttons-container">
                                            <input node="image" node-data-field="files" id="form-image-file" type="file" />
                                            <button type="button" id="button-cancel">Cancel</button>
                                        </div>
                                        <label for="form-width">Width</label>
                                        <div>
                                            <input node="width" id="form-width" type="number" min="100" max="10000" value="500"/>
                                        </div>
                                        <label for="form-height">Height</label>
                                        <div>
                                            <input node="height" id="form-height" type="number" min="100" max="10000" value="500"/>
                                        </div>
                                        <label for="form-height">Margin</label>
                                        <div>
                                            <input node="margin" id="form-margin" type="number" min="0" max="10000" value="10"/>
                                        </div>
                                    </div>
                                    <button type="button" class="accordion">Dots Options</button>
                                    <div class="panel">
                                        <label for="form-dots-type">Dots Style</label>
                                        <div>
                                            <select node="dotsOptions.type" id="form-dots-type">
                                                <option value="square">Square</option>
                                                <option value="dots">Dots</option>
                                                <option value="rounded">Rounded</option>
                                                <option value="extra-rounded" selected>Extra rounded</option>
                                                <option value="classy">Classy</option>
                                                <option value="classy-rounded">Classy rounded</option>
                                            </select>
                                        </div>
                                        <label>Color Type</label>
                                        <div class="space-between-container">
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="dotsOptionsHelper.colorType.single" id="form-dots-color-type-single" type="radio" name="dots-color-type" checked/>
                                                <label for="form-dots-color-type-single">Single color</label>
                                            </div>
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="dotsOptionsHelper.colorType.gradient" id="form-dots-color-type-gradient" type="radio" name="dots-color-type"/>
                                                <label for="form-dots-color-type-gradient">Color gradient</label>
                                            </div>
                                        </div>
                                        <label class="dotsOptionsHelper.colorType.single" for="form-dots-color">Dots Color</label>
                                        <div class="dotsOptionsHelper.colorType.single">
                                            <input node="dotsOptions.color" id="form-dots-color" type="color" value="#cc0022"/>
                                        </div>
                                        <label class="dotsOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">Gradient Type</label>
                                        <div class="dotsOptionsHelper.colorType.gradient space-between-container" style="visibility: hidden; height: 0">
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="dotsOptionsHelper.gradient.linear" id="form-dots-gradient-type-linear" type="radio" name="dots-gradient-type" checked/>
                                                <label for="form-dots-gradient-type-linear">Linear</label>
                                            </div>
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="dotsOptionsHelper.gradient.radial" id="form-dots-gradient-type-radial" type="radio" name="dots-gradient-type"/>
                                                <label for="form-dots-gradient-type-radial">Radial</label>
                                            </div>
                                        </div>
                                        <label class="dotsOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">Dots Gradient</label>
                                        <div class="dotsOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">
                                            <input node="dotsOptionsHelper.gradient.color1" type="color" value="#6a1a4c"/>
                                            <input node="dotsOptionsHelper.gradient.color2" type="color" value="#6a1a4c"/>
                                        </div>
                                        <label class="dotsOptionsHelper.colorType.gradient" for="form-dots-gradient-rotation" style="visibility: hidden; height: 0">Rotation</label>
                                        <div class="dotsOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">
                                            <input node="dotsOptionsHelper.gradient.rotation" id="form-dots-gradient-rotation" type="number" min="0" max="360" value="0"/>
                                        </div>
                                    </div>
                                    <button type="button" class="accordion">Corners Square Options</button>
                                    <div class="panel">
                                        <label for="form-corners-square-type">Corners Square Style</label>
                                        <div>
                                            <select node="cornersSquareOptions.type" id="form-corners-square-type">
                                                <option value="">None</option>
                                                <option value="square">Square</option>
                                                <option value="dot">Dot</option>
                                                <option value="extra-rounded" selected>Extra rounded</option>
                                            </select>
                                        </div>
                                        <label>Color Type</label>
                                        <div class="space-between-container">
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="cornersSquareOptionsHelper.colorType.single" id="form-corners-square-color-type-single" type="radio" name="corners-square-color-type" checked/>
                                                <label for="form-corners-square-color-type-single">Single color</label>
                                            </div>
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="cornersSquareOptionsHelper.colorType.gradient" id="form-corners-square-color-type-gradient" type="radio" name="corners-square-color-type"/>
                                                <label for="form-corners-square-color-type-gradient">Color gradient</label>
                                            </div>
                                        </div>
                                        <label class="cornersSquareOptionsHelper.colorType.single" for="form-corners-square-color">Corners Square Color</label>
                                        <div class="cornersSquareOptionsHelper.colorType.single buttons-container">
                                            <input node="cornersSquareOptions.color" id="form-corners-square-color" type="color" value="#000000"/>
                                            <button type="button" id="button-clear-corners-square-color">Clear</button>
                                        </div>
                                        <label class="cornersSquareOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">Gradient Type</label>
                                        <div class="cornersSquareOptionsHelper.colorType.gradient space-between-container" style="visibility: hidden; height: 0">
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="cornersSquareOptionsHelper.gradient.linear" id="form-corners-square-gradient-type-linear" type="radio" name="corners-square-gradient-type" checked/>
                                                <label for="form-corners-square-gradient-type-linear">Linear</label>
                                            </div>
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="cornersSquareOptionsHelper.gradient.radial" id="form-corners-square-gradient-type-radial" type="radio" name="corners-square-gradient-type"/>
                                                <label for="form-corners-square-gradient-type-radial">Radial</label>
                                            </div>
                                        </div>
                                        <label class="cornersSquareOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">Dots Gradient</label>
                                        <div class="cornersSquareOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">
                                            <input node="cornersSquareOptionsHelper.gradient.color1" type="color" value="#000000"/>
                                            <input node="cornersSquareOptionsHelper.gradient.color2" type="color" value="#000000"/>
                                        </div>
                                        <label class="cornersSquareOptionsHelper.colorType.gradient" for="form-corners-square-gradient-rotation" style="visibility: hidden; height: 0">Rotation</label>
                                        <div class="cornersSquareOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">
                                            <input node="cornersSquareOptionsHelper.gradient.rotation" id="form-corners-square-gradient-rotation" type="number" min="0" max="360" value="0"/>
                                        </div>
                                    </div>
                                    <button type="button" class="accordion">Corners Dot Options</button>
                                    <div class="panel">
                                        <label for="form-corners-dot-type">Corners Dot Style</label>
                                        <div>
                                            <select node="cornersDotOptions.type" id="form-corners-dot-type">
                                                <option value="" selected>None</option>
                                                <option value="square">Square</option>
                                                <option value="dot">Dot</option>
                                            </select>
                                        </div>
                                        <label>Color Type</label>
                                        <div class="space-between-container">
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="cornersDotOptionsHelper.colorType.single" id="form-corners-dot-color-type-single" type="radio" name="corners-dot-color-type" checked/>
                                                <label for="form-corners-dot-color-type-single">Single color</label>
                                            </div>
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="cornersDotOptionsHelper.colorType.gradient" id="form-corners-dot-color-type-gradient" type="radio" name="corners-dot-color-type"/>
                                                <label for="form-corners-dot-color-type-gradient">Color gradient</label>
                                            </div>
                                        </div>
                                        <label class="cornersDotOptionsHelper.colorType.single" for="form-corners-dot-color">Corners Dot Color</label>
                                        <div class="cornersDotOptionsHelper.colorType.single buttons-container">
                                            <input node="cornersDotOptions.color" id="form-corners-dot-color" type="color" value="#000000"/>
                                            <button type="button" id="button-clear-corners-dot-color">Clear</button>
                                        </div>
                                        <label class="cornersDotOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">Gradient Type</label>
                                        <div class="cornersDotOptionsHelper.colorType.gradient space-between-container" style="visibility: hidden; height: 0">
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="cornersDotOptionsHelper.gradient.linear" id="form-corners-dot-gradient-type-linear" type="radio" name="corners-dot-gradient-type" checked/>
                                                <label for="form-corners-dot-gradient-type-linear">Linear</label>
                                            </div>
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="cornersDotOptionsHelper.gradient.radial" id="form-corners-dot-gradient-type-radial" type="radio" name="corners-dot-gradient-type"/>
                                                <label for="form-corners-dot-gradient-type-radial">Radial</label>
                                            </div>
                                        </div>
                                        <label class="cornersDotOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">Dots Gradient</label>
                                        <div class="cornersDotOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">
                                            <input node="cornersDotOptionsHelper.gradient.color1" type="color" value="#000000"/>
                                            <input node="cornersDotOptionsHelper.gradient.color2" type="color" value="#000000"/>
                                        </div>
                                        <label class="cornersDotOptionsHelper.colorType.gradient" for="form-corners-dot-gradient-rotation" style="visibility: hidden; height: 0">Rotation</label>
                                        <div class="cornersDotOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">
                                            <input node="cornersDotOptionsHelper.gradient.rotation" id="form-corners-dot-gradient-rotation" type="number" min="0" max="360" value="0"/>
                                        </div>
                                    </div>
                                    <button type="button" class="accordion">Background Options</button>
                                    <div class="panel">
                                        <label>Color Type</label>
                                        <div class="space-between-container">
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="backgroundOptionsHelper.colorType.single" id="form-background-color-type-single" type="radio" name="background-color-type" checked/>
                                                <label for="form-background-color-type-single">Single color</label>
                                            </div>
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="backgroundOptionsHelper.colorType.gradient" id="form-background-color-type-gradient" type="radio" name="background-color-type"/>
                                                <label for="form-background-color-type-gradient">Color gradient</label>
                                            </div>
                                        </div>
                                        <label class="backgroundOptionsHelper.colorType.single" for="form-background-color">Background Color</label>
                                        <div class="backgroundOptionsHelper.colorType.single">
                                            <input node="backgroundOptions.color" id="form-background-color" type="color" value="#ffffff"/>
                                        </div>
                                        <label class="backgroundOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">Gradient Type</label>
                                        <div class="backgroundOptionsHelper.colorType.gradient space-between-container" style="visibility: hidden; height: 0">
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="backgroundOptionsHelper.gradient.linear" id="form-background-gradient-type-linear" type="radio" name="background-gradient-type" checked/>
                                                <label for="form-background-gradient-type-linear">Linear</label>
                                            </div>
                                            <div style="flex-grow: 1">
                                                <input node-data-field="checked" node="backgroundOptionsHelper.gradient.radial" id="form-background-gradient-type-radial" type="radio" name="background-gradient-type"/>
                                                <label for="form-background-gradient-type-radial">Radial</label>
                                            </div>
                                        </div>
                                        <label class="backgroundOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">Background Gradient</label>
                                        <div class="backgroundOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">
                                            <input node="backgroundOptionsHelper.gradient.color1" type="color" value="#ffffff"/>
                                            <input node="backgroundOptionsHelper.gradient.color2" type="color" value="#ffffff"/>
                                        </div>
                                        <label class="backgroundOptionsHelper.colorType.gradient" for="form-background-gradient-rotation" style="visibility: hidden; height: 0">Rotation</label>
                                        <div class="backgroundOptionsHelper.colorType.gradient" style="visibility: hidden; height: 0">
                                            <input node="backgroundOptionsHelper.gradient.rotation" id="form-background-gradient-rotation" type="number" min="0" max="360" value="0"/>
                                        </div>
                                    </div>
                                    <button type="button" class="accordion">Image Options</button>
                                    <div class="panel">
                                        <label for="form-hide-background-dots">Hide Background Dots</label>
                                        <div>
                                            <input node="imageOptions.hideBackgroundDots" node-data-field="checked" id="form-hide-background-dots" type="checkbox" checked/>
                                        </div>
                                        <label for="form-image-size">Image Size</label>
                                        <div>
                                            <input node="imageOptions.imageSize" id="form-image-size" type="number" min="0" max="1" step="0.1" value="0.4"/>
                                        </div>
                                        <label for="form-image-margin">Margin</label>
                                        <div>
                                            <input node="imageOptions.margin" id="form-image-margin" type="number" min="0" max="10000" value="0"/>
                                        </div>
                                    </div>
                                <div class="col qr-code-container text-center">
                                    <div class="qr-code" id="qr-code-generated"></div>
                                    <div class="qr-download-group">
                                        <button type="button" id="qr-download">Download</button>
                                        <label class="hide" for="qr-extension">Extension</label>
                                        <select id="qr-extension">
                                            <option value="png" selected>PNG</option>
                                            <option value="jpeg">JPEG</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </main>
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

    <script src="{{asset('/assets/dashboard/js/main_qr_ad.js')}}"></script>
    @push('cropper')
    @endpush
    