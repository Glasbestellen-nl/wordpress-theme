"use strict";var Configurator=function(){function a(a){this.element=a,this.init=function(){var a=this;this.element.addEventListener("click",function(b){if(b.target.closest(".js-choice")){var c=b.target.closest(".js-choice"),d=c.dataset.choiceValue;a.selectChoice(c),a.updateChoiceEnlargement(d)}if(b.target&&b.target.closest(".js-v-step")){var e=b.target.closest(".js-v-step"),f=e.dataset.stepId,g=e.dataset.stepTitle,h=a;a.showStep(f,g,function(){var a=h.element.querySelector(".js-configurator-step-choice");if(null!==a){var b=a.value;h.updateChoiceEnlargement(b)}})}}),this.element.addEventListener("submit",function(b){if(b.target&&b.target.matches(".js-configurator-step-form")){b.preventDefault();var c=b.target;a.submitStep(c)}}),this.element.addEventListener("keyup",function(b){b.target&&b.target.matches(".js-form-validate")&&a.validateInput(b.target)})},this.selectChoice=function(a){var b=a.dataset.choiceValue;a.classList.add("current");var c=a.closest(".js-choices").querySelectorAll(".js-choice");null!==c&&c.forEach(function(b){b!==a&&b.classList.remove("current")});var d=a.closest("form").querySelector(".js-configurator-step-choice");null!==d&&(d.value=b)},this.updateChoiceEnlargement=function(a){var b=this.element.querySelector(".js-choice-enlargement");if(null!==b){jQuery.get(gb.ajaxUrl,{action:"get_configurator_choice_enlargement_html",part_id:a},function(a){b.innerHTML=a})}},this.showStep=function(a,b,c){var d={action:"get_configurator_step_html",configurator_id:gb.configuratorId,step_id:a};jQuery.get(gb.ajaxUrl,d,function(d){showModal(d,b,"large"),c(a)})},this.updateSteps=function(){var a=this.element.querySelector(".js-v-steps"),b={action:"get_configurator_steps_html",configurator_id:gb.configuratorId};jQuery.get(gb.ajaxUrl,b,function(b){a.innerHTML=b})},this.updateTotalPrice=function(){var a=this.element.querySelector(".js-config-total-price"),b={action:"get_configurator_total_price",configurator_id:gb.configuratorId};jQuery.get(gb.ajaxUrl,b,function(b){a.innerHTML=b})},this.submitStep=function(a){var b=this,c=!0,d=a.querySelectorAll(".js-form-validate");if(null!==d&&d.forEach(function(a){b.validateInput(a)||(c=!1)}),c){var e=new FormData(a),f=a.querySelector(".js-form-action").value;e.append("action",f),jQuery.ajax({url:gb.ajaxUrl,type:"POST",data:e,processData:!1,contentType:!1,context:this,success:function success(){hideModal(),this.updateSteps(),this.updateTotalPrice()}})}},this.validateInput=function(a){clearValidate(a);var b=!0,c=gb.msg.enterField,d=a.value,e=a.dataset.required,f=a.dataset.validationRules;if(!d)e&&(b=!1);else if(f){var g=JSON.parse(f);void 0!==g.min&&d<=parseInt(g.min)&&(b=!1,c=gb.msg.dimensionValueTooSmall.replace("{0}",g.min)),void 0!==g.max&&d>=parseInt(g.max)&&(b=!1,c=gb.msg.dimensionValueTooLarge.replace("{0}",g.max))}return b?isValid(a):isInvalid(a,c),b}}function b(b){return c=new a(b),c}var c;return{getInstance:function getInstance(a){return c||(c=b(a)),c}}}(),configurator=Configurator.getInstance(document.querySelector(".single-configurator"));configurator.init();