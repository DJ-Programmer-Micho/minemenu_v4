<!-- Image Crop -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.js"></script>
{{-- inline style for modal --}}
<style>
    .image_area { position: relative; }
    img { display: block; max-width: 100%; }
    .preview { overflow: hidden; width: 160px;  height: 160px; margin: 10px; border: 1px solid red;}
    .preview-cover { overflow: hidden; width: 160px;  height: 160px; margin: 10px; border: 1px solid red;}
    .modal-lg{max-width: 1000px !important;}
    .overlay { position: absolute; bottom: 10px; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5); overflow: hidden; height: 0; transition: .5s ease; width: 100%;}
    .image_area:hover .overlay { height: 50%; cursor: pointer; }
    .text { color: #333; font-size: 20px; position: absolute; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%); text-align: center;}
</style>


<div>

<!-- Insert Modal -->
<div wire:ignore.self class="modal fade" style=" overflow: auto;" id="createCategory" tabindex="-1" aria-labelledby="createCategoryLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="saveCategory">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCategoryLabel">{{__('Add Category')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label>{{ __('Select Menu') }}</label>
                                <select wire:model="menu_id" name="menu_id" id="" class="form-control">
                                    <option value="">Select Menu</option>
                                    @foreach ($menu_select as $menu)
                                        <option value="{{$menu->translation->menu_id}}">{{$menu->translation->name}}</option>
                                    @endforeach
                                </select>
                                @error('menu_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @foreach ($filteredLocales as $locale)
                            <div class="mb-3">
                                <label>{{ strtoupper($locale) }}</label>
                                <input type="text" wire:model="names.{{$locale}}" class="form-control" style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                                @error('names.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endforeach
                            <div class="mb-3">
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="" class="form-control">
                                    <option value="">Choose Status</option>
                                        <option value="1">{{__('Active')}}</option>
                                        <option value="0">{{__('Non Active')}}</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>           
                            <div class="mb-3">
                                <label>{{__('Priority')}}</label>
                                <input type="number" wire:model="priority" class="form-control">
                                @error('Priority') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-5">
                            <label for="img">{{__('Upload Image')}}</label>
                            <input type="file" name="categoryImg" id="categoryImg" class="form-control" style="height: auto">
                            @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                            <input type="file" name="croppedCategoryImg" id="croppedCategoryImg" style="display: none;">
                            <div class="progress my-1">
                                <div class="progress-bar progress-bar-striped progress-bar-animated pImg" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        <hr>
                            <div class="mb-3 d-flex justify-content-center mt-1">
                                <img id="showCategoryImg" class="img-thumbnail rounded" src="{{$tempImg ?? $emptyImg}}">
                            </div>

                            <label for="img">{{__('Upload Cover')}} <small class="text-info">{{__('(OPTIONAL)')}}</small></label>
                            <input type="file" name="categoryImgCover" id="categoryImgCover" class="form-control" style="height: auto">
                            @error('objectNameCover') <span class="text-danger">{{ $message }}</span> @enderror
                            <input type="file" name="croppedCategoryImgCover" id="croppedCategoryImgCover" style="display: none;">
                            <div class="progress my-1">
                                <div class="progress-bar progress-bar-striped progress-bar-animated pCvr" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <hr>
                            <div class="mb-3 d-flex justify-content-center mt-1">
                                <img id="showCategoryImgCover" class="img-thumbnail rounded" src="{{$tempImgCover ?? $emptyImg}}">
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

<div wire:ignore.self class="modal fade" style=" overflow: auto;" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="updateCategory">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateCategoryModalLabel">{{__('Edit Menu')}}</h5>
                        <button type="button" class="brn btn-danger" data-dismiss="modal" wire:click="closeModal"
                            aria-label="Close"><i class="fas fa-times"></i></button>
                    </div>
                    <h3>{{__('Category')}}</h3>
                    <hr class="bg-white">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label>{{ __('Select Menu') }}</label>
                                <select wire:model="menu_id" name="menu_id" id="" class="form-control">
                                    <option value="">Select Menu</option>
                                    @foreach ($menu_select as $menu)
                                        <option value="{{$menu->translation->menu_id}}">{{$menu->translation->name}}</option>
                                    @endforeach
                                </select>
                                @error('menu_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @foreach ($filteredLocales as $locale)
                            <div class="mb-3">
                                <label>{{ strtoupper($locale) }}</label>
                                <input type="text" wire:model="names.{{$locale}}" class="form-control" style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                                @error('names.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endforeach
                            <div class="mb-3">
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="" class="form-control">
                                    <option value="">Choose Status</option>
                                        <option value="1">{{__('Active')}}</option>
                                        <option value="0">{{__('Non Active')}}</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>           
                            <div class="mb-3">
                                <label>{{__('Priority')}}</label>
                                <input type="number" wire:model="priority" class="form-control">
                                @error('Priority') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="img">{{__('Upload Image')}}</label>
                            <input type="file" name="editCategoryImg" id="editCategoryImg" class="form-control" style="height: auto">
                            @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                            <input type="file" name="editCroppedCategoryImg" id="editCroppedCategoryImg" style="display: none;">
                            <div class="progress my-1">
                                <div class="progress-bar progress-bar-striped progress-bar-animated pImgEdit" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        <hr>
                            <div class="mb-3 mt-1">
                                <img id="showEditCategoryImg" class="img-thumbnail rounded" src="{{ $tempImg ? $tempImg : app('cloudfront').$imgReader}}">
                            </div>

                            <label for="img">{{__('Upload Cover')}} <small class="text-info">{{__('(OPTIONAL)')}}</small></label>
                            <input type="file" name="editCategoryImgCover" id="editCategoryImgCover" class="form-control" style="height: auto">
                            @error('objectNameCover') <span class="text-danger">{{ $message }}</span> @enderror
                            <input type="file" name="editCroppedCategoryImgCover" id="editCroppedCategoryImgCover" style="display: none;">
                                                       <div class="progress my-1">
                                <div class="progress-bar progress-bar-striped progress-bar-animated pCvrEdit" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <hr>
                            <div class="mb-3 justify-content-center mt-1">
                                @if ($tempImgCover)
                                <img id="showEditCategoryImgCover" class="img-thumbnail rounded" src="{{$tempImgCover}}">
                                <div class="mt-3"> 
                                    <button class="btn btn-danger" wire:click="deleteCoverCategory">{{__('Delete Cover')}}</button>
                                </div>                                
                                @elseif ($imgReaderCover)
                                <img id="showEditCategoryImgCover" class="img-thumbnail rounded" src="{{ app('cloudfront').$imgReaderCover }}">
                                <div class="mt-3"> 
                                    <button class="btn btn-danger" wire:click="deleteCoverCategory">{{__('Delete Cover')}}</button>
                                </div>
                                @else
                                <img id="showEditCategoryImgCover" class="img-thumbnail rounded" src="{{ $emptyImg }}">
                                @endif                            </div>
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
 
 
<div wire:ignore.self class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Delete Category</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroycategory">
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this category?') }}</p>
                    <p>{{ __('Please enter the')}}<strong> "{{$showTextTemp}}" </strong>{{__('to confirm:') }}</p>
                    <input type="text" wire:model="categoryNameToDelete" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" wire:disabled="!confirmDelete || $categoryNameToDelete !== $showTextTemp">
                            {{ __('Yes! Delete') }}
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- IMAGE CROP MODAL --}}
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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


{{-- IMAGE COVER CROP MODAL --}}
<div class="modal fade" id="modalCover" tabindex="-1" role="dialog" aria-labelledby="modalLabelCover" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg text-white" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Crop Cover Image Before Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="" id="sample_image_cover" />
                        </div>
                        <div class="col-md-4">
                            <div class="preview-cover"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary crop-btn-cover" data-index="">Crop</button>
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
    
        $('#categoryImg').change(function (event) {
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
    

                    // Livewire.emit('updateCroppedCategoryImg', data);
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modal.hide();
                        // $('#showCategoryImg').attr('src', base64data);
                        Livewire.emit('updateCroppedCategoryImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('categoryImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met_about.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('croppedCategoryImg');
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
    
        $('#editCategoryImg').change(function (event) {
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
    

                    // Livewire.emit('updateCroppedCategoryImg', data);
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modal.hide();
                        // $('#showEditCategoryImg').attr('src', base64data);
                        Livewire.emit('updateCroppedCategoryImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('editCategoryImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('editCroppedCategoryImg');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
    
                    modal.hide();
                }, 'image/jpeg');
            });
        }
    });
</script>
{{-- ADD COVER IMG --}}
<script>
    document.addEventListener('livewire:load', function () {
    var modalCover = new bootstrap.Modal(document.getElementById('modalCover'));
    var cropperCover;

    $('#categoryImgCover').change(function (event) {
        var image = document.getElementById('sample_image_cover');
        var files = event.target.files;

        function done(url) {
            image.src = url;
            modalCover.show();
            handleCropButtonClick(image);
        }

        if (files && files.length > 0) {
            var reader = new FileReader();
            reader.onload = function (event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    function handleCropButtonClick(image) {
        $('#modalCover').on('shown.bs.modal', function () {
            if (cropperCover) {
                cropperCover.destroy();
            }
            cropperCover = new Cropper(image, {
                aspectRatio: 640 / 360,
                viewMode: 1,
                preview: '.preview-cover'
            });

            $('.crop-btn-cover').off('click').on('click', function () {
                var canvas = cropperCover.getCroppedCanvas({
                    width: 640,
                    height: 360
                });

                if (canvas) {
                    canvas.toBlob(function (blob) {
                        var reader = new FileReader();
                        reader.onloadend = function () {
                            var base64dataCover = reader.result;
                            modalCover.hide();
                            Livewire.emit('updateCroppedCategoryImgCover', base64dataCover);

                            if (cropperCover) {
                                cropperCover.destroy();
                                document.getElementById('categoryImgCover').value = null;
                            }
                        };
                        reader.readAsDataURL(blob);

                        var file = new File([blob], 'category_cover.jpg', { type: 'image/jpeg' });
                        var fileInput = document.getElementById('croppedCategoryImgCover');
                        var dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        fileInput.files = dataTransfer.files;

                        modalCover.hide();
                    }, 'image/jpeg');
                } else {
                    console.error('Canvas is null. Check your Cropper.js configuration or image source.');
                    modalCover.hide();
                }
            });
        });
    }
});
</script>
{{-- EDIT COVER IMG --}}
<script>
    document.addEventListener('livewire:load', function () {
        var modalCover = new bootstrap.Modal(document.getElementById('modalCover'));
        var cropperCover;
    
        $('#editCategoryImgCover').change(function (event) {
            var image = document.getElementById('sample_image_cover');
            var files = event.target.files;
            var done = function (url) {
                image.src = url;
                modalCover.show();
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
            $('#modalCover').on('shown.bs.modal', function () {
                if (cropperCover) {
                    cropperCover.destroy();
                }
                cropperCover = new Cropper(image, {
                    aspectRatio: 800 / 240,
                    viewMode: 1,
                    preview: '.preview-cover'
                });
            });
    
            $('.crop-btn-cover').off('click').on('click', function () {
                var canvas = cropperCover.getCroppedCanvas({
                    width: 800,
                    height: 240
                });
    
                canvas.toBlob(function (blob) {
                    var url = URL.createObjectURL(blob);
    

                    // Livewire.emit('updateCroppedCategoryImg', data);
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modalCover.hide();
                        // $('#showEditCategoryImg').attr('src', base64data);
                        Livewire.emit('updateCroppedCategoryImgCover', base64data); // Emit Livewire event

                        if (cropperCover) {
                            cropperCover.destroy();
                            document.getElementById('editCategoryImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('editCroppedCategoryImg');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
    
                    modalCover.hide();
                }, 'image/jpeg');
            });
        }
    });
</script>
<script>
    window.addEventListener('fakeProgressBarImg', (e) => {
        document.querySelector('#categoryImgCover').disabled = true;
        document.querySelector('.submitJs').disabled = true;
        let currentProgress = 0;
                const progressBar = document.querySelector('.pImg');
                // const increment = 50; // Increase this value to control the simulation speed
                var randomIncrement = 0;
                const interval = setInterval(function () {
                    randomIncrement = Math.floor(Math.random() * (50 - 10 + 1)) + 10;
                    currentProgress += randomIncrement;
                    if (currentProgress <= 100) {
                        progressBar.style.width = currentProgress + '%';
                        progressBar.setAttribute('aria-valuenow', currentProgress);
                    } else {
                         // Notify Livewire when the simulation is complete
                        clearInterval(interval);
                        progressBar.style.width = '100%';
                        if(currentProgress >= 100){
                            Livewire.emit('simulationCompleteImg');
                            currentProgress = 0;
                            document.querySelector('#categoryImgCover').disabled = false;
                            document.querySelector('.submitJs').disabled = false;
                        }
                        progressBar.setAttribute('aria-valuenow', '0');

                    }
                }, 1000); // Adjust the interval timing as needed
    });
    window.addEventListener('fakeProgressBarCover', (e) => {
        document.querySelector('#categoryImg').disabled = true;
        document.querySelector('.submitJs').disabled = true;
        let currentProgress = 0;
                const progressBar = document.querySelector('.pCvr');
                // const increment = 50; // Increase this value to control the simulation speed
                var randomIncrement = 0;
                const interval = setInterval(function () {
                    randomIncrement = Math.floor(Math.random() * (50 - 10 + 1)) + 10;
                    currentProgress += randomIncrement;
                    if (currentProgress <= 100) {
                        progressBar.style.width = currentProgress + '%';
                        progressBar.setAttribute('aria-valuenow', currentProgress);
                    } else {
                         // Notify Livewire when the simulation is complete
                        clearInterval(interval);
                        progressBar.style.width = '100%';
                        if(currentProgress >= 100){
                            Livewire.emit('simulationCompleteCover');
                            currentProgress = 0;
                            document.querySelector('#categoryImg').disabled = false;
                            document.querySelector('.submitJs').disabled = false;
                        }
                        progressBar.setAttribute('aria-valuenow', '0');
                    }
                }, 1000); // Adjust the interval timing as needed
    });
    </script>
<script>
    window.addEventListener('fakeProgressBarImg', (e) => {
        document.querySelector('#editCategoryImgCover').disabled = true;
        document.querySelector('.submitJs').disabled = true;
        let currentProgress = 0;
                const progressBar = document.querySelector('.pImgEdit');
                // const increment = 50; // Increase this value to control the simulation speed
                var randomIncrement = 0;
                const interval = setInterval(function () {
                    randomIncrement = Math.floor(Math.random() * (50 - 10 + 1)) + 10;
                    currentProgress += randomIncrement;
                    if (currentProgress <= 100) {
                        progressBar.style.width = currentProgress + '%';
                        progressBar.setAttribute('aria-valuenow', currentProgress);
                    } else {
                         // Notify Livewire when the simulation is complete
                        clearInterval(interval);
                        progressBar.style.width = '100%';
                        if(currentProgress >= 100){
                            Livewire.emit('simulationCompleteImg');
                            currentProgress = 0;
                            document.querySelector('#editCategoryImgCover').disabled = false;
                            document.querySelector('.submitJs').disabled = false;
                        }
                        progressBar.setAttribute('aria-valuenow', '0');

                    }
                }, 1000); // Adjust the interval timing as needed
    });
    window.addEventListener('fakeProgressBarCover', (e) => {
        document.querySelector('#editCategoryImg').disabled = true;
        document.querySelector('.submitJs').disabled = true;
        let currentProgress = 0;
                const progressBar = document.querySelector('.pCvrEdit');
                // const increment = 50; // Increase this value to control the simulation speed
                var randomIncrement = 0;
                const interval = setInterval(function () {
                    randomIncrement = Math.floor(Math.random() * (50 - 10 + 1)) + 10;
                    currentProgress += randomIncrement;
                    if (currentProgress <= 100) {
                        progressBar.style.width = currentProgress + '%';
                        progressBar.setAttribute('aria-valuenow', currentProgress);
                    } else {
                         // Notify Livewire when the simulation is complete
                        clearInterval(interval);
                        progressBar.style.width = '100%';
                        if(currentProgress >= 100){
                            Livewire.emit('simulationCompleteCover');
                            currentProgress = 0;
                            document.querySelector('#editCategoryImg').disabled = false;
                            document.querySelector('.submitJs').disabled = false;
                        }
                        progressBar.setAttribute('aria-valuenow', '0');
                    }
                }, 1000); // Adjust the interval timing as needed
    });
    </script>
@endpush


