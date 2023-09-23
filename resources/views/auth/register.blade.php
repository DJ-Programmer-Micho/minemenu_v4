
@extends('main.layouts.master')

@section('main_style')
{{-- <link rel="stylesheet" href="{{asset('assets/general/lib/teleSelect/intlTelInput.min.css')}}"> --}}
<link rel="stylesheet" href="{{asset('assets/general/lib/teleSelect/demo.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
{{-- <link rel="stylesheet" href="{{asset('assets/general/lib/country_select/countrySelect.min.css')}}"> --}}
<link rel="stylesheet" href="{{asset('assets/general/lib/country_select/country_select.css')}}">
<style>
     .modal {
	display: none;
	position: fixed;
	z-index: 1;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	overflow: auto;
	background-color: rgba(0, 0, 0, 0.5);
  }
  
  .modal-content {
	background-color: #fff;
	border-radius: 10px;
	box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
	margin: 7% auto;
	padding: 20px;
	width: 80%;
	height: 80%;
	overflow: scroll;
  }
  
  .modal-header {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding-bottom: 20px;
	border-bottom: 1px solid #ccc;
  }
  
  .modal-footer {
	display: flex;
	justify-content: flex-end;
	padding: 20px;
  }
  
  .modal-close {
	cursor: pointer;
	font-size: 18px;
  }

  #declineBtn{



  }

  
</style>

@endsection

@section('main_content')

<div class="marg"></div>

<div class="container">




  <h2 class="text-center mb-5">{{__("Reserve Demo Menu")}}</h2>

  <div class="my-text mb-5">
    <p style="font-size: 14px">{{__("Already have an account?")}}<a href="/rest"> {{__("Sign in now")}}</a></p>
  </div>

  @if (session('success'))
  <p class="alert alert-success ar my-text">{{__("Thank you For Reserving Our Menu We'll Reach You Very Soon")}}</p>
  @endif
  <form class="demo-form" method="POST" action="{{ route('signup') }}" id="myForm">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputName">{{__("Full Name")}} 
          @error('fullname')
            <span class="text-danger">{{__("$message")}}</span>
          @enderror
        </label>
        <input type="text" class="form-control shadow-none" id="inputName" placeholder="" name="fullname" value="{{old('fullname')}}" required>
      </div>
      <div class="form-group col-md-6">
        <label for="inputRestName">{{__("Brand Name")}}
          @error('name')
          <span class="text-danger">{{__("$message")}}</span>
          @enderror
        </label>
        <input type="text" class="form-control" id="inputRestName" placeholder="" name="name" value="{{old('name')}}" required>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">{{__("Email")}}
          @error('email')
          <span class="text-danger">{{__("$message")}}</span>
          @enderror
        </label>
        <input type="email" class="form-control" id="inputEmail4" placeholder="" name="email" value="{{old('email')}}"  required>
      </div>
      <div class="form-group col-md-6 phone">
        <label for="inputPhone">{{__("Phone Number")}}
          @error('phone')
          <span class="text-danger">{{__("$message")}}</span>
          @enderror
        </label>
        <input type="tel" class="form-control" id="inputPhone" placeholder="" name="phone" value="{{old('phone')}}" dir="ltr" required>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="inputPass">{{__("Password")}}
          @error('password')
          <span class="text-danger">{{__("$message")}}</span>
          @enderror
        </label>
        <input type="password" class="form-control" id="inputPass" placeholder="" name="password" value="{{old('password')}}" required min="6">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6 country">
        <label for="country_selector">{{__("Country")}}</label>
        <input type="text" class="form-control" id="country_selector" name="country" value="{{old('country')}}">
      </div>

      <div class="form-group col-md-6">
        <label for="state">{{__("State")}}</label>
        <input type="text" class="form-control" id="state" name="state" value="{{old('state')}}">
      </div>
 
    </div>

    <div class="form-group">
      <label for="inputAddress">{{__("Address")}}
        @error('address')
        <span class="text-danger">{{__("$message")}}</span>
        @enderror
      </label>
      <input type="text" class="form-control" id="inputAddress" placeholder="" name="address" value="{{old('address')}}">
    </div>

    <div class="form-group mt-5 options">
      <label for="" class="font-weight-bold">{{__("Brand Type")}}</label>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="rest" name="brand_type[]" value="Restaurant" required>
        <label class="form-check-label" for="rest">{{__("Restaurant")}}</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="cafe" name="brand_type[]" value="Cafe" required>
        <label class="form-check-label" for="cafe">{{__("Cafe")}}</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="hotel" name="brand_type[]" value="Hotel" required>
        <label class="form-check-label" for="hotel">{{__("Hotel")}}</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="spa" name="brand_type[]" value="Spa" required>
        <label class="form-check-label" for="spa">{{__("Spa")}}</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="resurt" name="brand_type[]" value="Resurt" required>
        <label class="form-check-label" for="resurt">{{__("Resurt")}}</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="truck" name="brand_type[]" value="Food Truck" required>
        <label class="form-check-label" for="truck">{{__("Food Truck")}}</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="other" name="brand_type[]" value="Other" required>
        <label class="form-check-label" for="other">{{__("Other")}}</label>
      </div>
    </div>


    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div class="g-recaptcha ar" id="feedback-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
    @error('g-recaptcha-response')
    <span class="danger" style="font-size: 12px">please check recaptcha</span><br>
    @enderror

    <div class="form-group">
      <button type="submit" class="btn btn-danger mt-4 text-right">{{__("Reserve Now")}}</button>
    </div>

  </form>
