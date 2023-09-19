<div>
    <style>
        .master-container {
            max-width: 800px;
        }
        .place-body {
            height: 100vh;
            background-color: var(--main-background-color);
            border-radius: 0px;
            margin-bottom: 0;
        }
        .bodyHome_content {
            background-color: var(--main-background-color);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            z-index: 2;
        }
            
        #bg-video {
                min-width: 100%;
                min-height: 100vh;
                max-width: 100%;
                max-height: 100vh;
                object-fit: cover;
            }
            .effect {
                position: absolute;
                background-color: rgba(0,0,0,0.3);
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 3;
            }
            .selectB {
                text-align: center;
                position: absolute;
                width: 80%;
                left: 50%;
                top: 50%;
                transform: translate(-50%, 200%);
                -webkit-transform: translate(-50%, 200%);
            }
    </style>
    @if ($setting->intro_page == 1)
    <div class="place-body mt-0 p-0 bodyHome_content"
        style="background-image: url('{{app('cloudfront').$setting->background_img}}')">
        @else
        <div class="place-body mt-0 p-0 bodyHome_content">
            <video autoplay preload="auto" muted playsinline loop id="bg-video">
                <source src="{{app('cloudfront').$setting->background_vid}}" type="video/mp4">
            </video>
            @endif
            <div class="effect">
                <div class="selectB row justify-content-center align-items-center m-auto">
                    @foreach ($filteredLocales as $locale)
                    <div class="col-4 col-md-3 mb-3">
                        <a href="#" onclick="changeLanguage('{{ $locale }}')">
                            <button class="btn btn-danger w-100">{{ __(strtoupper($locale)) }}</button>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
