<div>

<!-- Image Crop -->
{{-- @push('cropper_links') --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

{{-- @endpush --}}
{{-- inline style for modal --}}
{{-- @push('style_tag') --}}
<style>
    .image_area { position: relative; }
    img { display: block; max-width: 100%; }
    .preview { overflow: hidden; width: 160px;  height: 160px; margin: 10px; border: 1px solid red;}
    .modal-lg{max-width: 1000px !important;}
    .overlay { position: absolute; bottom: 10px; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5); overflow: hidden; height: 0; transition: .5s ease; width: 100%;}
    .image_area:hover .overlay { height: 50%; cursor: pointer; }
    .text { color: #333; font-size: 20px; position: absolute; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%); text-align: center;}
</style>    
{{-- @endpush --}}


    <div class="my-4">
        <form wire:submit.prevent="saveSettings">
        <h3 class="text-white">{{__('Menu Setting')}}</h3>
        <hr class="bg-white">
        <div class="row">
            <div class="col-12">
            <form wire:submit.prevent="saveStatus">
                <div class="mb-3">
                    <label>{{__('Status')}}</label>
                    <select wire:model="status" name="status" class="form-control">
                        <option value="">Choose Start up</option>
                            <option value="0">{{__('none')}}</option>
                            <option value="1">{{__('Photo')}}</option>
                            <option value="2">{{__('Video')}}</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div> 
                <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

        <div class="col-12 col-sm-6">
            <form wire:submit.prevent="saveImage">
                <label for="img">Upload Image</label>
                <input type="file" name="startupImg" id="startupImg" class="form-control" style="height: auto">
                @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                <input type="file" name="croppedStartupImg" id="croppedStartupImg" style="display: none;">
            <hr>
                <div class="mb-3 d-flex justify-content-center mt-1">

                    <img id="showStartupImg" class="img-thumbnail rounded" src="{{$imgFlag ? $tempImg : app('fixedimage_640x360')}}" width="300">
                </div>
            </form>
        </div>
        {{-- <div class="col-12 col-sm-6">
                <form wire:submit.prevent="saveVideo">
                <label for="video">Video</label>
                <input type="file" accept=".mp4" class="form-control" wire:model="fileVideo" wire:change="uploadVideo" style="height: auto" >
                <button type="submit" class="upload-video">Upload</button>
                @error('objectVideoName') <span class="text-danger">{{ $message }}</span> @enderror
                <hr>
                <progress role="progressbar" value="{{ $uploadProgress }}" aria-valuenow="{{ $uploadProgress }}" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-striped progress-bar-animated"></progress>
                <div class="mb-3 d-flex justify-content-center mt-1">
                    <video controls class="img-thumbnail rounded" style="width: 300px; border-radius: 5px;">
                        <source id="showStartupVideo"  type="video/mp4"  src="{{$videoFlag ? $fileVideo : app('fixedvideo_1080x1920')}}">
                    </source>
                </div>
            </form>
        </div> --}}
        <div class="col-12 col-sm-6">
            <label for="video">Video</label>
            <input type="file" accept=".mp4" class="form-control" id="fileVideoInput" style="height: auto">
            <hr>
            <progress value="0" max="100" class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="uploadProgressBar"></progress>
            <div class="mb-3 d-flex justify-content-center mt-1">
                <video controls class="img-thumbnail rounded" style="width: 300px; border-radius: 5px;">
                    {{-- <source id="showStartupVideo" type="video/mp4" src="{{$videoFlag ? $fileVideo : app('fixedvideo_1080x1920')}}"> --}}
                </source>
            </div>
        </div>
        </div>

    </form>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('fileVideoInput');
        const progressBar = document.getElementById('uploadProgressBar');

        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0];
            if (file) {
                uploadFile(file);
            }
        });

        function uploadFile(file) {
            const formData = new FormData();
            formData.append('video', file);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
                },
                onUploadProgress: function (progressEvent) {
                    const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    progressBar.value = percentCompleted;
                },
            };

            axios.post('/rest/setting/startup/', formData, config)
                .then(response => {
                    console.log('Upload successful:', response.data);
                })
                .catch(error => {
                    console.error('Upload error:', error);
                });
        }
    });
</script>


<script>
    document.addEventListener('livewire:load', function () {
        var modal = new bootstrap.Modal(document.getElementById('modal'));
        var cropper;
        
        $('#startupImg').change(function (event) {
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
                    aspectRatio: 540 / 960,
                    viewMode: 1,
                    preview: '.preview'
                });
            });
    
            $('.crop-btn').off('click').on('click', function () {
                var canvas = cropper.getCroppedCanvas({
                    width: 540,
                    height: 960
                });
    
                canvas.toBlob(function (blob) {
                    var url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modal.hide();
                        Livewire.emit('updateCroppedStartupImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('startupImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('croppedStartupImg');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
    
                    modal.hide();
                }, 'image/jpeg');
            });
        }
    });
</script>
@endpush
{{-- 
@php
dd($imgFlag)   ;
@endphp --}}