</div>

</a>
<div id="policyModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2>Policy and Privacy</h2>
      <span class="modal-close">&times;</span>
    </div>
    <div class="modal-body">
      <h3><b>TERMS & CONDITIONS OF SERVICE AGREEMENT</b></h3><br>
      <p>LAST REVISION: [10-2-2023]</p><br>
      <p>PLEASE READ THIS TERMS OF SERVICE AGREEMENT CAREFULLY. BY USING THIS WEBSITE OR ORDERING PRODUCTS FROM THIS WEBSITE YOU AGREE TO BE BOUND BY ALL OF THE TERMS AND CONDITIONS OF THIS AGREEMENT.</p><br>
      <p>This Terms of Service Agreement (the "Agreement") governs your use of this website, <b>minemenu.com</b> (the "Website"), <b>MINE MENU</b>("Business Name") offer of products for purchase on this Website, or your purchase of products available on this Website. This Agreement includes, and incorporates by this reference, the policies and guidelines referenced below. <b>MINE MENU</b> reserves the right to change or revise the terms and conditions of this Agreement at any time by posting any changes or a revised Agreement on this Website. <b>MINE MENU</b> will alert you that changes or revisions have been made by indicating on the top of this Agreement the date it was last revised. The changed or revised Agreement will be effective immediately after it is posted on this Website. Your use of the Website following the posting any such changes or of a revised Agreement will constitute your acceptance of any such changes or revisions. <b>MINE MENU</b> encourages you to review this Agreement whenever you visit the Website to make sure that you understand the terms and conditions governing use of the Website. This Agreement does not alter in any way the terms or conditions of any other written agreement you may have with <b>MINE MENU</b> for other products or services. If you do not agree to this Agreement (including any referenced policies or guidelines), please immediately terminate your use of the Website.</p><br>
      <br>
      <h3><b>I. PRODUCTS</b></h3><br>
      <p>Terms of Offer. This Website offers for sale certain products (the <b>Digital Restaurant’s, Bars, Coffee Shop and Market’s Menu</b>). By placing an order for Products through this Website, you agree to the terms set forth in this Agreement. </p><br>
      <p><b>Customer Solicitation: </b> Unless you notify our third-party call center reps or direct <b>MINE MENU</b> sales reps, while they are calling you, of your desire to opt out from further direct company communications and solicitations, you are agreeing to continue to receive further emails and call solicitations <b>MINE MENU</b> and it’s designated in house or third-party call team(s).</p><br>
      <p><b>Opt Out Procedure:</b> We provide 3 easy ways to opt out of from future solicitations.<br>1. You may use the opt out link found in any email solicitation that you may receive.<br>2. You may also choose to opt out, via sending your email address to: <a href="https://minemenu.com/contact">https://minemenu.com/contact</a>.<br> 3. You may send a written remove request to <a href="mailto:support@minemenu.com">support@minemenu.com</a></p><br>
      <br>
      <h3><b>II. WEBSITE</b></h3><br>
      <p>Content; Intellectual Property; Third Party Links. In addition to making Products available, this Website also offers information and marketing materials. This Website also offers information, both directly and through indirect links to third-party websites, about nutritional and dietary supplements. <b>MINE MENU</b> does not always create the information offered on this Website; instead, the information is often gathered from other sources. To the extent that <b>MINE MENU</b> does create the content on this Website, such content is protected by intellectual property laws of the <em>IRAQ</em>, foreign nations, and international bodies. Unauthorized use of the material may violate copyright, trademark, and/or other laws. You acknowledge that your use of the content on this Website is for personal, noncommercial use. Any links to third-party websites are provided solely as a convenience to you. <b>MINE MENU</b> does not endorse the contents on any such third-party websites. <b>MINE MENU</b> is not responsible for the content of or any damage that may result from your access to or reliance on these third-party websites. If you link to third-party websites, you do so at your own risk.</p><br>
      <p>Use of Website; <b>MINE MENU</b> is not responsible for any damages resulting from use of this website by anyone. You will not use the Website for illegal purposes. You will (1) abide by all applicable local, state, national, and international laws and regulations in your use of the Website (including laws regarding intellectual property), (2) not interfere with or disrupt the use and enjoyment of the Website by other users, (3) not resell material on the Website, (4) not engage, directly or indirectly, in transmission of "spam", chain letters, junk mail or any other type of unsolicited communication, and (5) not defame, harass, abuse, or disrupt other users of the Website</p><br>
      <p>License. By using this Website, you are granted a limited, non-exclusive, non-transferable right to use the content and materials on the Website in connection with your normal, noncommercial, use of the Website. You may not copy, reproduce, transmit, distribute, or create derivative works of such content or information without express written authorization from <b>MINE MENU</b> or the applicable third party (if third party content is at issue).Posting. By posting, storing, or transmitting any content on the Website, you hereby grant <b>MINE MENU</b> a perpetual, worldwide, non-exclusive, royalty-free, assignable, right and license to use, copy, display, perform, create derivative works from, distribute, have distributed, transmit and assign such content in any form, in all media now known or hereinafter created, anywhere in the world. <b>MINE MENU</b> does not have the ability to control the nature of the user-generated content offered through the Website. You are solely responsible for your interactions with other users of the Website and any content you post. <b>MINE MENU</b> is not liable for any damage or harm resulting from any posts by or interactions between users. <b>MINE MENU</b> reserves the right, but has no obligation, to monitor interactions between and among users of the Website and to remove any content <b>MINE MENU</b> deems objectionable, in Muscle UP Nutrition 's sole discretion.</p><br>
      <br>
      <h3><b>III. DISCLAIMER OF WARRANTIES</b></h3><br>
      <p>YOUR USE OF THIS WEBSITE AND/OR PRODUCTS ARE AT YOUR SOLE RISK. THE WEBSITE AND PRODUCTS ARE OFFERED ON AN <b>"AS IS" AND "AS AVAILABLE"</b> BASIS. <b>MINE MENU</b> EXPRESSLY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT WITH RESPECT TO THE PRODUCTS OR WEBSITE CONTENT, OR ANY RELIANCE UPON OR USE OF THE WEBSITE CONTENT OR PRODUCTS. ("PRODUCTS" INCLUDE TRIAL PRODUCTS.)</p><br>
      <p>WITHOUT LIMITING THE GENERALITY OF THE FOREGOING, <b>MINE MENU</b> MAKES NO WARRANTY:</p><br>
      <p>THAT THE INFORMATION PROVIDED ON THIS WEBSITE IS ACCURATE, RELIABLE, COMPLETE, OR TIMELY.</p><br>
      <p>THAT THE LINKS TO THIRD-PARTY WEBSITES ARE TO INFORMATION THAT IS ACCURATE, RELIABLE, COMPLETE, OR TIMELY.</p><br>
      <p>NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED BY YOU FROM THIS WEBSITE WILL CREATE ANY WARRANTY NOT EXPRESSLY STATED HEREIN.</p><br>
      <p>AS TO THE RESULTS THAT MAY BE OBTAINED FROM THE USE OF THE PRODUCTS OR THAT DEFECTS IN PRODUCTS WILL BE CORRECTED.</p><br>
      <p>REGARDING ANY PRODUCTS PURCHASED OR OBTAINED THROUGH THE WEBSITE.</p><br>
      <p>SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF CERTAIN WARRANTIES, SO SOME OF THE ABOVE EXCLUSIONS MAY NOT APPLY TO YOU.</p><br>
      <br>
      <h3><b>IV. LIMITATION OF LIABILITY</b></h3><br>
      <p><b>MINE MENU</b> ENTIRE LIABILITY, AND YOUR EXCLUSIVE REMEDY, IN LAW, IN EQUITY, OR OTHWERWISE, WITH RESPECT TO THE WEBSITE CONTENT AND PRODUCTS AND/OR FOR ANY BREACH OF THIS AGREEMENT IS SOLELY LIMITED TO THE AMOUNT YOU PAID, LESS SHIPPING AND HANDLING, FOR PRODUCTS PURCHASED VIA THE WEBSITE.</p><br>
      <p><b>MINE MENU</b> WILL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES IN CONNECTION WITH THIS AGREEMENT OR THE PRODUCTS IN ANY MANNER, INCLUDING LIABILITIES RESULTING FROM (1) THE USE OR THE INABILITY TO USE THE WEBSITE CONTENT OR PRODUCTS; (2) THE COST OF PROCURING SUBSTITUTE PRODUCTS OR CONTENT; (3) ANY PRODUCTS PURCHASED OR OBTAINED OR TRANSACTIONS ENTERED INTO THROUGH THE WEBSITE; OR (4) ANY LOST PROFITS YOU ALLEGE.</p><br>
      <p>SOME JURISDICTIONS DO NOT ALLOW THE LIMITATION OR EXCLUSION OF LIABILITY FOR INCIDENTAL OR CONSEQUENTIAL DAMAGES SO SOME OF THE ABOVE LIMITATIONS MAY NOT APPLY TO YOU.</p><br>
      <br>
      <h3><b>V. INDEMNIFICATION</b></h3><br>
      <p>You will release, indemnify, defend and hold harmless <b>MINE MENU</b>, and any of its contractors, agents, employees, officers, directors, shareholders, affiliates and assigns from all liabilities, claims, damages, costs and expenses, including reasonable attorneys' fees and expenses, of third parties relating to or arising out of (1) this Agreement or the breach of your warranties, representations and obligations under this Agreement; (2) the Website content or your use of the Website content; (3) the Products or your use of the Products (including Trial Products); (4) any intellectual property or other proprietary right of any person or entity; (5) your violation of any provision of this Agreement; or (6) any information or data you supplied to <b>MINE MENU</b>. When <b>MINE MENU</b> is threatened with suit or sued by a third party, <b>MINE MENU</b> may seek written assurances from you concerning your promise to indemnify <b>MINE MENU</b>; your failure to provide such assurances may be considered by <b>MINE MENU</b> to be a material breach of this Agreement. <b>MINE MENU</b> will have the right to participate in any defense by you of a third-party claim related to your use of any of the Website content or Products, with counsel of <b>MINE MENU</b> choice at its expense. <b>MINE MENU</b> will reasonably cooperate in any defense by you of a third-party claim at your request and expense. You will have sole responsibility to defend <b>MINE MENU</b> against any claim, but you must receive <b>MINE MENU</b> prior written consent regarding any related settlement. The terms of this provision will survive any termination or cancellation of this Agreement or your use of the Website or Products.</p><br>
      <br>
      <h3><b>VI. PRIVACY</b></h3><br>
      <p><b>MINE MENU</b> believes strongly in protecting user privacy and providing you with notice of MuscleUP Nutrition 's use of data. Please refer to <b>MINE MENU</b> privacy policy, incorporated by reference herein, that is posted on the Website.</p><br>
      <br>
      <h3><b>VII. AGREEMENT TO BE BOUND</b></h3><br>
      <p>By using this Website or ordering Products, you acknowledge that you have read and agree to be bound by this Agreement and all terms and conditions on this Website. </p><br>
      <br>
      <h3><b>VIII. GENERAL</b></h3><br>
      <p>Force Majeure. <b>MINE MENU</b> will not be deemed in default hereunder or held responsible for any cessation, interruption or delay in the performance of its obligations hereunder due to earthquake, flood, fire, storm, natural disaster, act of God, war, terrorism, armed conflict, labor strike, lockout, or boycott.</p><br>
      <p>Cessation of Operation. <b>MINE MENU</b> may at any time, in its sole discretion and without advance notice to you, cease operation of the Website and distribution of the Products</p><br>
      <p>Entire Agreement. This Agreement comprises the entire agreement between you and <b>MINE MENU</b> and supersedes any prior agreements pertaining to the subject matter contained herein.</p><br>
      <p>Effect of Waiver. The failure of <b>MINE MENU</b> to exercise or enforce any right or provision of this Agreement will not constitute a waiver of such right or provision. If any provision of this Agreement is found by a court of competent jurisdiction to be invalid, the parties nevertheless agree that the court should endeavor to give effect to the parties' intentions as reflected in the provision, and the other provisions of this Agreement remain in full force and effect.</p><br>
      <p>Governing Law; <em>IRAQ – KURSIDTAN</em> This Website originates from the Erbil. This Agreement will be governed by the laws of the Country of Law’s without regard to its conflict of law principles to the contrary. Neither you nor <b>MINE MENU</b> will commence or prosecute any suit, proceeding or claim to enforce the provisions of this Agreement, to recover damages for breach of or default of this Agreement, or otherwise arising under or by reason of this Agreement, other than in courts located in Country of Iraq, By using this Website or ordering Products, you consent to the jurisdiction and venue of such courts in connection with any action, suit, proceeding or claim arising under or by reason of this Agreement. You hereby waive any right to trial by jury arising out of this Agreement and any related documents.</p><br>
      <p>Statute of Limitation. You agree that regardless of any statute or law to the contrary, any claim or cause of action arising out of or related to use of the Website or Products or this Agreement must be filed within one (1) year after such claim or cause of action arose or be forever barred.</p><br>
      <br>
      <p>Waiver of Class Action Rights. BY ENTERING INTO THIS AGREEMENT, YOU HEREBY IRREVOCABLY WAIVE ANY RIGHT YOU MAY HAVE TO JOIN CLAIMS WITH THOSE OF OTHER IN THE FORM OF A CLASS ACTION OR SIMILAR PROCEDURAL DEVICE. ANY CLAIMS ARISING OUT OF, RELATING TO, OR CONNECTION WITH THIS AGREEMENT MUST BE ASSERTED INDIVIDUALLY.</p><br>
      <br>
      <p>Termination. <b>MINE MENU</b> reserves the right to terminate your access to the Website if it reasonably believes, in its sole discretion, that you have breached any of the terms and conditions of this Agreement. Following termination, you will not be permitted to use the Website and <b>MINE MENU</b> may, in its sole discretion and without advance notice to you, cancel any outstanding orders for Products. If your access to the Website is terminated, <b>MINE MENU</b> reserves the right to exercise whatever means it deems necessary to prevent unauthorized access of the Website. This Agreement will survive indefinitely unless and until <b>MINE MENU</b> chooses, in its sole discretion and without advance to you, to terminate it.</p><br>
      <p>Domestic Use. <b>MINE MENU</b> makes no representation that the Website or Products are appropriate or available for use in locations outside India. Users who access the Website from outside India do so at their own risk and initiative and must bear all responsibility for compliance with any applicable local laws. Assignment. You may not assign your rights and obligations under this Agreement to anyone. <b>MINE MENU</b> may assign its rights and obligations under this Agreement in its sole discretion and without advance notice to you.</p><br>
      <p>BY USING THIS WEBSITE OR ORDERING PRODUCTS FROM THIS WEBSITE YOU AGREE  TO BE BOUND BY ALL OF THE TERMS AND CONDITIONS OF THIS AGREEMENT</p><br>
    </div>
    <div class="modal-footer">
      <button type="button" id="acceptBtn" class="btn btn-danger">Accept</button>
      <button type="button" id="declineBtn" class="btn btn-info">Decline</button>
    </div>
  </div>
