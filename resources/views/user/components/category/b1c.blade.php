<div>
    <div class="d-flex justify-content-between title-lang">
        <h4 id="rest-title">{{$name}}</h4>
        <select name="my_select" class="mySelect" onchange="selectLang(this.value);" id="list" name="list">

            <option>{{__("Language")}}</option>
            <option value="kr">كوردى</option>
            <option value="ar">العربية</option>
            <option value="en">asd</option>
        </select>
        @foreach ($filteredLocales as $locale)
        <a class="dropdown-item" href="#" onclick="changeLanguage('{{ $locale }}')">
            <i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i>
            {{ strtoupper($locale) }}
        </a>
    @endforeach
    </div>
    <div class="facilities">
        <div>
            <span><i class="fa fa-location-dot"></i> {{$settings->address}}</span>
       </div>
       <div>
            <span ><i class="fa fa-wifi"></i> {{$settings->wifi}}</span>
       </div>
        <div>
            <span><i class="fa fa-phone"></i> {{$settings->phone}}</span>
        </div>
    </div>
    @livewire('user.components.menu'.$aaa.'-livewire', [
        'aaa' => $this->aaa,
        'user' => $user_id,
        'glang' => $glang 
        ])
</div>


@push('business_script')    
<script>
$(document).ready(function(){
    $('button[data-toggle="pill"]').on('show.bs.tab', function(e) {
        console.log('Tab clicked:', $(e.target).attr('id'));
        localStorage.setItem('activeTab', $(e.target).attr('id'));
    });
    var activeTab = localStorage.getItem('activeTab');
    console.log('Retrieved activeTab:', activeTab);
    if(activeTab){
        $('#pills-tab button[id="' + activeTab + '"]').tab('show');
    }
});

</script>
@endpush