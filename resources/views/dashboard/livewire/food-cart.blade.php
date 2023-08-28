{{-- <div wire:ignore.self class="modal fade overflow-auto" id="addCart" tabindex="-1" aria-labelledby="addCart:abel"
    aria-hidden="true">
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
                        {{$hi->translation->name}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> --}}
@php
$options = json_decode($foodAction->options, true); // Decode the JSON options for the current item
$currentOptions = $options[$glang] ?? []; // Get options for the current language or default to an empty array
@endphp
                @if ($foodAction->sorm == 0)
                    <div class="col-md-12 text-right">
                        <div class="row">
                            <div class="col-6 text-left">
                                <h6 class="price-detail-01">{{$foodAction->price . ' ' .  $settings->currency}}</h6>
                            </div>
                            <div class="col-6">
                                <section class="text-white">

                                    <div class="plus-minus">
                                      <i class="fas fa-plus"></i>
                                      <input type="number" value="1" min="1" max="10" />
                                      <i class="fas fa-minus"></i>
                                    </div>
                            </section>
                            </div>
                        </div>
                        
                    </div>
                </div>
                @else
            </div>
            <div class="color-section">
                <div class="left">
                    <h5 class="label">{{__('Choose Size')}}</h5>
                    <hr>
                    @foreach ($currentOptions as $option)
                    <div>
                        <div class="row">
                            <div class="col-6">
                                <h6><span class="font-weight-bold">{{$option['key']}}</span>:{{$option['value'] . ' ' . $settings->currency}}</h6>

                            </div>
                            <div class="col-6">
                                <section class="text-white text-right">

                                    <div class="plus-minus">
                                      <i class="fas fa-plus"></i>
                                      <input type="number" value="1" min="1" max="10" />
                                      <i class="fas fa-minus"></i>
                                    </div>
                            </section>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif



<style>


 .plus-minus {
  border-radius: 6px;
  border: 1px solid rgba(var(--theme-color), 1);
  padding: 6px 17px;
  display: -webkit-inline-box;
  display: -ms-inline-flexbox;
  display: inline-flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  background-color: rgba(var(--white), 1);
  text-align: center;
}
 .plus-minus input {
  background-color: rgba(var(--white), 1);
  color: rgba(var(--theme-color), 1);
  border: none;
  font-size: 14px;
  outline: none;
  width: 35px;
  text-align: center;
}
 .plus-minus i {
  color: rgba(var(--theme-color), 1);
}
</style>