
$(document).ready(function () {
//   $(".link-btns").click(function(){
//     $("html").addClass("fix-html");

// });

  // Sevices icons slider
  let b = window.Laravel.base;
  $(".services-icon-slider-mobile").slick({
    infinite: true,
    dots: false,
    autoplay: false,
    aautoplaySpeed: 1000,
    // speed: 1500,
    slidesToShow: 4,
    slidesToScroll: 1,
    // rows:2,
    prevArrow: `<div class="slick-prev arrows arrow-left-main"><img src="${b}assets/front/img/left-icon.png" class="img-fluid arrow-left"></div>`,
    nextArrow: `<div class="slick-next arrows arrow-right-main"><img src="${b}assets/front/img/right-icon.png" class="img-fluid arrow-right"></div>`,
    arrows: true,
    responsive: [
      {
        breakpoint: 1191,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 450,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      },
    ]
  });

  $(".supplier-slider").slick({
    infinite: true,
    dots: false,
    autoplay: false,
    aautoplaySpeed: 1000,
    // speed: 1500,
    slidesToShow: 4,
    slidesToScroll: 1,
    rows: 2,
    prevArrow: `<div class="slick-prev arrows arrow-left-main"><img src="${b}assets/front/img/left-icon.png" class="img-fluid arrow-left"></div>`,
    nextArrow: `<div class="slick-next arrows arrow-right-main"><img src="${b}assets/front/img/right-icon.png" class="img-fluid arrow-right"></div>`,
    arrows: true,
    responsive: [
      {
        breakpoint: 1191,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          rows: 2
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          rows: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 450,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      },
    ]
  });

  // services slider
  $(".offer-slider").slick({
    infinite: true,
    dots: false,
    autoplay: true,
    aautoplaySpeed: 1000,
    // speed: 1500,
    slidesToShow: 1,
    slidesToScroll: 1,

  });

  $(".services-slider").slick({
    infinite: true,
    dots: false,
    autoplay: false,
    aautoplaySpeed: 1000,
    slidesToShow: 3,
    slidesToScroll: 1,
    rows: 2,
    prevArrow: `<div class="slick-prev arrows arrow-left-main"><img src="${b}assets/front/img/left-icon.png" class="img-fluid arrow-left"></div>`,
    nextArrow: `<div class="slick-next arrows arrow-right-main"><img src="${b}assets/front/img/right-icon.png" class="img-fluid arrow-right"></div>`,
    arrows: true,
    responsive: [
      {
        breakpoint: 1191,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 455,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      },
    ]
  });
  $('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.slider-nav'
  });
  $('.slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
    focusOnSelect: true,
    prevArrow: `<div class="slick-prev arrows arrow-left-main"><img src="${b}assets/front/img/left-slide-icon.png" class="img-fluid arrow-left"></div>`,
    nextArrow: `<div class="slick-next arrows arrow-right-main"><img src="${b}assets/front/img/right-slide-icon.png" class="img-fluid arrow-right"></div>`,
  });
});

// mobile menu js

function openNav() {
  document.getElementById("mySidenav").style.transform = "translateX(-10%)";
  document.body.style.overflow = "hidden";
}

function closeNav() {
  document.getElementById("mySidenav").style.transform = "translateX(-110%)";
  document.body.style.overflow = "auto";
}

if ($("body").hasClass("rtl")) {
  function openNav() {
    document.getElementById("mySidenav").style.transform = "translateX(10%)";
    document.body.style.overflow = "hidden";
  }
  function closeNav() {
    document.getElementById("mySidenav").style.transform = "translateX(110%)";
    document.body.style.overflow = "auto";
  }
}

// rating stars js

$("body").on('click', '.xyz', function () {
  $(this).prev().prop("checked", true);
  that.form.form.patchValue({ rating: $(this).prev().val() }, { emitEvent: true, onlySelf: false });
  mtValidationBuilder.controlValueChanged('rating', $(this).prev().val());
});

// In your Javascript (external .js resource or <script> tag)
$(document).ready(function () {
  $('.js-example-basic-single').select2();
});

$(document).ready(function () {
  $(".submit-reviews-block").hide();
  $(".rate-link").click(function () {
    $(this).hide();
    $(this).siblings(".submit-reviews-block").show();
  });

});
function addMinutes(numOfMinutes, date = new Date()) {
  date.setMinutes(date.getMinutes() + numOfMinutes);

  return date;
}
$('#tim').timepicker({});
$(document).ready(function () {
  $("#datepicker").on(`change`, function () {
    $("#tim").timepicker('destroy');
    let date = $(this).val();
    let today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = dd + '/' + mm + '/' + yyyy;
    console.log(date)

    if (date != today) {
      $('#tim').timepicker({});

    } else {
      console.log('235464')

      $('#tim').timepicker({
        timeFormat: 'hh:mm p',
        interval: 30,
        minTime: addMinutes(1),
        maxTime: '11:59pm',
        defaultTime: addMinutes(1),
        startTime: addMinutes(1),
        dynamic: false,
        dropdown: true,
        scrollbar: true
      });
    }

  })
});


$(function () {
  $("#datepicker").datepicker({ dateFormat: 'dd/mm/yy', minDate: 0 });
});
$(function () {
  $("#datepicker1").datepicker({ dateFormat: 'dd-mm-yy', minDate: 0 });
});
$(window).on("scroll", function () {

  //     // for get window height
  let scrollTop = $(window).scrollTop();
  let myElement = document.getElementById('services-sec');
  let topPos = myElement.offsetTop;


  // console.log(scrollTop);
  if (scrollTop > topPos) {
    $("#how-work").addClass("run-animation");

  }
  else {
    $("#how-work").removeClass("run-animation");
  }

});

// active menu links

$(function () {
  $('.navbar-nav li a').each(function () {
    var isActive = this.pathname === location.pathname;
    $(this).toggleClass('active', isActive);
  });
});

// checkout page js

// const myErr = document.getElementById('error-show');
// const prevElement = document.getElementById('paymentMethod');  

// if(myErr.classList.contains('d-none')){    
//   prevElement.classList.remove("mb-3");    
//   prevElement.classList.add('mb-0'); 
//   console.log('d-none add');      
// }
// else {    
//   prevElement.classList.remove('mb-0');
//   prevElement.classList.add("mb-3");
//   console.log('d-none remove'); 
// }

// empty alert

const empMsg = document.querySelector('.empty-alert-col');
const row = empMsg.closest('div.row');

if (empMsg.parentNode == row) {
  empMsg.classList.remove('px-0');

}
else {
  empMsg.classList.add('px-0');
}

  // checkout error message





