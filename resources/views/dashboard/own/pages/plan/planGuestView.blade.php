@extends('dashboard.own.layouts.layout')
@section('tail','Dashboard')
@section('rest_content')
{{-- <style>
.price_plan_area {
  position: relative;
}

.single_price_plan {
  position: relative;
  z-index: 1;
  /* border-radius: 0.5rem 0.5rem 0 0; */
  border-radius: 0.5rem;
  -webkit-transition-duration: 500ms;
  transition-duration: 500ms;
  /* margin-bottom: 50px; */
  /* background-color: #ffffff; */
  padding: 1rem 1rem;
border: 1px solid #fff;

}

.price_plan_area i {
    color: #2ecc71
}

.single_price_plan:lang(ar){
direction: rtl;
  text-align: right;
}

.single_price_plan::after {
  position: absolute;
  content: "";
  /* background-image: url("https://bootdey.com/img/half-circle-pricing.png"); */
  background-repeat: repeat;
  width: 100%;
  height: 17px;
  bottom: -17px;
  z-index: 1;
  left: 0;
}

.single_price_plan .title {
  text-transform: capitalize;
  -webkit-transition-duration: 500ms;
  transition-duration: 500ms;
  margin-bottom: 0.5rem;
}
.single_price_plan .title span {
  color: #ffffff;
  padding: 0.2rem 0.6rem;
  font-size: 10px;
  text-transform: uppercase;
  background-color: #2ecc71;
  display: inline-block;
  margin-bottom: 0.5rem;
  border-radius: 0.25rem;
}
.single_price_plan .title h3 {
  font-size: 1.25rem;
}
.single_price_plan .title p {
  font-weight: 300;
  line-height: 1;
  font-size: 14px;
}
.single_price_plan .title .line {
  width: 80px;
  height: 4px;
  border-radius: 20px;
  background-color: #cc0033;
}
.single_price_plan .price {
  margin-bottom: 1.5rem;
}
.single_price_plan .price h4 {
  position: relative;
  z-index: 1;
  font-size: 2rem;
  /* line-height: 1; */
  margin-bottom: 0;
  display: inline-block;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-color: transparent;
  background-image: -webkit-gradient(linear, left top, right top, from(#ee0033), to(#ff0022));
  background-image: linear-gradient(90deg, #cc0022, #ff0055);
}

.single_price_plan .description {
  position: relative;
  margin-bottom: 1.5rem;
}
.bo-red{
border: 2px solid red ;
}
.bo-green{
border: 2px solid rgb(7, 104, 59) ;
}
.single_price_plan .description p {
  line-height: 16px;
  margin: 0;
  padding: 10px 0;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  -ms-grid-row-align: center;
  align-items: center;
}
.price_plan_area svg {
  color: #2ecc71;
  margin: 0 0.5rem;
}

.price_plan_area .button{
     background-color: none; 
}
.price_plan_area .button:hover{
     background-color: none; 
}
  
.single_price_plan p .lni-close {
  color: #e74c3c;
}
.single_price_plan.active,
.single_price_plan:hover,
.single_price_plan:focus {
  -webkit-box-shadow: 0 6px 50px 8px rgba(23, 255, 127, 0.15);
  box-shadow: 0 6px 50px 8px rgba(23, 255, 127, 0.15);
}
.single_price_plan .side-shape img {
  position: absolute;
  width: auto;
  top: 0;
  right: 0;
  z-index: -2;
}


.bestDeal{
font-size: 21px!important;
position: absolute; 
right: 10px;
background-color: #cc0022;
color: white;
border-radius: 8px;
border: 2px solid #810016;
}

.cPlan{
font-size: 21px!important;
position: absolute; 
right: 10px;
background-color: #36b9cc;
color: white;
border-radius: 6px;
border: 2px solid #227885;
font-weight: bold
}

[lang = "ar"] .bestDeal {
right: auto;
left: 10px;
}

.price_plan_area .badgeTag_currentplan{
  position:absolute;
  font-size: 16px!important;
  top:-15px;
  right: 1px; 
  max-height: 35px;
  width:110px;
  text-align:center;
  margin: 0;
  padding: 0;
}
.price_plan_area .badgeTag_bestDeal{
  position:absolute;
  font-size: 16px!important;
  top:-15px;
  left:1%; 
  max-height: 35px;
  width:100px;
  text-align:center;
  margin: 0;
  padding: 0;
}


@media only screen and (min-width: 992px) and (max-width: 1199px) {
  .single_price_plan {
      padding: 1rem;
  }
.bestDeal{
  font-size: 19px!important;
}
}
@media only screen and (max-width: 575px) {
  .single_price_plan {
      padding: 1rem;
  }
} --}}
</style>
<div>
    @livewire('owner.plans-guest-view-livewire')
</div>


@endsection