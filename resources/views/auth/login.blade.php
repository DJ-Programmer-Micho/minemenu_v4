<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | MINE MENU</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}"></script>
    <link href="{{asset('assets/general/css/toaster.css')}}" rel="stylesheet" type="text/css">

    <style>
        @import "https://fonts.googleapis.com/css?family=Quicksand";

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            background-color: #fafafa;
        }

        body {
            font-family: "Quicksand", sans-serif;
            font-weight: 500;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        h1 {
            font-weight: 700;
            color: #384047;
            text-align: center;
            line-height: 1.5em;
            margin-bottom: 1.2em;
            margin-top: 0.2em;
        }

        a {
            font-size: 0.98em;
            color: #8a97a0;
            text-decoration: none;
        }

        a:hover {
            color: rgb(233, 23, 41);
        }

        .container {
            display: flex;
            -webkit-display: box;
            -moz-display: box;
            -ms-display: flexbox;
            -webkit-display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-content: center;
            padding: 3%;
            margin: 0;
            margin-top: 30px
        }

        form {
            background-color: #FFF;
            padding: 2em;
            padding-bottom: 3em;
            border-radius: 8px;
            max-width: 400px;
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 10px 40px -14px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
        }

        form input {
            color: #384047;
            background-color: #e8eeef;
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03) inset;
            border: none;
            border-radius: 4px;
            padding: 1em;
            margin-bottom: 1.2em;
            width: 100%;
        }

        form input:focus {
            outline: none;
        }

        .button {
            font-weight: 600;
            text-align: center;
            font-size: 19px;
            color: #FFF;
            background-color: rgb(233, 23, 41);
            width: 100%;
            border: none;
            border-radius: 4px;
            padding: 0.8em;
            margin-top: 1.4em;
            margin-bottom: 1em;
            cursor: pointer;
            overflow: hidden;
            transition: all 200ms ease-in-out;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
        }

        .button:hover {
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.3);
            transform: translateY(-4px);
        }

        .button span {
            position: relative;
            z-index: 1;
        }

        .button .circle {
            position: absolute;
            z-index: 0;
            background-color: #35A556;
            border-radius: 50%;
            transform: scale(0);
            opacity: 5;
            height: 50px;
            width: 50px;
        }

        .button .circle.animate {
            animation: grow 0.5s linear;
        }

        @keyframes grow {
            to {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        .button .signup-message {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: space-between;
            color: red;
        }

        .danger {
            color: red;
        }

        .logo-div {

            width: 100px;
            margin: 0px auto;
            margin-top: 40px;
            font-weight: bold;
            text-align: center
        }
    </style>
</head>

<body>


    <div class="logo-div">
        <a class="" href="/" style="fill: red;width:100px">
            <svg class="logo1" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1266.33 1026.47">
                <path
                    d="M7.51,584.82Q8.27,575.91,9,567,27.56,351.42,188.68,207c75-67.1,162.93-109,261.4-128.87a535,535,0,0,1,147.06-9.22c151.68,11.6,279.56,72.45,381.44,186.14,32.7,36.48,58.9,77.42,80.63,121.26a16.23,16.23,0,0,1,.51,1.61L70.32,853.22c-.66-1-1.3-1.88-1.79-2.81-27.17-52-46.06-106.9-54.78-165-2.64-17.58-3.7-35.39-5.5-53.1-.19-1.9-.49-3.8-.74-5.7ZM84.6,810.73l930.8-447.14c-.68-1.36-1.08-2.23-1.55-3.06-18.45-32.57-40-63-65.38-90.48C856.75,170.61,743.05,115.32,608.72,102a506.06,506.06,0,0,0-147.54,6.71c-114.36,22.26-212.14,75-290.49,161.56C91.53,357.69,48.45,461,41.15,578.75A470.84,470.84,0,0,0,64.49,756.83C70.44,774.86,77.74,792.45,84.6,810.73Z"
                    transform="translate(-7.51 -11.03)" />
                <path
                    d="M340.81,11c3.62.85,7.29,1.52,10.84,2.6,13.19,4,23.14,11.58,26.29,25.75,2.05,9.19,0,17.95-4.23,26.22-6.9,13.42-17.28,23.85-29.15,32.78-26.25,19.74-55.41,32.79-88.24,36.67-11.95,1.41-23.89,1-35.33-3.59-18.61-7.44-26.75-24.86-20.15-43.78,5-14.4,14.88-25.39,26.37-34.83,27.23-22.37,58.13-36.67,93.31-41.16a9.21,9.21,0,0,0,1.91-.66Zm-96.33,92.79a113.5,113.5,0,0,0,37.29-7.51c19.48-7.2,37.52-16.88,52.33-31.7a71.6,71.6,0,0,0,10.07-13.19c3.14-5.11,2.22-6.81-3.8-7.63a69,69,0,0,0-13.7-.54c-13.73.9-26.73,4.93-39.29,10.35C269.49,61.3,252.85,71,239.77,85.76A55.64,55.64,0,0,0,232.71,96c-2.42,4.44-1.67,5.74,3.39,6.74C239.36,103.41,242.7,103.61,244.48,103.82Z"
                    transform="translate(-7.51 -11.03)" />
                <path
                    d="M647.38,960.94q291.72,0,583.43,0c9.38,0,18.25,1.49,26.19,6.87a37.49,37.49,0,0,1,15.37,41.69,38.8,38.8,0,0,1-35.21,28c-1.39.06-2.79,0-4.18,0H61.12c-19.93,0-35.41-11.56-39.81-29.68-5.21-21.5,10.61-44,32.64-46.35A98.11,98.11,0,0,1,64.37,961Q355.88,960.93,647.38,960.94Zm0,23.58H64a52.21,52.21,0,0,0-7.08.29,14.37,14.37,0,0,0-12.05,17c1.63,8.1,7.44,12.21,17.29,12.21H1231.93c1.25,0,2.51.05,3.76,0a14.71,14.71,0,0,0,.16-29.37c-2.07-.17-4.17-.12-6.26-.12Z"
                    transform="translate(-7.51 -11.03)" />
                <path
                    d="M658.53,937.22h-24c0-7.6-.66-15,.16-22.26,1.1-9.84,7.7-15.32,17.05-17.65q37.23-9.27,74.45-18.5,21.65-5.38,43.28-10.8a5.39,5.39,0,0,0,2.53-1.32H207.55c1.71.68,2.5,1.09,3.34,1.31l116.7,29.94c11.78,3,16.64,9.28,16.65,21.5v17.75h-24V919.82c-13.5-3.42-26.55-6.74-39.61-10Q214.3,893.1,148,876.4c-10.16-2.56-15.48-9.65-14.29-18.9,1.09-8.52,8.35-14.32,18.15-14.49,1.11,0,2.23,0,3.34,0H825.46c1.67,0,3.35,0,5,.07,9,.64,15.77,6.94,16.5,15.36s-4.51,15.47-13.28,17.73c-13.46,3.47-27,6.79-40.43,10.17Q728,902.74,662.65,919.11c-3,.76-4.47,1.88-4.2,5.26C658.78,928.5,658.53,932.68,658.53,937.22Z"
                    transform="translate(-7.51 -11.03)" />
                <path
                    d="M871,688.5h285.46c-1.38,10.34-2.71,20.37-4.07,30.4q-6.48,47.75-13,95.47c-3.29,24.1-6.18,48.27-10,72.29-4.43,27.51-29.76,50-57.6,50.48q-58,1-116.06,0c-29.27-.5-54.72-25-58.55-54-5.89-44.66-12.09-89.27-18.16-133.91q-3.81-28.1-7.61-56.21C871.18,691.64,871.12,690.25,871,688.5ZM1128.86,712H898.4c1.64,12.33,3.21,24.32,4.84,36.3,5.78,42.72,11.67,85.42,17.35,128.15,2.7,20.32,14.47,33.65,33.31,37a24.22,24.22,0,0,0,4.15.41c37,0,74,.22,111.08-.07,17.92-.14,34-14.39,36.69-31.89,2.23-14.43,4-28.92,6-43.39q7-51.25,13.92-102.51C1126.78,728.09,1127.79,720.13,1128.86,712Z"
                    transform="translate(-7.51 -11.03)" />
                <path
                    d="M269.87,818.74c9.51-3.73,19-7.5,28.54-11.17,29.81-11.47,59.29-24,89.55-34.1,47-15.76,95.43-19.17,144.62-12.73,33.5,4.38,65.19,14.7,96.24,27.62,25.13,10.46,50.52,20.27,76.92,30.83-2.07.2-3,.37-4,.37-18.51,0-37,.06-55.53,0a19.32,19.32,0,0,1-6.41-1.37c-23.73-8.69-47-19.13-71.22-25.88C501.2,773.52,434.82,778.53,370,804.71c-3.35,1.35-6.85,2.39-10.06,4-18.3,9.32-37.62,12.5-58.06,11-10.56-.78-21.24-.13-31.86-.13Z"
                    transform="translate(-7.51 -11.03)" />
                <path
                    d="M1011.13,678.29c-12.64.15-20.34-10.87-16.4-21.9,2.74-7.71,5.6-15.4,7.82-23.27,4-14.08,2.48-27.82-3.81-41-2.63-5.52-5.27-11-8.1-16.45-12-22.89-13.61-46.74-6.26-71.21a291,291,0,0,1,10.75-28.86c2.89-6.89,10.46-10.41,17.54-9.15,7.27,1.3,12.89,6.7,13.46,13.95.24,3.15-.85,6.52-1.82,9.64-3.33,10.71-7.5,21.2-10.18,32.07-2.94,11.93-1.13,23.78,4,35,2.33,5,4.6,10.14,7.29,15,14.83,26.73,15.29,54.3,5,82.54-1.71,4.69-3.49,9.37-5.49,14C1022.2,675,1016.88,677.77,1011.13,678.29Z"
                    transform="translate(-7.51 -11.03)" />
                <path
                    d="M1081.68,678.3c-12.37,0-19.85-10.9-16.12-21.8,3.14-9.18,6.44-18.35,8.73-27.75,2.93-12,1.21-23.78-4-35-4.14-9-8.71-17.71-12.64-26.75-9.84-22.66-8.16-45.59-.7-68.44,2.46-7.51,5.48-14.85,8.63-22.11a16.31,16.31,0,0,1,22.2-8.66c8.39,3.8,11.41,12.62,7.71,21.78-3,7.34-5.88,14.71-8.3,22.23-5.58,17.35-4.22,34.13,4.09,50.54,5.07,10,10,20.22,13.58,30.83,6.91,20.7,3.41,41.21-3.49,61.31-1.62,4.73-3.46,9.39-5.46,14C1093.09,675,1087.67,677.88,1081.68,678.3Z"
                    transform="translate(-7.51 -11.03)" />
                <path
                    d="M923.23,662.22c.86-2.76,1.7-5.52,2.56-8.27,2.65-8.47,5.86-16.81,7.84-25.43,2.92-12.77.66-25.15-5-36.9-2.66-5.51-5.31-11-8.12-16.44-11.66-22.51-13.31-46-6.18-70a275.92,275.92,0,0,1,11-29.64c3.19-7.52,11.46-10.8,19.2-8.61s12.56,8.84,11.85,16.5c-.23,2.42-1.34,4.77-2.13,7.13-3.24,9.73-7,19.31-9.63,29.21-3.39,12.92-1.74,25.68,3.83,37.85,2.31,5,4.63,10.12,7.32,15,14.4,26.05,15,53,5.34,80.57-1.89,5.37-3.87,10.73-6.24,15.9a16.06,16.06,0,0,1-18.42,8.81A16.8,16.8,0,0,1,923.23,662.22Z"
                    transform="translate(-7.51 -11.03)" />
                <path
                    d="M1152.19,896.18c1.29-7.81,2.53-15.31,3.8-23,18,4.61,30.61-4.61,40.51-17.53,21.07-27.48,24.75-57.86,12.24-90.1a48.32,48.32,0,0,0-6.29-10.76c-7.45-10.12-15.82-13.64-28.87-12.18.59-4.45,1.21-8.75,1.7-13.06,1.35-11.9,2.06-12.47,14.06-10.05,13.78,2.77,24.39,10.45,32.71,21.49,10.43,13.84,15.73,29.72,17.2,46.76,2.79,32.15-5,61.33-26.47,86-11.09,12.73-24.7,21.54-41.84,23.84A41.81,41.81,0,0,1,1152.19,896.18Z"
                    transform="translate(-7.51 -11.03)" />
                <path
                    d="M74.52,595.89c1.24-100,35.87-198.48,102.43-285.71,13.8-18.09,29.76-34.54,44.89-51.6,4.41-5,10.26-6.54,16.73-4.79a15.35,15.35,0,0,1,11.59,11.93c1.44,6.14-1.06,10.92-5.11,15.49C230.5,297.66,215.22,313.6,201.92,331c-46.66,61.1-76.71,129.69-88.91,205.7-11.82,73.72-5.25,145.81,21.14,215.87,3.69,9.8.16,18.52-8.82,22s-18.19-1-21.94-10.82C84.05,712.92,74.77,660.23,74.52,595.89Z"
                    transform="translate(-7.51 -11.03)" /></svg>

            <span class="logo-text danger"> MINE MENU</span>
        </a>
    </div>



    <div class="container">
        <form id="loginForm" action="{{route('login')}}" method="post">
            @csrf
            <h1>
                Sign in
            </h1>
            <div class="form-content">
                <input id="user-name" name="email" placeholder="Email" type="email" />
                <input id="password" name="password" placeholder="password" type="password" /><br />

                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{!! env('GOOGLE_RECAPTCHA_KEY') !!}"></div>
                @error('g-recaptcha-response')
                <span class="danger" style="font-size: 12px">Please Check reCaptcha</span><br>
                @enderror
                <br>
                {{-- <span style="font-size: 14px"><a href="{{ route('forget.password.get') }}">Forgot Password
                ?</a></span> --}}
                <p style="font-size: 16px;"><a href="{{ route('passwordRequestEmail') }}" style="color: #cc0022;"><b>Forget Password?</b></a></p>
                <p style="font-size: 16px;">Don't have an account?<a href="/register" style="color: #cc0022;"><b> Create an account!</b></a></p>
                <button type="submit" class="button">
                    Log in
                </button>
                <br />

                <div class="signup-message">
                    <a class="danger">@error('email')
                        {{$message}}
                        @enderror</a>
                </div>
            </div>
        </form>
    </div>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var alertData = {!! json_encode(session("alert")) !!};

        if (alertData) {
            toastr[alertData.type](alertData.message);
        }
    });
</script>
</html>