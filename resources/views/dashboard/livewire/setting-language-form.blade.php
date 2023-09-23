@push('language_css')
    
<style>
    /* (A) LIST STYLES */
    .slist {
        list-style: none;
        padding: 0;
        margin: 0;
        color: #fff;
       
    }
    .slist li {
        margin: 10px;
        padding: 15px;
        border: 1px solid #3f3f3f;
        background: #5a5c69;
        border-radius: 10px;
    }

    /* (B) DRAG-AND-DROP HINT */
    .slist li.hint {
        border: 1px solid #3f3f3f;
        background: #525255;
    }
    .slist li.active {
        border: 1px solid #3f3f3f;
        background: #858796;
    }
</style>
@endpush

<div>
    <div class="container mt-4">
        <h5 class="text-white text-center">{{__('Enable the language by checking the checkbox and then arrange the sorting as needed.')}}</h5>
        <hr class="bg-white">
    </div>
        <div class="row mt-5 text-center justify-content-center">
        <div class="col-12 col-md-6">
            <form wire:submit.prevent="saveLanguages">
                <ul id="sortlist" wire:ignore>
                    @foreach ($allLanguages as $language)
                    <li>
                        <input type="checkbox" value="{{ $language }}"
                            {{ in_array($language, $filteredLocales) ? 'checked' : '' }}
                            onchange="checkboxChanged(this)">
                        {{ strtoupper($language) }}
                    </li>
                    @endforeach
                </ul>
                <button type="submit" class="btn btn-primary my-3">Update Language</button>
            </form>

        </div>
    </div>
</div>




@push('drag')
<script>


function checkboxChanged(checkbox) {
        if (checkbox.checked) {
            Livewire.emit('updateSort', Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
                .map(item => item.value));
        }
    }


    document.addEventListener('livewire:load', function () {
        // Initial load of the script
        slist(document.getElementById("sortlist"));
    });

    function slist(target) {
    // (A) SET CSS + GET ALL LIST ITEMS
    target.classList.add("slist");
    let items = target.getElementsByTagName("li"), current = null;

    // (B) MAKE ITEMS DRAGGABLE + SORTABLE
    for (let i of items) {
        // (B1) ATTACH DRAGGABLE
        i.draggable = true;

        // (B2) DRAG START - YELLOW HIGHLIGHT DROPZONES
        i.ondragstart = e => {
            current = i;
            for (let it of items) {
                if (it != current) {
                    it.classList.add("hint");
                }
            }
        };
            // (B3) DRAG ENTER - RED HIGHLIGHT DROPZONE
            i.ondragenter = e => {
                if (i != current) {
                    i.classList.add("active");
                }
            };

            // (B4) DRAG LEAVE - REMOVE RED HIGHLIGHT
            i.ondragleave = () => i.classList.remove("active");

            // (B5) DRAG END - REMOVE ALL HIGHLIGHTS
            i.ondragend = () => {
                for (let it of items) {
                    it.classList.remove("hint");
                    it.classList.remove("active");
                }
            };

            // (B6) DRAG OVER - PREVENT THE DEFAULT "DROP", SO WE CAN DO OUR OWN
            i.ondragover = e => e.preventDefault();

// (B7) ON DROP - DO SOMETHING
i.ondrop = e => {
    e.preventDefault();
    if (i != current) {
        let currentpos = 0, droppedpos = 0;
        for (let it = 0; it < items.length; it++) {
            if (current == items[it]) { currentpos = it; }
            if (i == items[it]) { droppedpos = it; }
        }
        if (currentpos < droppedpos) {
            i.parentNode.insertBefore(current, i.nextSibling);
        } else {
            i.parentNode.insertBefore(current, i);
        }
        // Emit an event to update the sort order on the Livewire component
        // if (i.querySelector('input[type="checkbox"]').checked) {
        Livewire.emit('updateSort', Array.from(items)
            .filter(item => item.querySelector('input[type="checkbox"]').checked)
            .map(item => item.querySelector('input[type="checkbox"]').value));










        // i.querySelector('input[type="checkbox"]').addEventListener('change', () => {
        //     Livewire.emit('updateSort', Array.from(items)
        //         .filter(item => item.querySelector('input[type="checkbox"]').checked)
        //         .map(item => item.querySelector('input[type="checkbox"]').value));

        // });
                    // }
    }
};
        }
    }
</script>
@endpush
