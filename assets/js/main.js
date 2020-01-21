"use strict";(function(a){Element.prototype.matches||(Element.prototype.matches=Element.prototype.msMatchesSelector||Element.prototype.webkitMatchesSelector),Element.prototype.closest||(Element.prototype.closest=function(a){var b=this;do{if(b.matches(a))return b;b=b.parentElement||b.parentNode}while(null!==b&&1===b.nodeType);return null}),a(".js-fancybox").fancybox({prevEffect:"none",nextEffect:"none"}),a(".js-fancybox-various").fancybox({maxWidth:800,maxHeight:600,fitToView:!1,width:"80%",height:"80%",autoSize:!0,closeClick:!1,openEffect:"none",closeEffect:"none"}),a(".js-side-nav-list-toggler").on("click",function(){var b=a(this).parent().find(".js-side-nav-list");b.toggleClass("d-none")}),a(".js-bricks").each(function(){var b=a(this);b.masonry({itemSelector:".js-brick"}),this.addEventListener("load",function update(){b.masonry({itemSelector:".js-brick"})},!0)}),function(){var a=document.querySelectorAll(".js-rotator");null!==a&&a.forEach(function(a){function b(){d||(c[e].classList.add("visible"),c.forEach(function(a){a!==c[e]&&a.classList.remove("visible")}),e++,e==c.length&&(e=0))}var c=a.querySelectorAll(".js-rotator-item"),d=!1,e=0;b(),setInterval(b,4e3),a.addEventListener("mouseenter",function(){d=!0}),a.addEventListener("mouseleave",function(){d=!1})})}(),function(){a(document).on("click",".js-nav-item-parent, .js-nav-subitem-link",function(a){a.stopPropagation()}).on("click","body",function(){a(".js-nav-item-parent").removeClass("open")}).on("click",".js-nav-item-parent",function(b){b.preventDefault(),a(this).toggleClass("open"),a(".js-nav-item-parent").not(this).removeClass("open")}).on("click",".js-nav-toggler",function(){a(this).toggleClass("open"),a(".js-nav-items").toggleClass("open")})}(),document.addEventListener("click",function(a){if(a.target){if(a.target.closest(".js-collapse-box"))return void a.target.closest(".js-collapse-box").classList.toggle("open");if(a.target.closest(".js-close-modal")||a.target.matches(".js-modal"))return void hideModal();if(a.target.closest(".js-hide-target-trigger")){var b=a.target.dataset.hideTarget,c=document.querySelector(b);return c.classList.add("d-none"),void c.classList.remove("d-block")}if(a.target.closest(".js-show-target-trigger")){var d=a.target.dataset.showTarget,e=document.querySelector(d);return e.classList.add("d-block"),void e.classList.remove("d-none")}if(a.target.closest(".js-toggle-target-trigger")){var f=a.target.dataset.toggleTarget,g=document.querySelector(f);return g.classList.toggle("d-block"),void g.classList.toggle("d-none")}}}),document.addEventListener("change",function(a){if(a.target){if(a.target.matches(".js-url-dropdown")){var b=a.target.selectedIndex,c=a.target.options[b].value;return void(c&&(window.location=c))}if(a.target.closest(".js-file-input-field")){var d=a.target.files.length;return void(a.target.parentNode.querySelector(".js-file-input-trigger-text").innerHTML=d+" "+gb.msg.filesSelected)}}}),document.addEventListener("submit",function(b){if(b.target&&b.target.matches(".js-form-validation")){b.preventDefault();var c=b.target;return void validateForm(c,function(b){var c=new FormData(b),d=b.querySelector(".js-form-action").value,e=b.querySelector("button[type=\"submit\"]");if(void 0!==d){c.append("action",d),c.append("nonce",gb.ajaxNonce),c.append("request_uri",gb.requestURI);var f=b.querySelector(".js-file-input-field");if(null!==f){var g=f.files;if(0<g.length)for(var h=0;h<g.length;h++)c.append("attachment[]",g[h])}a.ajax({url:gb.ajaxUrl,data:c,method:"POST",processData:!1,contentType:!1,beforeSend:function beforeSend(){b.querySelector("button[type=submit]").disabled=!0},success:function success(a){if(console.log(a),a){var c=JSON.parse(a);c.error?showErrorAlert(c.error,b):(hideErrorAlert(b),b.querySelector("button[type=submit]").disabled=!1,c.redirect&&(window.location.href=c.redirect))}}})}})}}),a(document).on("blur",".js-form-validate",function(){validateInput(this)}),a(document).on("click",".js-popup-form",function(){var b={action:"get_form_modal_input",formtype:a(this).data("formtype")};a.get(gb.ajaxUrl,b,function(a){var b=JSON.parse(a);showModal(b.html,b.title)})})})(jQuery);function hideModal(){var a=document.querySelector(".js-modal");null!==a&&a.classList.remove("show")}function showModal(a,b){var c=2<arguments.length&&arguments[2]!==void 0?arguments[2]:"small";document.querySelector(".js-modal-title").innerHTML=b,document.querySelector(".js-modal-body").innerHTML=a,document.querySelector(".js-modal").classList.add("show","modal-"+c)}function validateForm(a,b){var c=!0,d=a.querySelectorAll(".js-form-validate");null!==d&&d.forEach(function(a){validateInput(a)||(c=!1)}),c&&b(a)}function validateInput(a){clearValidate(a);var b=!0,c=a.type,d=a.value,e=a.dataset.required,f=gb.msg.enterField;return d?"email"==c&&!emailIsValid(d)&&(b=!1,f=gb.msg.enterValidEmail):void 0!==e&&(b=!1),b?isValid(a):isInvalid(a,f),b}function clearValidate(a){var b=jQuery(a).parents(".js-form-group"),c=b.find(".js-invalid-feedback");a.classList.remove("valid","invalid"),c.text("")}function isValid(a){var b=jQuery(a).parents(".js-form-group"),c=b.find(".js-invalid-feedback");a.classList.remove("invalid"),a.classList.add("valid"),c.text("")}function isInvalid(a,b){var c=jQuery(a).parents(".js-form-group"),d=c.find(".js-invalid-feedback");a.classList.remove("valid"),a.classList.add("invalid"),d.text(b)}function emailIsValid(a){return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(a)}function showErrorAlert(a,b){var c=document.querySelector(".js-error-alert");b&&(c=b.querySelector(".js-error-alert")),null!==c&&(c.innerHTML=a,c.style.display="block")}function hideErrorAlert(a){var b=document.querySelector(".js-error-alert");a&&(b=a.querySelector(".js-error-alert")),null!==b&&(b.innerHTML="",b.style.display="none")}