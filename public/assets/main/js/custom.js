function selectLang(val){
 window.location = '/change-language/'+val
}


$(function () {
    $(".mySelect").each(function () {
      $(this).hide();
      var $select = $(this);
      var _id = $(this).attr("id");
      var wrapper = document.createElement("div");
      wrapper.setAttribute("class", "mySelect mySelect_" + _id);
      wrapper.setAttribute("style", "color: var(--title-color)");
  
      var input = document.createElement("input");
      input.setAttribute("type", "text");
      input.setAttribute("class", "mySelect-input");
      input.setAttribute("id", "mySelect_" + _id);
      input.setAttribute("readonly", "readonly");
      input.setAttribute("style", "color: var(--title-color)");
      input.setAttribute(
        "placeholder",
        $(this)[0].options[$(this)[0].selectedIndex].innerText
      );
  
      $(this).before(wrapper);
      var $mySelect = $(".mySelect_" + _id);
      $mySelect.append(input);
      $mySelect.append("<div class='mySelect-options mySelect-options-" + _id + "'></div>");
      var $mySelect_input = $("#mySelect_" + _id);
      var $ops_list = $(".mySelect-options-" + _id);
      var $ops = $(this)[0].options;
      for (var i = 0; i < $ops.length; i++) {
        $ops_list.append(
          "<div data-value='" +
            $ops[i].value +
            "'>" +
            $ops[i].innerText +
            "</div>"
        );
      }
  
      $mySelect_input.click(function () {
        $mySelect.toggleClass("active");
      });
      $mySelect_input.blur(function () {
        $mySelect.removeClass("active");
      });
      $ops_list.find("div").click(function () {
        $select.val($(this).data("value")).trigger("change");
        $mySelect_input.val($(this).text());
        $mySelect.removeClass("active");
      });
    });
  });

//Modal Slide
  var modal = document.getElementsByClassName("modaladdingcart")[0];

  function showmodal() {
    modal.style.bottom = "0px";
    hidecart()
  }

  // function hidemodal() {
  //   modal.style.bottom = "-800px";
    
  // }
//Cart Slide
  var modalcart = document.getElementsByClassName("modalchekingcart")[0];

  function showcart() {
    modalcart.style.left = "50%";
  // hidemodal()
  }
  function hidecart() {
    modalcart.style.left = "500%";
  }


//number
let decrement = document.querySelectorAll('.minus');
let increment = document.querySelectorAll('.plus');
let numbers = document.querySelectorAll('.num');

for (let i = 0; i < numbers.length; i++) {
  let number = numbers[i];
  let decrementBtn = decrement[i];
  let incrementBtn = increment[i];
  let num = 0;

  number.textContent = '00';
  incrementBtn.addEventListener('click', () => {
    num++;
    num = num < 10 ? '0' + num : num;
    number.textContent = num;
  });

  decrementBtn.addEventListener('click', () => {
    if (num > 0) {
      num--;
      num = num < 10 ? '0' + num : num;
    }
    number.textContent = num;
  });
}

//ALERT FOR ADDING, REMOVING AND ERR_MSG CART
function createAlert(title, summary, details, severity, dismissible, autoDismiss, appendToId) {

  var alertClasses = ["alert", "animated", "flipInX"];
  alertClasses.push("alert-" + severity.toLowerCase());

  if (dismissible) {
    alertClasses.push("alert-dismissible");
  }

  var msg = $("<div />", {
    "class": alertClasses.join(" ") // you need to quote "class" since it's a reserved keyword
  });

  if (title) {
    var msgTitle = $("<h4 />", {
      html: title
    }).appendTo(msg);
  }

  if (summary) {
    var msgSummary = $("<strong />", {
      html: summary
    }).appendTo(msg);
  }

  if (details) {
    var msgDetails = $("<p />", {
      html: details
    }).appendTo(msg);
  }
  
  if (dismissible) {
    var msgClose = $("<span />", {
      "class": "close", // you need to quote "class" since it's a reserved keyword
      "data-dismiss": "alert",
      html: "<i class='fa fa-times-circle'></i>"
    }).appendTo(msg);
  }
  
  $('#' + appendToId).prepend(msg);
  
  if(autoDismiss){
    setTimeout(function(){
      msg.addClass("flipOutX");
      setTimeout(function(){
        msg.remove();
      },500);
    },1000);
  }
}