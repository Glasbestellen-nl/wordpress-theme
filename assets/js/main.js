"use strict";(function(a){Element.prototype.matches||(Element.prototype.matches=Element.prototype.msMatchesSelector||Element.prototype.webkitMatchesSelector),Element.prototype.closest||(Element.prototype.closest=function(a){var b=this;do{if(b.matches(a))return b;b=b.parentElement||b.parentNode}while(null!==b&&1===b.nodeType);return null}),window.NodeList&&!NodeList.prototype.forEach&&(NodeList.prototype.forEach=Array.prototype.forEach),Array.prototype.forEach||(Array.prototype.forEach=function(a,b){b=b||window;for(var c=0;c<this.length;c++)a.call(b,this[c],c,this)}),a.fn.isInViewport=function(){var b=a(this).offset().top,c=b+a(this).outerHeight(),d=a(window).scrollTop(),e=d+a(window).height();return c>d&&b<e},a.fn.scrollTo=function(b){b="undefined"==typeof b?-30:b,a("html, body").animate({scrollTop:a(this).offset().top+b},500)},a(".fancybox").fancybox({prevEffect:"none",nextEffect:"none"}),a(".fancybox-various").fancybox({maxWidth:800,maxHeight:600,fitToView:!1,width:"80%",height:"80%",autoSize:!0,closeClick:!1,openEffect:"none",closeEffect:"none"}),a(".js-side-nav-list-toggler").on("click",function(){var b=a(this).parent().find(".js-side-nav-list");b.toggleClass("d-none")}),a(".js-bricks").each(function(){var b=a(this);b.masonry({itemSelector:".js-brick"}),this.addEventListener("load",function update(){b.masonry({itemSelector:".js-brick"})},!0)}),a(window).on("scroll",function(){a(".js-hide-when").each(function(b,c){var d=a(c).data("hide-when");a(d).isInViewport()?a(c).hide():a(c).show()})}),a(".js-scroll-to").click(function(){var b=a(this).data("scroll-to");a(b).scrollTo(-10)}),function(){a.get(gb.ajaxUrl,{action:"get_cart_quantity"},function(b){0<b&&a(".js-total-cart-quantity").text(b).removeClass("d-none")})}(),function(){var a=document.querySelectorAll(".js-rotator");null!==a&&a.forEach(function(a){function b(){d||(c[e].classList.add("visible"),c.forEach(function(a){a!==c[e]&&a.classList.remove("visible")}),e++,e==c.length&&(e=0))}var c=a.querySelectorAll(".js-rotator-item"),d=!1,e=0;b(),setInterval(b,4e3),a.addEventListener("mouseenter",function(){d=!0}),a.addEventListener("mouseleave",function(){d=!1})})}(),function(){a(document).on("click",".js-nav-item-parent, .js-nav-subitem-link",function(a){a.stopPropagation()}).on("click","body",function(){a(".js-nav-item-parent").removeClass("open")}).on("click",".js-nav-item-parent",function(b){b.preventDefault(),a(this).toggleClass("open"),a(".js-nav-item-parent").not(this).removeClass("open")}).on("click",".js-nav-toggler",function(){a(this).toggleClass("open"),a(".js-nav-items").toggleClass("open")})}(),function(){function b(b){h=b>g?1:1>b?g:b;var c=a("[data-index=\""+h+"\"]",e),d=c.data("image"),i=c.attr("title");f.attr("src",d).parent("a").attr("href",d),f.parent("a").attr("title",i);c.parent().addClass("current").siblings().removeClass("current")}function c(){b(h+1)}function d(){b(h-1)}var e=a(".js-image-slider"),f=a(".js-main",e),g=a(".js-thumb img",e).length,h=1;e.on("click",".js-thumb img",function(){var c=a(this).data("index");b(c)}).on("click",".js-next",c).on("click",".js-prev",d)}(),document.addEventListener("click",function(a){if(a.target){if(a.target.closest(".js-collapse-box"))return void a.target.closest(".js-collapse-box").classList.toggle("open");if(a.target.closest(".js-close-modal")||a.target.matches(".js-modal"))return void hideModal();if(a.target.closest(".js-hide-target-trigger")){var b=a.target.dataset.hideTarget,c=document.querySelector(b);return c.classList.add("d-none"),void c.classList.remove("d-block")}if(a.target.closest(".js-show-target-trigger")){var d=a.target.dataset.showTarget,e=document.querySelector(d);return e.classList.add("d-block"),void e.classList.remove("d-none")}if(a.target.closest(".js-toggle-target-trigger")){var f=a.target.dataset.toggleTarget,g=document.querySelector(f);return g.classList.toggle("d-block"),void g.classList.toggle("d-none")}}}),a(".js-empty-dropdown").click(function(){var b=a(this).parents(".js-dropdown-group"),c=b.find(".js-dropdown");c.val("");var d=a(this).data("submit");d&&c.parents("form").submit()}),document.addEventListener("change",function(a){if(a.target){if(a.target.matches(".js-url-dropdown")){var b=a.target.selectedIndex,c=a.target.options[b].value;return void(c&&(window.location=c))}if(a.target.closest(".js-file-input-field")){var d=a.target.files.length;return void(a.target.parentNode.querySelector(".js-file-input-trigger-text").innerHTML=d+" "+gb.msg.filesSelected)}}}),document.addEventListener("submit",function(b){if(b.target&&b.target.matches(".js-form-validation")){b.preventDefault();var c=b.target;return void validateForm(c,function(b){var c=new FormData(b),d=b.querySelector(".js-form-action").value,e=jQuery("button[type=\"submit\"]",b),f=e.text();if(void 0!==d){c.append("action",d),c.append("nonce",gb.ajaxNonce),c.append("request_uri",gb.requestURI);var g=b.querySelector(".js-file-input-field");if(null!==g){var h=g.files;if(0<h.length)for(var j=0;j<h.length;j++)c.append("attachment[]",h[j])}a.ajax({url:gb.ajaxUrl,data:c,method:"POST",processData:!1,contentType:!1,beforeSend:function beforeSend(){e.attr("disabled",!0).text(gb.msg.pleaseWait)},success:function success(a){if(a){e.attr("disabled",!1).text(gb.msg.sent);var c=JSON.parse(a);c.error?showErrorAlert(c.error,b):(hideErrorAlert(b),c.redirect&&(window.location.href=c.redirect))}}})}})}}),a(document).on("blur",".js-form-validation .js-form-validate",function(){validateInput(this)}),a(document).on("click",".js-popup-form",function(){var b=a(this).data("popup-title"),c=a(this).data("formtype"),d=a(this).data("meta");showModalForm(b,c,d)}),a(document).on("click",".js-popup-pin",function(){showModal(gb.msg.inspiration,"large");var b={action:"get_single_popup_html",post_id:a(this).data("pin-id")};a.get(gb.ajaxUrl,b,function(a){loadModalContent(a)})}),a(document).on("click",".js-popup-explanation",function(){showModal("","medium");var b={action:"get_explanation_content",post_id:a(this).data("explanation-id")};a.get(gb.ajaxUrl,b,function(a){loadModalContent(a.html,a.title)})})})(jQuery);function showModalForm(a,b,c){showModal(a);var d={action:"get_form_modal_input",post_id:gb.postId,formtype:b,metadata:c};jQuery.get(gb.ajaxUrl,d,function(a){loadModalContent(a)})}function hideModal(){var a=jQuery(".js-modal");null!==a&&(a.removeClass("show"),jQuery(".js-modal-body").html(""))}function showModal(a){var b=1<arguments.length&&arguments[1]!==void 0?arguments[1]:"small";jQuery(".js-modal-title").html(a),jQuery(".js-modal").removeClass(function(a,b){return(b.match(/(^|\s)modal-\S+/g)||[]).join(" ")}),jQuery(".js-modal-loader").show(),jQuery(".js-modal-inner").hide(),jQuery(".js-modal").addClass("show modal-"+b)}function loadModalContent(a){var b=1<arguments.length&&arguments[1]!==void 0?arguments[1]:"";jQuery(".js-modal-body").html(a),b&&jQuery(".js-modal-title").html(b),jQuery(".js-modal-loader").hide(),jQuery(".js-modal-inner").fadeIn(300)}function validateForm(a,b){var c=!0,d=[],e=a.querySelectorAll(".js-form-validate");if(null!==e&&e.forEach(function(a){validateInput(a)||(c=!1,d.push(a))}),c)b(a);else{var f=jQuery(d[0]);f.isInViewport()||f.scrollTo(-50)}}function validateInput(a){clearValidate(a);var b=!0,c=!0,d=a.type,e=a.value,f=a.dataset.required,g=gb.msg.enterField;return e?"email"==d&&!emailIsValid(e)&&(b=!1,g=gb.msg.enterValidEmail):void 0===f?c=!1:b=!1,c&&(b?isValid(a):isInvalid(a,g)),b}function clearValidate(a){var b=jQuery(a).parents(".js-form-group"),c=b.find(".js-invalid-feedback");jQuery(a).removeClass("valid invalid"),c.text("")}function isValid(a){var b=jQuery(a).parents(".js-form-group"),c=b.find(".js-invalid-feedback");jQuery(a).removeClass("invalid"),jQuery(a).addClass("valid"),c.hide().text("")}function isInvalid(a,b){var c=jQuery(a).parents(".js-form-group"),d=c.find(".js-invalid-feedback");jQuery(a).removeClass("valid"),jQuery(a).addClass("invalid"),d.show().text(b)}function emailIsValid(a){return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(a)}function showErrorAlert(a,b){var c=document.querySelector(".js-error-alert");b&&(c=b.querySelector(".js-error-alert")),null!==c&&(c.innerHTML=a,c.style.display="block")}function hideErrorAlert(a){var b=document.querySelector(".js-error-alert");a&&(b=a.querySelector(".js-error-alert")),null!==b&&(b.innerHTML="",b.style.display="none")}