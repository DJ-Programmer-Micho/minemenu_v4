@extends('main.layouts.master')
@section('main_content')
@php
    $quickLink = app('cloudfront').'mine-setting/documentation/';
    $localTemp = app()->getLocale();
@endphp
<div class="marg"></div>
<div class="container-fluid documentation">
    <div class="container-xxl py-5 faqsSection">
        <div class="container-fluid">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-6">{{__('Documentation')}}</h1>
                <p class="text-dark fs-5 mb-5">{{__('Steps of how to use Mine Menu')}}</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12 p-0">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                          <div class="card-header p-0" id="headingOne">
                            <h2 class="mb-0">
                              <button class="btn btn-danger btn-block {{ $localTemp == 'en' ? 'text-left' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'text-right' : '') }}" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSectionOne" aria-expanded="true" aria-controls="collapseSectionOne">
                                {{__('STEP 1 - How to register to Mine Menu')}}
                              </button>
                            </h2>
                          </div>
                          {{-- step 1 --}}
                          <div id="collapseSectionOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between ar">
                                <div class="col-lg-6 p-0">
                                    <ul class="{{ $localTemp == 'en' ? 'pl-4' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'pr-4 text-right' : '') }}">
                                        <li>{{__('Click on the link')}} <a href="https://minemenu.com/register" target="_blank">{{__('Register')}}</a> {{__('to sign up for Mine Menu.')}}</li>
                                        <li>{{__('You need to fill out the form, providing the following information:')}}</li>
                                        <ol>
                                            <li>{{__('Full Name: Your actual name.')}}</li>
                                            <li>{{__('Brand Name: Your business name (restaurant name, coffee name, hotel name, etc.). It should be in lowercase and well-written in English. This will be shown as:')}}<br><b> {{__('https://minemenu.com/')}}<span style="color: #cc0022;">{{__('brandName')}}</span></b></li>
                                            <li>{{__('Email Address: This is crucial, as we will send an OTP verification code to this email address.')}}</li>
                                            <li>{{__('Phone Number: This is crucial, as we will send an OTP verification code to this phone number.')}}</li>
                                            <li>{{__('Password: Minimum 8 characters.')}}</li>
                                            <li>{{__('Country.')}}</li>
                                            <li>{{__('City.')}}</li>
                                            <li>{{__('State.')}}</li>
                                            <li>{{__('Brand Type: Select your brand type.')}}</li>
                                            <li>{{__('Then check the reCAPTCHA (I am not a robot).')}}</li>
                                            <li>{{__('Finally, click Reserve Now.')}}</li>
                                        </ol>
                                    </ul>
                                    
                                </div>
                                <div class="col-lg-6 p-0">
                                    <img src="{{ file_exists($quickLink . $localTemp .'/r1.jpg') ? $quickLink. $localTemp .'/r1.jpg' : $quickLink . 'en/r1.jpg' }}" width="100%" alt="Mine-Menu" title="Mine-Menu">
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                        {{-- step 2 --}}
                        <div class="card">
                          <div class="card-header p-0" id="headingTwo">
                            <h2 class="mb-0">
                              <button class="btn btn-danger btn-block {{ $localTemp == 'en' ? 'text-left' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'text-right' : '') }}" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSectionTwo" aria-expanded="true" aria-controls="collapseSectionOne">
                                {{__('STEP 2 - Verify Your Email')}}
                              </button>
                            </h2>
                          </div>
                      
                          <div id="collapseSectionTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between ar">
                                <div class="col-lg-6 p-0">
                                    <ul class="{{ $localTemp == 'en' ? 'pl-4' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'pr-4 text-right' : '') }}">
                                        <li>{{__('In the beginning, a dialog box will appear prompting you to double-check your email. If the email is correct, click the (Yes) button; otherwise, click (No) and correct the spelling of your email.')}}</li>
                                        <li>{{__('After you click (Yes), an OTP code will be sent to your email. Please enter the 6-digit number and proceed to the next step')}}</li>
                                        <small class="text-danger">{{__('Note: It may take up to 5 minutes to receive the code.')}}</small>
                                    </ul>
                                </div>
                                <div class="row col-lg-6 p-0">
                                  <img src="{{ file_exists($quickLink . $localTemp .'/r3.jpg') ? $quickLink. $localTemp .'/r3.jpg' : $quickLink . 'en/r3.jpg' }}" width="50%" alt="Mine-Menu" title="Mine-Menu">
                                  <img src="{{ file_exists($quickLink . $localTemp .'/r4.jpg') ? $quickLink. $localTemp .'/r4.jpg' : $quickLink . 'en/r4.jpg' }}" width="50%" alt="Mine-Menu" title="Mine-Menu">
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                        {{-- step 3 --}}
                        <div class="card">
                          <div class="card-header p-0" id="headingThree">
                            <h2 class="mb-0">
                              <button class="btn btn-danger btn-block {{ $localTemp == 'en' ? 'text-left' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'text-right' : '') }}" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSectionThree" aria-expanded="true" aria-controls="collapseSectionOne">
                                {{__('STEP 3 - Verify Your Phone Number')}}
                              </button>
                            </h2>
                          </div>
                      
                          <div id="collapseSectionThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between ar">
                                <div class="col-lg-6 p-0">
                                    <ul class="{{ $localTemp == 'en' ? 'pl-4' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'pr-4 text-right' : '') }}">
                                        <li>{{__('After Verifying email, a dialog box will appear prompting you to double-check your phone number. If the phone is correct, click the (Yes) button; otherwise, click (No) and correct the spelling of your SMS.')}}</li>
                                        <li>{{__('After you click (Yes), an OTP code will be sent to your SMS. Please enter the 4-digit number and proceed to the next step')}}</li>
                                        <small class="text-danger">{{__('Note: It may take up to 5 minutes to receive the code.')}}</small>
                                    </ul>
                                </div>
                                <div class="row col-lg-6 p-0">
                                  <img src="@if(empty($quickLink . $localTemp .'/r5.jpg')) {{ $quickLink. $localTemp .'/r5.jpg' }} @else {{ $quickLink . 'en/r5.jpg' }} @endif" width="50%" alt="Mine-Menu" title="Mine-Menu">
                                  <img src="@if(empty($quickLink . $localTemp .'/r6.jpg')) {{ $quickLink. $localTemp .'/r6.jpg' }} @else {{ $quickLink . 'en/r6.jpg' }} @endif" width="50%" alt="Mine-Menu" title="Mine-Menu">
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                        {{-- step 4 --}}
                        <div class="card">
                          <div class="card-header p-0" id="headingFour">
                            <h2 class="mb-0">
                              <button class="btn btn-danger btn-block {{ $localTemp == 'en' ? 'text-left' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'text-right' : '') }}" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSectionFour" aria-expanded="true" aria-controls="collapseSectionOne">
                                {{__('STEP 4 - Accessing the Dashboard.')}}
                              </button>
                            </h2>
                          </div>
                      
                          <div id="collapseSectionFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between ar">
                                <div class="col-lg-6 p-0">
                                    <ul class="{{ $localTemp == 'en' ? 'pl-4' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'pr-4 text-right' : '') }}">
                                        <li>{{__('After verifying your email address and phone number, you will be directed to the dashboard, where you can control your menu/e-menu.')}}</li>
                                    </ul>
                                </div>
                                <div class="row col-lg-6 p-0">
                                  <img src="@if(empty($quickLink . $localTemp .'/r7.jpg')) {{ $quickLink. $localTemp .'/r7.jpg' }} @else {{ $quickLink . 'en/r7.jpg' }} @endif" width="100%" alt="Mine-Menu" title="Mine-Menu">                                
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                        {{-- step 5 --}}
                        <div class="card">
                          <div class="card-header p-0" id="headingFive">
                            <h2 class="mb-0">
                              <button class="btn btn-danger btn-block {{ $localTemp == 'en' ? 'text-left' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'text-right' : '') }}" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSectionFive" aria-expanded="true" aria-controls="collapseSectionOne">
                                {{__('STEP 5 - Change Your Dashboard Language.')}}
                              </button>
                            </h2>
                          </div>
                          <div id="collapseSectionFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between ar">
                                <div class="col-lg-6 p-0">
                                    <ul class="{{ $localTemp == 'en' ? 'pl-4' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'pr-4 text-right' : '') }}">
                                        <li>{{__('When clicking on the logo, as shown in the image, the list of languages will appear to you when choosing any language, the language of the interface will change')}}
                                    </ul>
                                </div>
                                <div class="row col-lg-6 p-0">
                                  <img src="@if(empty($quickLink . $localTemp .'/r8.jpg')) {{ $quickLink. $localTemp .'/r8.jpg' }} @else {{ $quickLink . 'en/r8.jpg' }} @endif" width="100%" alt="Mine-Menu" title="Mine-Menu">                                
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                        {{-- step 6 --}}
                        <div class="card">
                          <div class="card-header p-0" id="headingSix">
                            <h2 class="mb-0">
                              <button class="btn btn-danger btn-block {{ $localTemp == 'en' ? 'text-left' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'text-right' : '') }}" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSectionSix" aria-expanded="true" aria-controls="collapseSectionOne">
                                {{__('STEP 6 - Control Your Menu Languages.')}}
                              </button>
                            </h2>
                          </div>
                          <div id="collapseSectionSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between ar">
                                <div class="col-lg-6 p-0">
                                    <ul class="{{ $localTemp == 'en' ? 'pl-4' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'pr-4 text-right' : '') }}">
                                        <li>{{__('Go to Settings (1) -> Language (2). Here, you can select the languages you want to display in your menu.')}}</li>
                                          <ol>
                                            <li>{{__('We activate or not activate the language (3)')}}</li>
                                            <li>{{__('We pull the language tab down when it is not activated and pull the language bar to the top when activating. It also affects the sorting.')}}</li>
                                            <li>{{__('Then we press up update the language after completion (4)')}}</li>
                                          </ol>
                                    </ul>
                                </div>
                                <div class="row col-lg-6 p-0">
                                  <img src="@if(empty($quickLink . $localTemp .'/r9.jpg')) {{ $quickLink. $localTemp .'/r9.jpg' }} @else {{ $quickLink . 'en/r9.jpg' }} @endif" width="100%" alt="Mine-Menu" title="Mine-Menu">                                
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                        {{-- step 7 --}}
                        <div class="card">
                          <div class="card-header p-0" id="headingSeven">
                            <h2 class="mb-0">
                              <button class="btn btn-danger btn-block {{ $localTemp == 'en' ? 'text-left' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'text-right' : '') }}" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSectionSeven" aria-expanded="true" aria-controls="collapseSectionOne">
                                {{__('STEP 7 - Naming Your Menu.')}}
                              </button>
                            </h2>
                          </div>
                          <div id="collapseSectionSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between ar">
                                <div class="col-lg-6 p-0">
                                    <ul class="{{ $localTemp == 'en' ? 'pl-4' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'pr-4 text-right' : '') }}">
                                        <li>{{__('Go to Settings (1) -> Resturant Name (2). Here, you can rename your menu.')}}</li>
                                        <li>{{__('What you can do here is:')}}</li>
                                          <ol>
                                            <li>{{__('Rename your menu based on your restaurant name or other selected language (3, 4, 5)')}}</li>
                                            <li>{{__('Readdress your menu based on your location in the selected language (6, 7, 8)')}}</li>
                                          </ol>
                                    </ul>
                                </div>
                                <div class="row col-lg-6 p-0">
                                  <img src="@if(empty($quickLink . $localTemp .'/r11.jpg')) {{ $quickLink. $localTemp .'/r11.jpg' }} @else {{ $quickLink . 'en/r11.jpg' }} @endif" width="100%" alt="Mine-Menu" title="Mine-Menu">                                
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                        {{-- step 8 --}}
                        <div class="card">
                          <div class="card-header p-0" id="headingEight">
                            <h2 class="mb-0">
                              <button class="btn btn-danger btn-block {{ $localTemp == 'en' ? 'text-left' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'text-right' : '') }}" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSectionEight" aria-expanded="true" aria-controls="collapseSectionOne">
                                {{__('STEP 8 - Control Your Menu Information.')}}
                              </button>
                            </h2>
                          </div>
                          <div id="collapseSectionEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between ar">
                                <div class="col-lg-6 p-0">
                                    <ul class="{{ $localTemp == 'en' ? 'pl-4' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'pr-4 text-right' : '') }}">
                                        <li>{{__('Go to Settings (1) -> Menu Setting (2). Here, you can update your menu setting.')}}</li>
                                        <li>{{__('You can add:')}}</li>
                                          <ol>
                                            <li>{{__('Phone Number (3)')}}</li>
                                            <li>{{__('Wifi Password (4)')}}</li>
                                            <li>{{__('Currency Type ($,£,€,دينار عراقي) (5)')}}</li>
                                            <li>{{__('Add service tax, and here it will be added to the cost and will appear in the account bill (6)')}}</li>
                                            <li>{{__('Notes field, and will display what languages you choose in your menu setting (7)')}}</li>
                                            <li>{{__('Social media information and will appear on the phone on a page to contact us (8,9,10,11,12,13)')}}</li>
                                            <li>{{__('The restaurant Location on Google Map (14)')}}</li>
                                            <li>{{__('If you want to create a channel on the Telegram, you will be able to follow the changes that limit the menu from the control panel and you will receive the notifications in the event of any change. (15,16)')}}</li>
                                            <li>{{__('After completing the updates, press the save button (17)')}}</li>
                                          </ol>
                                    </ul>
                                </div>
                                <div class="row col-lg-6 p-0">
                                  <img src="@if(empty($quickLink . $localTemp .'/r10.jpg')) {{ $quickLink. $localTemp .'/r10.jpg' }} @else {{ $quickLink . 'en/r10.jpg' }} @endif" width="100%" alt="Mine-Menu" title="Mine-Menu">                                
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                        {{-- step 9 --}}
                        <div class="card">
                          <div class="card-header p-0" id="headingNine">
                            <h2 class="mb-0">
                              <button class="btn btn-danger btn-block {{ $localTemp == 'en' ? 'text-left' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'text-right' : '') }}" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSectionNine" aria-expanded="true" aria-controls="collapseSectionOne">
                                {{__('STEP 9 - Tutorial')}}
                              </button>
                            </h2>
                          </div>
                          <div id="collapseSectionNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row d-flex justify-content-between ar">
                                <div class="col-lg-12 p-0">
                                    <ul class="{{ $localTemp == 'en' ? 'pl-4' : ($localTemp == 'ar' || $localTemp == 'ku' ? 'pr-4 text-right' : '') }}">
                                        <li>{{__('Need a tutorial or video explanation? Click on the link to our official YouTube Channel and check out all the videos in our playlist. Everything is explained there on how to use our dashboard like a pro')}}</li>
                                        <a href="https://www.youtube.com/watch?v=vpNjtz_1j3Q&list=PLQe1kP4aCPRaKxCgNOOLTjHbj6SrI_y5M" class="btn btn-danger my-3 p-2" target="_blank">{{__("Youtube")}}</a>
                                    </ul>
                                </div>
                                {{-- <div class="row col-lg-6 p-0">
                                  <img src="@if(empty($quickLink . $localTemp .'/r10.jpg')) {{ $quickLink. $localTemp .'/r10.jpg' }} @else {{ $quickLink . 'en/r10.jpg' }} @endif" width="100%" alt="Mine-Menu" title="Mine-Menu">                                
                                </div> --}}
                            </div>
                            </div>
                          </div>
                        </div>

                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="marg"></div>
</div>
<div class="marg"></div>



@endsection