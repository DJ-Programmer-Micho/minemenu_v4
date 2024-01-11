@extends('main.layouts.clean')


@section('style')
<style>
    .g-recaptcha {
    transform:scale(0.9);
    transform-origin:0 0;
}
  </style>
@endsection

@section('content')
<div class="subs-text">
    <div class="row d-flex justify-content-center justify-content-md-between p-0 m-0 navAR">
        <div>
            <h3 style="font-weight: bold">{{__("Upgrade your Plan.")}}</h3>
            <P class="my-text">{{__("Full Management Of Your Menu")}}</P>
        </div>

    </div>
    <section class="price_plan_area section_padding_130_80 bg" id="pricing">
        <div class="container p-0 m-0 row">
            <div class="col-12 col-lg-8 p-1">
                <div class="single_price_plan active wow fadeInUp bo-red" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    {!! $plan->description_onpay[App::getLocale()] ?? '' !!}
                </div>
            </div>
            <div class="col-12 col-lg-4 p-1">
                <div class="single_price_plan active wow fadeInUp bo-red" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <form action="/subscribe" data-callback="g_check" method="POST" id="myForm">
                    @csrf
                    {{-- <input id="myCheck2" class="mx-1" type="checkbox" aria-label="Checkbox for following text input" name="auto_renew">Auto/Renew <span style="color: #cc0022; font-weight: bold;">(OPTIONAL)</span> --}}
                    <input type="hidden" name="id" value="{{$plan->id}}">
                    <h5 class="mb-4">{{__("Select Payment Method:")}}</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex align-items-center">
                            <input type="radio" id="creditCard" class="payment-option mx-2" name="payment_method" value="1" required>
                            <label for="creditCard">
                              <img src="{{asset('assets/main/img/payments/visa.png')}}" alt="Credit Card" width="30px" height="30px">
                            </label>
                            <label for="creditCard">
                              <img src="{{asset('assets/main/img/payments/master.png')}}" alt="Credit Card" width="50px" height="50px">
                            </label>
                          {{-- <span class="badge badge-primary badge-pill ml-auto">NEW</span> --}}
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <input type="radio" id="zaincash" class="payment-option mx-2" name="payment_method" value="2">
                            <label for="zaincash">
                              <img src="{{asset('assets/main/img/payments/zain.png')}}" alt="zaincash" width="40px" height="40px">
                            </label>
                          {{-- <span class="badge badge-primary badge-pill ml-auto">NEW</span> --}}
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <input type="radio" id="zaincash" class="payment-option mx-2" name="payment_method" value="3" disabled>
                            <label for="zaincash">
                              <img src="{{asset('assets/main/img/payments/fib.jpg')}}" alt="fib" width="40px" height="40px">
                            </label>
                          <span class="badge badge-danger badge-pill ml-auto">Soon</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <input type="radio" id="zaincash" class="payment-option mx-2" name="payment_method" value="4" disabled>
                            <label for="zaincash">
                              <img src="{{asset('assets/main/img/payments/fastpay.png')}}" alt="fastpay" width="40px" height="40px">
                            </label>
                          <span class="badge badge-danger badge-pill ml-auto">Soon</span>
                        </li>
                    </ul>   
                    <div class="my-4">                 
                    <input id="oneMyCheck" class="mx-1" type="checkbox" aria-label="Checkbox for following text input" onchange="oneMonthFunc()">I Agree to the site <a href="#" data-toggle="modal" data-target="#policyModal">terms &amp; conditions</a><br>
                    <div class="my-4">                 
                      <div style="color: #cc0022; font-weight: bold;">
                        
                        <p><i class="fa-solid fa-circle-check mx-1"></i>
                            You can cancel at any time.
                        </p> 
                        <p style="color: #09ac4d; font-weight: 400;">
                            Note// Our data encryption ensures your information is protected. <b>with confidence!</b>
                        </p>
                    </div>

                    <div class="my-4">
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <div class="g-recaptcha ar" id="feedback-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                        @error('g-recaptcha-response')
                        <span class="danger" style="font-size: 12px">please check recaptcha</span><br>
                        @enderror
                    </div>
                                                
                    <button id="submitBtn" class="tbnD btn btn-danger" disabled="">Payment</button>
                </form>
            </div>
            </div>

        </div>
    </section>
</div>

