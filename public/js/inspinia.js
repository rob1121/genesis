/*
 *
 *   INSPINIA - Responsive Admin Theme
 *   version 2.4
 *
 */

$(document).ready(function() {
  // Add body-small class if window less than 768px
  if ($(this).width() < 769) {
    $("body").addClass("body-small");
  } else {
    $("body").removeClass("body-small");
  }

  // MetsiMenu
  $("#side-menu").metisMenu();

  // Collapse ibox function
  $(".collapse-link").click(function() {
    var ibox = $(this).closest("div.ibox");
    var button = $(this).find("i");
    var content = ibox.find("div.ibox-content");
    content.slideToggle(200);
    button.toggleClass("fa-chevron-up").toggleClass("fa-chevron-down");
    ibox.toggleClass("").toggleClass("border-bottom");
    setTimeout(function() {
      ibox.resize();
      ibox.find("[id^=map-]").resize();
    }, 50);
  });

  // Close ibox function
  $(".close-link").click(function() {
    var content = $(this).closest("div.ibox");
    content.remove();
  });

  // Fullscreen ibox function
  $(".fullscreen-link").click(function() {
    var ibox = $(this).closest("div.ibox");
    var button = $(this).find("i");
    $("body").toggleClass("fullscreen-ibox-mode");
    button.toggleClass("fa-expand").toggleClass("fa-compress");
    ibox.toggleClass("fullscreen");
    setTimeout(function() {
      $(window).trigger("resize");
    }, 100);
  });

  // Close menu in canvas mode
  $(".close-canvas-menu").click(function() {
    $("body").toggleClass("mini-navbar");
    SmoothlyMenu();
  });

  // Run menu of canvas
  $("body.canvas-menu .sidebar-collapse").slimScroll({
    height: "100%",
    railOpacity: 0.9
  });

  // Open close right sidebar
  $(".right-sidebar-toggle").click(function() {
    $("#right-sidebar").toggleClass("sidebar-open");
  });

  // Initialize slimscroll for right sidebar
  $(".sidebar-container").slimScroll({
    height: "100%",
    railOpacity: 0.4,
    wheelStep: 10
  });

  // Open close small chat
  $(".open-small-chat").click(function() {
    $(this).children().toggleClass("fa-comments").toggleClass("fa-remove");
    $(".small-chat-box").toggleClass("active");
  });

  // Initialize slimscroll for small chat
  $(".small-chat-box .content").slimScroll({
    height: "234px",
    railOpacity: 0.4
  });

  // Small todo handler
  $(".check-link").click(function() {
    var button = $(this).find("i");
    var label = $(this).next("span");
    button.toggleClass("fa-check-square").toggleClass("fa-square-o");
    label.toggleClass("todo-completed");
    return false;
  });

  // Append config box / Only for demo purpose
  // Uncomment on server mode to enable XHR calls
  //$.get("skin-config.html", function (data) {
  //    if (!$('body').hasClass('no-skin-config'))
  //        $('body').append(data);
  //});

  // Minimalize menu
  $(".navbar-minimalize").click(function() {
    $("body").toggleClass("mini-navbar");
    SmoothlyMenu();
  });

  // Tooltips demo
  $(".tooltip-demo").tooltip({
    selector: "[data-toggle=tooltip]",
    container: "body"
  });

  // Move modal to body
  // Fix Bootstrap backdrop issu with animation.css
  $(".modal").appendTo("body");

  // Full height of sidebar
  function fix_height() {
    var heightWithoutNavbar = $("body > #wrapper").height() - 61;
    $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");

    var navbarHeigh = $("nav.navbar-default").height();
    var wrapperHeigh = $("#page-wrapper").height();

    if (navbarHeigh > wrapperHeigh) {
      $("#page-wrapper").css("min-height", navbarHeigh + "px");
    }

    if (navbarHeigh < wrapperHeigh) {
      $("#page-wrapper").css("min-height", $(window).height() + "px");
    }

    if ($("body").hasClass("fixed-nav")) {
      if (navbarHeigh > wrapperHeigh) {
        $("#page-wrapper").css("min-height", navbarHeigh - 60 + "px");
      } else {
        $("#page-wrapper").css("min-height", $(window).height() - 60 + "px");
      }
    }
  }

  fix_height();

  // Fixed Sidebar
  $(window).bind("load", function() {
    if ($("body").hasClass("fixed-sidebar")) {
      $(".sidebar-collapse").slimScroll({
        height: "100%",
        railOpacity: 0.9
      });
    }
  });

  // Move right sidebar top after scroll
  $(window).scroll(function() {
    if ($(window).scrollTop() > 0 && !$("body").hasClass("fixed-nav")) {
      $("#right-sidebar").addClass("sidebar-top");
    } else {
      $("#right-sidebar").removeClass("sidebar-top");
    }
  });

  $(window).bind("load resize scroll", function() {
    if (!$("body").hasClass("body-small")) {
      fix_height();
    }
  });

  $("[data-toggle=popover]").popover();

  // Add slimscroll to element
  $(".full-height-scroll").slimscroll({
    height: "100%"
  });
});

// Minimalize menu when screen is less than 768px
$(window).bind("resize", function() {
  if ($(this).width() < 769) {
    $("body").addClass("body-small");
  } else {
    $("body").removeClass("body-small");
  }
});

