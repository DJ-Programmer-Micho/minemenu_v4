<!-- Insert Modal -->
<div wire:ignore.self class="modal fade overflow-auto" id="studentModal" tabindex="-1"
    aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">{{__('Add Menu')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="saveMenu">
                <div class="modal-body">
                    <h3>{{__('Menu Name')}}</h3>
                <div class="row">
                    <div class="col-12 col-md-6">
                            @foreach ($filteredLocales as $locale)
                            <div class="mb-3">
                                <label>{{ strtoupper($locale) }}</label>
                                <input type="text" wire:model="names.{{$locale}}" class="form-control"
                                    style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                                @error('names.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endforeach
                        </div>
                  
                    <div class="col-12 col-md-6">
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

                    <div class="mb-3">
                        <label>{{__('Priority')}}</label>
                        <input type="number" wire:model="priority" class="form-control">
                        <small class="text-info">{{__('The less The Higher Priority')}}</small>
                        @error('Priority') <span class="text-danger">{{ $message }}</span> @enderror
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
<!-- Update Student Modal -->
<div wire:ignore.self class="modal fade" id="updateStudentModal" tabindex="-1" aria-labelledby="updateStudentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStudentModalLabel">Edit Menu</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="updateStudent">
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
<div wire:ignore.self class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStudentModalLabel">Delete Student</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
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