{{-- MODAL AGREEMENT --}}
<div id="policyModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Policy and Privacy</h2>
            <span class="modal-close" data-dismiss="modal">&times;</span>
        </div>
        <div class="modal-body">
            <h3><b>TERMS & CONDITIONS OF SERVICE AGREEMENT</b></h3><br>
            <p>LAST REVISION: [10-2-2023]</p><br>
            <p>PLEASE READ THIS TERMS OF SERVICE AGREEMENT CAREFULLY. BY USING THIS WEBSITE OR ORDERING PRODUCTS FROM
                THIS WEBSITE YOU AGREE TO BE BOUND BY ALL OF THE TERMS AND CONDITIONS OF THIS AGREEMENT.</p><br>
            <p>This Terms of Service Agreement (the "Agreement") governs your use of this website, <b>minemenu.com</b>
                (the "Website"), <b>MINE MENU</b>("Business Name") offer of products for purchase on this Website, or
                your purchase of products available on this Website. This Agreement includes, and incorporates by this
                reference, the policies and guidelines referenced below. <b>MINE MENU</b> reserves the right to change
                or revise the terms and conditions of this Agreement at any time by posting any changes or a revised
                Agreement on this Website. <b>MINE MENU</b> will alert you that changes or revisions have been made by
                indicating on the top of this Agreement the date it was last revised. The changed or revised Agreement
                will be effective immediately after it is posted on this Website. Your use of the Website following the
                posting any such changes or of a revised Agreement will constitute your acceptance of any such changes
                or revisions. <b>MINE MENU</b> encourages you to review this Agreement whenever you visit the Website to
                make sure that you understand the terms and conditions governing use of the Website. This Agreement does
                not alter in any way the terms or conditions of any other written agreement you may have with <b>MINE
                    MENU</b> for other products or services. If you do not agree to this Agreement (including any
                referenced policies or guidelines), please immediately terminate your use of the Website.</p><br>
            <br>
            <h3><b>I. PRODUCTS</b></h3><br>
            <p>Terms of Offer. This Website offers for sale certain products (the <b>Digital Restaurant’s, Bars, Coffee
                    Shop and Market’s Menu</b>). By placing an order for Products through this Website, you agree to the
                terms set forth in this Agreement. </p><br>
            <p><b>Customer Solicitation: </b> Unless you notify our third-party call center reps or direct <b>MINE
                    MENU</b> sales reps, while they are calling you, of your desire to opt out from further direct
                company communications and solicitations, you are agreeing to continue to receive further emails and
                call solicitations <b>MINE MENU</b> and it’s designated in house or third-party call team(s).</p><br>
            <p><b>Opt Out Procedure:</b> We provide 3 easy ways to opt out of from future solicitations.<br>1. You may
                use the opt out link found in any email solicitation that you may receive.<br>2. You may also choose to
                opt out, via sending your email address to: <a
                    href="https://minemenu.com/contact">https://minemenu.com/contact</a>.<br> 3. You may send a written
                remove request to <a href="mailto:support@minemenu.com">support@minemenu.com</a></p><br>
            <br>
            <h3><b>II. WEBSITE</b></h3><br>
            <p>Content; Intellectual Property; Third Party Links. In addition to making Products available, this Website
                also offers information and marketing materials. This Website also offers information, both directly and
                through indirect links to third-party websites, about nutritional and dietary supplements. <b>MINE
                    MENU</b> does not always create the information offered on this Website; instead, the information is
                often gathered from other sources. To the extent that <b>MINE MENU</b> does create the content on this
                Website, such content is protected by intellectual property laws of the <em>IRAQ</em>, foreign nations,
                and international bodies. Unauthorized use of the material may violate copyright, trademark, and/or
                other laws. You acknowledge that your use of the content on this Website is for personal, noncommercial
                use. Any links to third-party websites are provided solely as a convenience to you. <b>MINE MENU</b>
                does not endorse the contents on any such third-party websites. <b>MINE MENU</b> is not responsible for
                the content of or any damage that may result from your access to or reliance on these third-party
                websites. If you link to third-party websites, you do so at your own risk.</p><br>
            <p>Use of Website; <b>MINE MENU</b> is not responsible for any damages resulting from use of this website by
                anyone. You will not use the Website for illegal purposes. You will (1) abide by all applicable local,
                state, national, and international laws and regulations in your use of the Website (including laws
                regarding intellectual property), (2) not interfere with or disrupt the use and enjoyment of the Website
                by other users, (3) not resell material on the Website, (4) not engage, directly or indirectly, in
                transmission of "spam", chain letters, junk mail or any other type of unsolicited communication, and (5)
                not defame, harass, abuse, or disrupt other users of the Website</p><br>
            <p>License. By using this Website, you are granted a limited, non-exclusive, non-transferable right to use
                the content and materials on the Website in connection with your normal, noncommercial, use of the
                Website. You may not copy, reproduce, transmit, distribute, or create derivative works of such content
                or information without express written authorization from <b>MINE MENU</b> or the applicable third party
                (if third party content is at issue).Posting. By posting, storing, or transmitting any content on the
                Website, you hereby grant <b>MINE MENU</b> a perpetual, worldwide, non-exclusive, royalty-free,
                assignable, right and license to use, copy, display, perform, create derivative works from, distribute,
                have distributed, transmit and assign such content in any form, in all media now known or hereinafter
                created, anywhere in the world. <b>MINE MENU</b> does not have the ability to control the nature of the
                user-generated content offered through the Website. You are solely responsible for your interactions
                with other users of the Website and any content you post. <b>MINE MENU</b> is not liable for any damage
                or harm resulting from any posts by or interactions between users. <b>MINE MENU</b> reserves the right,
                but has no obligation, to monitor interactions between and among users of the Website and to remove any
                content <b>MINE MENU</b> deems objectionable, in Muscle UP Nutrition 's sole discretion.</p><br>
            <br>
            <h3><b>III. DISCLAIMER OF WARRANTIES</b></h3><br>
            <p>YOUR USE OF THIS WEBSITE AND/OR PRODUCTS ARE AT YOUR SOLE RISK. THE WEBSITE AND PRODUCTS ARE OFFERED ON
                AN <b>"AS IS" AND "AS AVAILABLE"</b> BASIS. <b>MINE MENU</b> EXPRESSLY DISCLAIMS ALL WARRANTIES OF ANY
                KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY,
                FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT WITH RESPECT TO THE PRODUCTS OR WEBSITE CONTENT,
                OR ANY RELIANCE UPON OR USE OF THE WEBSITE CONTENT OR PRODUCTS. ("PRODUCTS" INCLUDE TRIAL PRODUCTS.)</p>
            <br>
            <p>WITHOUT LIMITING THE GENERALITY OF THE FOREGOING, <b>MINE MENU</b> MAKES NO WARRANTY:</p><br>
            <p>THAT THE INFORMATION PROVIDED ON THIS WEBSITE IS ACCURATE, RELIABLE, COMPLETE, OR TIMELY.</p><br>
            <p>THAT THE LINKS TO THIRD-PARTY WEBSITES ARE TO INFORMATION THAT IS ACCURATE, RELIABLE, COMPLETE, OR
                TIMELY.</p><br>
            <p>NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED BY YOU FROM THIS WEBSITE WILL CREATE ANY
                WARRANTY NOT EXPRESSLY STATED HEREIN.</p><br>
            <p>AS TO THE RESULTS THAT MAY BE OBTAINED FROM THE USE OF THE PRODUCTS OR THAT DEFECTS IN PRODUCTS WILL BE
                CORRECTED.</p><br>
            <p>REGARDING ANY PRODUCTS PURCHASED OR OBTAINED THROUGH THE WEBSITE.</p><br>
            <p>SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF CERTAIN WARRANTIES, SO SOME OF THE ABOVE EXCLUSIONS MAY
                NOT APPLY TO YOU.</p><br>
            <br>
            <h3><b>IV. LIMITATION OF LIABILITY</b></h3><br>
            <p><b>MINE MENU</b> ENTIRE LIABILITY, AND YOUR EXCLUSIVE REMEDY, IN LAW, IN EQUITY, OR OTHWERWISE, WITH
                RESPECT TO THE WEBSITE CONTENT AND PRODUCTS AND/OR FOR ANY BREACH OF THIS AGREEMENT IS SOLELY LIMITED TO
                THE AMOUNT YOU PAID, LESS SHIPPING AND HANDLING, FOR PRODUCTS PURCHASED VIA THE WEBSITE.</p><br>
            <p><b>MINE MENU</b> WILL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL OR CONSEQUENTIAL
                DAMAGES IN CONNECTION WITH THIS AGREEMENT OR THE PRODUCTS IN ANY MANNER, INCLUDING LIABILITIES RESULTING
                FROM (1) THE USE OR THE INABILITY TO USE THE WEBSITE CONTENT OR PRODUCTS; (2) THE COST OF PROCURING
                SUBSTITUTE PRODUCTS OR CONTENT; (3) ANY PRODUCTS PURCHASED OR OBTAINED OR TRANSACTIONS ENTERED INTO
                THROUGH THE WEBSITE; OR (4) ANY LOST PROFITS YOU ALLEGE.</p><br>
            <p>SOME JURISDICTIONS DO NOT ALLOW THE LIMITATION OR EXCLUSION OF LIABILITY FOR INCIDENTAL OR CONSEQUENTIAL
                DAMAGES SO SOME OF THE ABOVE LIMITATIONS MAY NOT APPLY TO YOU.</p><br>
            <br>
            <h3><b>V. INDEMNIFICATION</b></h3><br>
            <p>You will release, indemnify, defend and hold harmless <b>MINE MENU</b>, and any of its contractors,
                agents, employees, officers, directors, shareholders, affiliates and assigns from all liabilities,
                claims, damages, costs and expenses, including reasonable attorneys' fees and expenses, of third parties
                relating to or arising out of (1) this Agreement or the breach of your warranties, representations and
                obligations under this Agreement; (2) the Website content or your use of the Website content; (3) the
                Products or your use of the Products (including Trial Products); (4) any intellectual property or other
                proprietary right of any person or entity; (5) your violation of any provision of this Agreement; or (6)
                any information or data you supplied to <b>MINE MENU</b>. When <b>MINE MENU</b> is threatened with suit
                or sued by a third party, <b>MINE MENU</b> may seek written assurances from you concerning your promise
                to indemnify <b>MINE MENU</b>; your failure to provide such assurances may be considered by <b>MINE
                    MENU</b> to be a material breach of this Agreement. <b>MINE MENU</b> will have the right to
                participate in any defense by you of a third-party claim related to your use of any of the Website
                content or Products, with counsel of <b>MINE MENU</b> choice at its expense. <b>MINE MENU</b> will
                reasonably cooperate in any defense by you of a third-party claim at your request and expense. You will
                have sole responsibility to defend <b>MINE MENU</b> against any claim, but you must receive <b>MINE
                    MENU</b> prior written consent regarding any related settlement. The terms of this provision will
                survive any termination or cancellation of this Agreement or your use of the Website or Products.</p>
            <br>
            <br>
            <h3><b>VI. PRIVACY</b></h3><br>
            <p><b>MINE MENU</b> believes strongly in protecting user privacy and providing you with notice of MuscleUP
                Nutrition 's use of data. Please refer to <b>MINE MENU</b> privacy policy, incorporated by reference
                herein, that is posted on the Website.</p><br>
            <br>
            <h3><b>VII. AGREEMENT TO BE BOUND</b></h3><br>
            <p>By using this Website or ordering Products, you acknowledge that you have read and agree to be bound by
                this Agreement and all terms and conditions on this Website. </p><br>
            <br>
            <h3><b>VIII. GENERAL</b></h3><br>
            <p>Force Majeure. <b>MINE MENU</b> will not be deemed in default hereunder or held responsible for any
                cessation, interruption or delay in the performance of its obligations hereunder due to earthquake,
                flood, fire, storm, natural disaster, act of God, war, terrorism, armed conflict, labor strike, lockout,
                or boycott.</p><br>
            <p>Cessation of Operation. <b>MINE MENU</b> may at any time, in its sole discretion and without advance
                notice to you, cease operation of the Website and distribution of the Products</p><br>
            <p>Entire Agreement. This Agreement comprises the entire agreement between you and <b>MINE MENU</b> and
                supersedes any prior agreements pertaining to the subject matter contained herein.</p><br>
            <p>Effect of Waiver. The failure of <b>MINE MENU</b> to exercise or enforce any right or provision of this
                Agreement will not constitute a waiver of such right or provision. If any provision of this Agreement is
                found by a court of competent jurisdiction to be invalid, the parties nevertheless agree that the court
                should endeavor to give effect to the parties' intentions as reflected in the provision, and the other
                provisions of this Agreement remain in full force and effect.</p><br>
            <p>Governing Law; <em>IRAQ – KURSIDTAN</em> This Website originates from the Erbil. This Agreement will be
                governed by the laws of the Country of Law’s without regard to its conflict of law principles to the
                contrary. Neither you nor <b>MINE MENU</b> will commence or prosecute any suit, proceeding or claim to
                enforce the provisions of this Agreement, to recover damages for breach of or default of this Agreement,
                or otherwise arising under or by reason of this Agreement, other than in courts located in Country of
                Iraq, By using this Website or ordering Products, you consent to the jurisdiction and venue of such
                courts in connection with any action, suit, proceeding or claim arising under or by reason of this
                Agreement. You hereby waive any right to trial by jury arising out of this Agreement and any related
                documents.</p><br>
            <p>Statute of Limitation. You agree that regardless of any statute or law to the contrary, any claim or
                cause of action arising out of or related to use of the Website or Products or this Agreement must be
                filed within one (1) year after such claim or cause of action arose or be forever barred.</p><br>
            <br>
            <p>Waiver of Class Action Rights. BY ENTERING INTO THIS AGREEMENT, YOU HEREBY IRREVOCABLY WAIVE ANY RIGHT
                YOU MAY HAVE TO JOIN CLAIMS WITH THOSE OF OTHER IN THE FORM OF A CLASS ACTION OR SIMILAR PROCEDURAL
                DEVICE. ANY CLAIMS ARISING OUT OF, RELATING TO, OR CONNECTION WITH THIS AGREEMENT MUST BE ASSERTED
                INDIVIDUALLY.</p><br>
            <br>
            <p>Termination. <b>MINE MENU</b> reserves the right to terminate your access to the Website if it reasonably
                believes, in its sole discretion, that you have breached any of the terms and conditions of this
                Agreement. Following termination, you will not be permitted to use the Website and <b>MINE MENU</b> may,
                in its sole discretion and without advance notice to you, cancel any outstanding orders for Products. If
                your access to the Website is terminated, <b>MINE MENU</b> reserves the right to exercise whatever means
                it deems necessary to prevent unauthorized access of the Website. This Agreement will survive
                indefinitely unless and until <b>MINE MENU</b> chooses, in its sole discretion and without advance to
                you, to terminate it.</p><br>
            <p>Domestic Use. <b>MINE MENU</b> makes no representation that the Website or Products are appropriate or
                available for use in locations outside India. Users who access the Website from outside India do so at
                their own risk and initiative and must bear all responsibility for compliance with any applicable local
                laws. Assignment. You may not assign your rights and obligations under this Agreement to anyone. <b>MINE
                    MENU</b> may assign its rights and obligations under this Agreement in its sole discretion and
                without advance notice to you.</p><br>
            <p>BY USING THIS WEBSITE OR ORDERING PRODUCTS FROM THIS WEBSITE YOU AGREE TO BE BOUND BY ALL OF THE TERMS
                AND CONDITIONS OF THIS AGREEMENT</p><br>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-danger">Accept</button>
        </div>
    </div>