// Local Storage functions
// Set proper body class and plugins based on user configuration
$(document).ready(function() {
  if (localStorageSupport) {
    var collapse = localStorage.getItem("collapse_menu");
    var fixedsidebar = localStorage.getItem("fixedsidebar");
    var fixednavbar = localStorage.getItem("fixednavbar");
    var boxedlayout = localStorage.getItem("boxedlayout");
    var fixedfooter = localStorage.getItem("fixedfooter");

    var body = $("body");

    if (fixedsidebar == "on") {
      body.addClass("fixed-sidebar");
      $(".sidebar-collapse").slimScroll({
        height: "100%",
        railOpacity: 0.9
      });
    }

    if (collapse == "on") {
      if (body.hasClass("fixed-sidebar")) {
        if (!body.hasClass("body-small")) {
          body.addClass("mini-navbar");
        }
      } else {
        if (!body.hasClass("body-small")) {
          body.addClass("mini-navbar");
        }
      }
    }

    if (fixednavbar == "on") {
      $(".navbar-static-top")
        .removeClass("navbar-static-top")
        .addClass("navbar-fixed-top");
      body.addClass("fixed-nav");
    }

    if (boxedlayout == "on") {
      body.addClass("boxed-layout");
    }

    if (fixedfooter == "on") {
      $(".footer").addClass("fixed");
    }
  }

  var contact_type_phone = $("#contact_type_phone");
  var contact_list_value = $("#contact_list_value");
  var contact_list_country_code = $("#contact_list_country_code");
  var contact_list_number = $("#contact_list_number");

  $("#contact_list_type").on("change", function() {
    if ($(this).val() === "phone") {
      contact_type_phone.show();
      contact_list_value.hide();
    } else {
      contact_type_phone.hide();
      contact_list_value.show();
    }
  });

  contact_list_country_code.on("change", function() {
    contact_list_value.val($(this).val() + contact_list_number.val());
  });

  contact_list_number.on("change", function() {
    contact_list_value.val(contact_list_country_code.val() + $(this).val());
  });

  var audoRingback = document.getElementById("ringback");
  var audoIncoming = document.getElementById("incoming");
  var callStatus = $("#call-status");

  var callListeners = {
    onCallProgressing: function(call) {
      callStatus.text("call in progress...");
      audoRingback.currentTime = 0; // Ensure ringback start from beginning
      audoRingback.play(); // Play ringback when call is progressing
    },
    onCallEstablished: function(call) {
      callStatus.text("call established...");
      audoRingback.pause(); // End ringback
      audoIncoming.src = call.incomingStreamURL; // Connect incoming stream to audio element
    },
    onCallEnded: function(call) {
      callStatus.text("call ended...");
      audoRingback.pause(); // End the ringback
      audoIncoming.src = ""; // Ensure no incoming stream is playing
      // Optional: Enable user interface to make another call
    }
  };
  var sinchCall = function(callNumber) {
    var sinchClient = new SinchClient({
      applicationKey: "3b8a048c-5f2b-41b7-af0c-afdac1b7c6ff",
      capabilities: { calling: true },
      supportActiveConnection: true
    });

    var handleSuccess = function() {
      console.log("login success");
      var callClient = sinchClient.getCallClient();
      var call = callClient.callPhoneNumber("+" + callNumber);
      call.addEventListener(callListeners);

      $("#call-hangup").on("click", function() {
        call.hangup();
        location.reload();
      });
    };

    var handleFail = function() {
      console.log(callNumber);
      console.log("login failed");
    };

    var signUpObject = {
      username: "robinson",
      password: "callcenter"
    };

    sinchClient.start(signUpObject, handleSuccess, handleFail);
  };

  $("#custom-call-phone").on("click", function(e) {
    e.preventDefault();
    var callNumber =
      $("#custom_country_code").val() + $("#custom_number").val();

    sinchCall(callNumber);
  });

  $("#call-phone").on("click", function(e) {
    e.preventDefault();
    var callNumber = $(this).data("number");

    sinchCall(callNumber);
  });
});

// check if browser support HTML5 local storage
function localStorageSupport() {
  return "localStorage" in window && window["localStorage"] !== null;
}

// For demo purpose - animation css script
function animationHover(element, animation) {
  element = $(element);
  element.hover(
    function() {
      element.addClass("animated " + animation);
    },
    function() {
      //wait for animation to finish before removing classes
      window.setTimeout(function() {
        element.removeClass("animated " + animation);
      }, 2000);
    }
  );
}

function SmoothlyMenu() {
  if (!$("body").hasClass("mini-navbar") || $("body").hasClass("body-small")) {
    // Hide menu in order to smoothly turn on when maximize menu
    $("#side-menu").hide();
    // For smoothly turn on menu
    setTimeout(function() {
      $("#side-menu").fadeIn(400);
    }, 200);
  } else if ($("body").hasClass("fixed-sidebar")) {
    $("#side-menu").hide();
    setTimeout(function() {
      $("#side-menu").fadeIn(400);
    }, 100);
  } else {
    // Remove all inline style from jquery fadeIn function to reset menu state
    $("#side-menu").removeAttr("style");
  }
}

// Dragable panels
function WinMove() {
  var element = "[class*=col]";
  var handle = ".ibox-title";
  var connect = "[class*=col]";
  $(element)
    .sortable({
      handle: handle,
      connectWith: connect,
      tolerance: "pointer",
      forcePlaceholderSize: true,
      opacity: 0.8
    })
    .disableSelection();
}
