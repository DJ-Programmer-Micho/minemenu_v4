<div>
    <x-business.Offer01Component :user="$user_id" :glang="$glang" :ui="$ui" />
    <x-business.Menu01Component :user="$user_id" :glang="$glang" :ui="$ui" :settings="$setting"/>
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