<div>

    <div>
        <form wire:submit.prevent="saveColors">
            {{-- <h1 style="color: {{ $selectedHeaderColor }}; opacity: 0.20;">CUSTOMIZE COLOR</h1> --}}
            <div class="well">
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="selectedHeader">Header Color</label>
                            <br>
                            <input type="color" id="qwe" class="form-control asd" wire:model="selectedHeader">
                            <p style="color: {{$selectedHeader}};">{{$selectedHeader}}</p>
                            <input type="text" class="form-control" id="headerColor" value="{{$selectedHeader}}">

                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="selectedNavbar">Navbar Color</label>
                            <br>
                            <input type="color" class="form-control asd" wire:model="selectedNavbar">
                            <p style="color: {{$selectedNavbar}};">{{$selectedNavbar}}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="selectedMenu">Menu Color</label>
                            <br>
                            <input type="color"class="form-control asd" wire:model="selectedMenu">
                            <p style="color: {{$selectedMenu}};">{{$selectedMenu}}</p>
                        </div>
                    </div>
                </div>
                <button type="submit" wire:click="saveColors">Save Colors</button>
                <div class="row">
                    <div class="col-12 col-lg-6 embed-responsive embed-responsive-16by9 p-0 m-0" style="height:800px" >
                        <iframe id="myform" name="iframe1" class="embed-responsive-item" src="{{url('/'. auth()->user()->name)}}" style="border: 1" frameborder="1"></iframe>
                </div>
                </div>
            </div>
        </form>
    </div>
    
</div>

@push('color')
<script>
    $('.asd').on('input', function() {
            var bodyColor = document.getElementById("qwe").value;
            console.log(bodyColor);
            var myframe = document.querySelector("iframe").contentWindow.document;
            myframe.documentElement.style.setProperty('--body-color', bodyColor);
});
</script>
@endpush