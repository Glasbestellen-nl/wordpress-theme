"use strict";var Configurator=function(){function a(a){var b=jQuery;this.element=a,this.init=function(){var a=this;this.element.addEventListener("keyup",function(b){b.target&&b.target.matches(".js-form-validate")&&a.validateInput(b.target)});var c=this;b(this.element).on("change",".js-configurator-blur-update .js-form-validate",function(){var a=b(this).data("step-id"),d=b("option:selected",this).data("child-steps"),e=function(a){b(".js-step-"+a).removeClass("d-none").find(".js-form-validate").trigger("change")};(function hideChildStep(a){var c=b(".js-parent-step-"+a),d=c.find(".js-form-validate");c.addClass("d-none"),clearValidate(d)})(a),d&&(b.isArray(d)?d.forEach(function(a){e(a)}):e(d));var f=b(this).parents(".js-configurator-blur-update");if(f){var g=c.initFormData();b(":input:visible, .js-input-hidden",f).each(function(a,d){c.validateInput(d),g.append(b(d).attr("name"),b(d).val())}),c.submitFormData(g,function(){c.updateTotalPrice()})}}).on("click",".js-configurator-cart-button",function(a){a.preventDefault();var d=b(".js-configurator-form");c.validateForm(d,function(a){var d=b(".js-configurator-quantity").val()||1,e=b(".js-configurator-message").val()||"";c.submitFormData(a,function(){c.toCart(d,e)})})}).on("click",".js-configurator-save-button",function(){var a=b(".js-configurator-form");c.validateForm(a,function(){var a=b(this).data("popup-title"),c=b(this).data("formtype"),d=b(this).data("meta");showModalForm(a,c,d,function(a){var c=b(".js-configurator-message").val();c&&b(".js-form-content-field",a).val(c)})}.bind(this))})},this.updateTotalPrice=function(){var a=b(".js-config-total-price",this.element),c={action:"get_configurator_total_price",configurator_id:gb.configuratorId};b.get(gb.ajaxUrl,c,function(b){a.html(b)})},this.toCart=function(){var a=0<arguments.length&&arguments[0]!==void 0?arguments[0]:1,c=1<arguments.length&&arguments[1]!==void 0?arguments[1]:"",d=b(".js-configurator-cart-button"),e={action:"handle_configurator_to_cart",product_id:gb.postId,quantity:a,message:c};b.ajax({url:gb.ajaxUrl,data:e,method:"POST",beforeSend:function beforeSend(){d.attr("disabled",!0).text(gb.msg.pleaseWait)},success:function success(a){d.attr("disabled",!1),a.url&&window.location.replace(a.url)}})},this.initFormData=function(){var a=new FormData;return a.append("action","handle_configurator_form_submit"),a.append("configurator_id",gb.configuratorId),a},this.validateForm=function(a,c){var d=this,e=this.initFormData(),f=!0,g=[];if(b(":input:visible, .js-input-hidden",a).each(function(a,c){d.validateInput(c)?e.append(b(c).attr("name"),b(c).val()):(f=!1,g.push(c))}),f)"function"==typeof c&&c(e)&&c(e);else{var h=b(g[0]);h.isInViewport()||h.scrollTo(-200)}},this.submitFormData=function(a,c){b.ajax({url:gb.ajaxUrl,type:"POST",data:a,processData:!1,contentType:!1,context:this,success:function success(){"function"==typeof c&&c()&&c()}})},this.validateInput=function(a){clearValidate(a);var c=!0,d=gb.msg.enterField,e=!0,f=b(a).is("select")&&b(a).find(":selected").data("option-value")||a.value,g=a.dataset.required,h=b(a).data("validation-rules");if(!f)g?c=!1:e=!1;else if(h){if(void 0!==h.min&&f<parseInt(h.min)&&(c=!1,d=gb.msg.dimensionValueTooSmall.replace("{0}",h.min)),void 0!==h.max){var o;if(void 0!==h.max.dependence){var p=h.max.dependence;p=!Array.isArray(p)&&[p]||p;var q=0;p.forEach(function(a){var c=b(".js-step-"+a).find(".js-form-validate").val();c&&c>q&&(o=h.max.greater&&h.max.less?f>parseInt(c)?parseInt(h.max.greater):parseInt(h.max.less):parseInt(c),q=o)})}else o=parseInt(h.max);f>o&&(c=!1,d=gb.msg.dimensionValueTooLarge.replace("{0}",o))}if(h.less_than&&h.less_than.step){var i=h.less_than,j=i.step,k=b(".js-step-"+j).find(".js-form-validate"),l=parseInt(k.is("select")&&k.find(":selected").data("option-value"))||parseInt(k.val());i.value&&(l-=parseInt(i.value)),l<f&&(c=!1,h.less_than.message&&(d=h.less_than.message))}}if(b(a).is("select")){var m=b("option:selected",a),n=m.data("validation-rules");if(n&&void 0!==n.exclude){var r=n.exclude;b.isArray(r)&&r.forEach(function(a){if(a.step&&a.options){var e=b(".js-step-input-".concat(a.step));a.options.forEach(function(b){var f=e.find("option[data-option-id=\"".concat(b,"\"]:selected"));0<f.length&&(c=!1,d=a.message)})}})}}return e&&(c?isValid(a):isInvalid(a,d)),c}}function b(b){return c=new a(b),c}var c;return{getInstance:function getInstance(a){return c||(c=b(a)),c}}}(),configurator=Configurator.getInstance(document.querySelector(".js-configurator"));configurator.init();