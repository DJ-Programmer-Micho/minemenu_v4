<div>
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
</style>    



    <div class="my-4">
        <h3 class="text-white">{{__('Start Up Menu Setting')}}</h3>
        <p class="text-warning">{{__('Each Field Works Seperatly')}}</p>
        <hr class="bg-white">
        <div class="row">
            <div class="col-12 mb-3">
            <form wire:submit.prevent="saveStatus">
                <div class="mb-3">
                    <label class="text-white">{{__('Status')}}</label>
                    <select wire:model="status" name="status" class="form-control">
                        <option value="">{{__('Choose Start up')}}</option>
                            <option value="null">{{__('none')}}</option>
                            <option value="1">{{__('Photo')}}</option>
                            <option value="2">{{__('Video')}}</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div> 
                <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
            </form>
        </div>

        <div class="col-12 col-sm-6">
                <label class="text-white" for="img">{{__('Upload Image')}}</label>
                <input type="file" name="startupImg" id="startupImg" class="form-control" style="height: auto">
                <small class="bg-info text-white px-2 rounded"><b>{{__('(Auto Upload)')}}</b></small>
                @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                <input type="file" name="croppedStartupImg" id="croppedStartupImg" style="display: none;">
                <div class="mb-3 d-flex justify-content-center mt-1">

                    <img id="showStartupImg" class="img-thumbnail rounded" src="{{$imgReader ? app('cloudfront').$imgReader : app('fixedimage_640x360')}}" width="300">
                </div>
        </div>
        <div class="col-12 col-sm-6">
            <form wire:submit.prevent="uploadVideo">
                <label class="text-white" for="video">{{__('Video (3MB MAX)')}}</label>
                <input type="file" accept=".mp4" class="form-control" wire:model="fileVideo" style="height: auto">
                <div class="progress my-1">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <button type="submit" class="upload-video btn btn-primary">{{__('Upload')}}</button>
                @error('fileVideo') <span class="text-danger">{{ $message }}</span> @enderror
                <div class="my-3 d-flex justify-content-center mt-1">
                    <video controls class="img-thumbnail rounded" style="width: 300px; border-radius: 5px;">
                        <source id="showStartupVideo" type="video/mp4" src="{{ $objectVideoName ? app('cloudfront').$objectVideoName : app('fixedvideo_1080x1920') }}">
                    </video>
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
                <h5 class="modal-title">{{__('Crop Image Before Upload')}}</h5>
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
                <button type="button" class="btn btn-primary crop-btn" data-index="">{{__('Crop')}}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
            </div>
        </div>
    </div>
</div> 
</div>



@push('cropper')
<script>
window.addEventListener('fakeProgressBar', (e) => {
    let currentProgress = 0;
            const progressBar = document.querySelector('.progress-bar');
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
                        Livewire.emit('simulationComplete');
                        currentProgress = 0;
                        location.reload()
                    }
                    progressBar.setAttribute('aria-valuenow', '0');
                }
            }, 1000); // Adjust the interval timing as needed
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