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
</style>


<div>

<!-- Insert Modal -->
<div wire:ignore.self class="modal fade" id="createCategory" tabindex="-1" aria-labelledby="createCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl  text-white">
        <div class="modal-content bg-dark">
            {{--  --}}
            <form wire:submit.prevent="saveCategory">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCategoryLabel">{{__('Add Menu')}}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                        <span aria-hidden="true">&times;</span></button>
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
                            <label for="img">Upload Image</label>
                            <input type="file" name="categoryImg" id="categoryImg" class="form-control" style="height: auto">
                            @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                            <input type="file" name="croppedCategoryImg" id="croppedCategoryImg" style="display: none;">
                           
                        <hr>
                            <div class="mb-3 d-flex justify-content-center mt-1" wire:ignore>
                                <img id="showCategoryImg" class="img-thumbnail rounded">
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

<div wire:ignore.self class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCategoryModalLabel">Edit Menu</h5>
                <button type="button" class="btn-close" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="updateCategory">
                <div class="modal-body">
                    <h3>{{__('Menu Name')}}</h3>
                    @foreach ($filteredLocales as $locale)
                    <div class="mb-3">
                        <label>{{ strtoupper($locale) }}</label>
                        <input type="text" wire:model="names.{{$locale}}" class="form-control" style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                        @error('names.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    @endforeach
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
 
 
<!-- Delete Student Modal -->
<div wire:ignore.self class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Delete Student</h5>
                <button type="button" class="btn-close" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="destroyStudent">
                <div class="modal-body">
                    <h4>Are you sure you want to delete this data ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Yes! Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- IMAGE CROP MODAL --}}
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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