</div>



<div id="warnModal" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2>{{__("Warnning")}}</h2>
        <span class="modal-close">&times;</span>
      </div>
      <div class="modal-body">
        <p class="text-center">{{__("Plase Note that if you have any other subscription , it'll be canceled and start over")}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="acceptBtn" class="btn btn-danger">{{__("Accept")}}</button>
        <button type="button" id="declineBtn" class="btn btn-info">{{__("Decline")}}</button>
      </div>
    </div>
    </div>
  </div>

@endsection


@section('script')
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>
<script>
function oneMonthFunc() {
    var checkBox1 = document.getElementById("oneMyCheck");
    if (checkBox1.checked == true) {
        document.getElementById("submitBtn").disabled = false
    } else {
        document.getElementById("submitBtn").disabled = true
    }
}


document.getElementById("myForm").addEventListener("submit", function(event) {
  event.preventDefault();
  document.getElementById("warnModal").style.display = "block";
});

document.getElementById("acceptBtn").addEventListener("click", function() {
  document.getElementById("warnModal").style.display = "none";
  // submit the form
  document.getElementById("myForm").submit();
});

document.getElementById("declineBtn").addEventListener("click", function() {
  document.getElementById("warnModal").style.display = "none";
});

document.getElementsByClassName("modal-close")[1].addEventListener("click", function() {
  document.getElementById("warnModal").style.display = "none";
});


</script>
@endsection