</div>

<div class="marg"></div>
<div class="marg"></div>

@endsection


@section('main_script')


<script>
  document.getElementById("myForm").addEventListener("submit", function(event) {
  event.preventDefault();
  document.getElementById("policyModal").style.display = "block";
});

document.getElementById("acceptBtn").addEventListener("click", function() {
  document.getElementById("policyModal").style.display = "none";
  // submit the form
  document.getElementById("myForm").submit();
});

document.getElementById("declineBtn").addEventListener("click", function() {
  document.getElementById("policyModal").style.display = "none";
});

document.getElementsByClassName("modal-close")[0].addEventListener("click", function() {
  document.getElementById("policyModal").style.display = "none";
});

</script>

<script>
jQuery(function($) {
  var requiredCheckboxes = $(':checkbox[required]');
  requiredCheckboxes.on('change', function(e) {
    var checkboxGroup = requiredCheckboxes.filter('[name="' + $(this).attr('name') + '"]');
    var isChecked = checkboxGroup.is(':checked');
    checkboxGroup.prop('required', !isChecked);
  });
  requiredCheckboxes.trigger('change');
});
</script>


{{-- <script src="{{asset('assets/general/lib/teleSelect/intlTelInput.min.js')}}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

<script>
  var input = document.querySelector("#inputPhone");
  window.intlTelInput(input, {
    // allowDropdown: false,
    // autoHideDialCode: false,
    // autoPlaceholder: "off",
    // dropdownContainer: document.body,
    // excludeCountries: ["us"],
    // formatOnDisplay: false,
    // geoIpLookup: function(callback) {
    //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
    //     var countryCode = (resp && resp.country) ? resp.country : "";
    //     callback(countryCode);
    //   });
    // },
    // hiddenInput: "phone",
    // initialCountry: "auto",
    // localizedCountries: { 'de': 'Deutschland' },
    // nationalMode: false,
    // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do','sa','iq'],
    placeholderNumberType: "MOBILE",
    preferredCountries: ['iq','sa','kw','ae','lb','eg'],
    // separateDialCode: true,
    // utilsScript: "{{asset('assets/general/lib/teleSelect/utils.js')}}",
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
  });
</script>


{{-- <script src="/assets/dashboard/assets/libs/country_select/countrySelect.min.js"></script> --}}
<script src="{{asset('assets/general/lib/country_select/countrySelect.min.js')}}"></script>
<script>
  $("#country_selector").countrySelect({
    // defaultCountry: "iq",
    // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
    // responsiveDropdown: true,
    preferredCountries: ['iq', 'sa', 'ae']
  });
</script>


@endsection

