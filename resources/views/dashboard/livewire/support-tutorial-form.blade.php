<div class="my-4">
    <style>
        /* Media query for medium-sized screens */
        @media (max-width: 768px) {
            .fancy-font {
                font-size: 36px;
            }
        }

        /* Media query for smaller screens */
        @media (max-width: 576px) {
            .fancy-font {
                font-size: 24px;
            }
        }
    </style>

    <div class="container p-0 mt-5">
        <h1 id="point" class="PT text-white text-center mb-3 fancy-font">
            MineMenu <span style="color: red;">Tutorial</span>
        </h1>
        <div>
            <select name="playlist" id="playlist" class="form-control mb-3" wire:model="selectedPlaylist" wire:change="updatePlaylist($event.target.value)">
                <option disabled selected>Choose</option>
                @foreach ($playlistsData as $playlistId => $playlistInfo)
                <option value="{{ $playlistInfo[0] }}">{{ $playlistId }}</option>
                @endforeach
            </select>
        </div>
              
        <div class="row m-0">
            <div class="col-sm-12">
                <div class="embed-responsive embed-responsive-16by9 iframeVideo">
                    <section id="video"></section>
                </div>
            </div>
            <div class="adding col-sm-12 col-md-6 col-lg-6"></div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <hr class="hr">
                <h5 class="text-right text-white arabd b1">أحدث الحلقات</h5>
                <div class="list-inner row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-5 arabd arabd">
                </div>
            </div>
        </div>

        <hr class="hr">
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script>
        document.addEventListener('livewire:load', function () {
            var key = "AIzaSyBnqxxNiohS1kTM5TVYem1USaLZtQB3WAs";
            var URL = "https://www.googleapis.com/youtube/v3/playlistItems";
    
            // Function to load videos and descriptions
            function loadVids(playlistId) {
                var options = {
                    part: "snippet",
                    key: key,
                    maxResults: 50,
                    playlistId: playlistId
                };
    
                $.getJSON(URL, options, function (data) {
                    var id = data.items[0].snippet.resourceId.videoId;
                    mainVid(id);
                    resultsLoop(data);
                });
            }
    
            // Function to load video descriptions
            function loaddesc(playlistId) {
                var options = {
                    part: "snippet",
                    key: key,
                    maxResults: 50,
                    playlistId: playlistId
                };
    
                $.getJSON(URL, options, function (data) {
                    var orginal_desc = data.items[0].snippet.description;
                    idescription = orginal_desc.split("\n").join("<br>");
                    maindesc(idescription);
                });
            }
    
            // Function to update the video content
            function mainVid(id) {
                $("#video").html(`
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/${id}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                `);
            }
    
            // Function to update video descriptions
            function maindesc(idescription) {
                $("#desc").html(`
                    <p class="title text-white">${idescription}</p>
                `);
            }
    
            // Function to loop through video results
            function resultsLoop(data) {
                $.each(data.items, function (i, item) {
                    var thumb = item.snippet.thumbnails.high ? item.snippet.thumbnails.high.url : null;
                    var title = item.snippet.title;
                    var desc = item.snippet.description;
                    var vid = item.snippet.resourceId.videoId;
    
                    $('.list-inner').append(`
                        <article class="col-6 col-sm-4 col-md-3 col-lg-3 mb-4" data-key="${vid}" dd="${desc}">
                            <img src="${thumb}" class="card-img-top">
                            <div class="details">
                                <div class="title text-dark text-right">${title}</div>
                            </div>
                        </article>`);
                });
            }
    
            $('.list-inner').on('click', 'article', function () {
                var id = $(this).attr('data-key');
                mainVid(id);
                $('html, body').animate({ scrollTop: $('#point').offset().top }, 'slow');
            });

            $('.list-inner').on('click', 'article', function () {
                var orginal_desc = $(this).attr('dd');
                idescription = orginal_desc.split("\n").join("<br>");
                maindesc(idescription);
                
            });

            // Load the initial playlist on page load
            loadVids("{{ $loadFirst }}");
            loaddesc("{{ $loadFirst }}");
    
            // Listen for the 'reloadVid' event and reload the video content when triggered
            window.addEventListener('reloadVid', function (playlistsSelected) {
                const playlistVid = playlistsSelected.detail;
                loadVids(playlistVid);
                loaddesc(playlistVid);
            });
        });
    </script>
    

</div>