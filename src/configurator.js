const Configurator = (function() {

   let instance;

   function ConfiguratorObject(element) {

      const $ = jQuery;

      this.element = element;

      this.init = function() {

         /**
         * Delegate configurator keyup events
         */
         this.element.addEventListener('keyup', e => {

            if (e.target && e.target.matches('.js-form-validate')) {
               this.validateInput(e.target);
            }

         });

         const self = this;

         $(this.element).on('change', '.js-configurator-blur-update .js-form-validate', function() {

            // Show and hide child steps
            const stepId       = $(this).data('step-id');
            const childStepIds = $('option:selected', this).data('child-steps');

            const showChildStep = function(stepId) {
               $('.js-step-' + stepId).removeClass('d-none').find('.js-form-validate').trigger('change');
            };

            const hideChildStep = function(stepId) {
               const step  = $('.js-parent-step-' + stepId);
               const input = step.find('.js-form-validate');
               step.addClass('d-none');
               clearValidate(input);
            };

            hideChildStep(stepId);

            if (childStepIds) {
               if ($.isArray(childStepIds)) {
                  childStepIds.forEach(function(childStepId) {
                     showChildStep(childStepId);
                  });
               } else {
                  showChildStep(childStepIds);
               }
            }

            const form = $(this).parents('.js-configurator-blur-update');

            if (form) {
               const formData = self.initFormData();

               $(':input:visible, .js-input-hidden', form).each(function(index, element) {
                  self.validateInput(element);
                  formData.append($(element).attr('name'), $(element).val());
               });

               self.submitFormData(formData, function() {
                  self.updateTotalPrice();
               });
            }

         }).on('click', '.js-configurator-cart-button', function(e) {

            e.preventDefault();

            const form = $(this).parents('form');

            self.validateForm(form, function(formData) {
               let quantity = $('.js-configurator-quantity').val() || 1;
               let message  = $('.js-configurator-message').val() || "";
               self.submitFormData(formData, function() {
                  self.toCart(quantity, message);
               });
            });

         }).on('click', '.js-configurator-save-button', function(e) {

            const form = $(this).parents('form');

            self.validateForm(form, function() {

               let title    = $(this).data('popup-title');
               let formtype = $(this).data('formtype');
               let metadata = $(this).data('meta');

               showModalForm(title, formtype, metadata, function(modalForm) {
                  let messageFieldValue = $('.js-configurator-message').val();
                  if (messageFieldValue) {
                     $('.js-form-content-field', modalForm).val(messageFieldValue);
                  }
               });

            }.bind(this));
         });
      }

      this.updateTotalPrice = function() {
         let totalPrice = this.element.querySelector('.js-config-total-price');
         let data = {
            action: 'get_configurator_total_price',
            configurator_id: gb.postId
         }
         $.get(gb.ajaxUrl, data, function(price) {
            totalPrice.innerHTML = price;
         });
      }

      this.toCart = function(quantity = 1, message = '') {

         const cartButton = $('.js-configurator-cart-button');

         let data = {
            action: 'handle_configurator_to_cart',
            configurator_id: gb.postId,
            quantity: quantity,
            message: message
         }

         $.ajax({
            url: gb.ajaxUrl,
            data: data,
            method: 'POST',
            beforeSend: function() {
               cartButton.attr('disabled', true).text(gb.msg.pleaseWait);
            },
            success: function(response) {
               cartButton.attr('disabled', false);
               if (response.url)
                  window.location.replace(response.url);
            }
         });
      }

      this.initFormData = function() {
         const formData = new FormData();
         formData.append('action', 'handle_configurator_form_submit');
         formData.append('configurator_id', gb.postId);
         return formData;
      }

      this.validateForm = function(form, callback) {

         const self = this;

         const formData = this.initFormData();

         let valid = true;
         let invalidInputs = [];
         $(':input:visible, .js-input-hidden', form).each(function(index, element) {
            if (!self.validateInput(element)) {
               valid = false;
               invalidInputs.push(element);
            } else {
               formData.append($(element).attr('name'), $(element).val());
            }
         });
         if (valid) {
            if (typeof callback === 'function' && callback(formData))
               callback(formData);
         } else {
            // Scroll to first invalid field
            const firstInput = $(invalidInputs[0]);
            if (!firstInput.isInViewport())
               firstInput.scrollTo(-200);
         }

      }

      this.submitFormData = function(formData, callback) {

         $.ajax({
            url: gb.ajaxUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            context: this,
            success: function(response) {

               if (typeof callback === 'function' && callback())
                  callback();
            }
         });
      }

      this.validateInput = function(element) {

         clearValidate(element);

         let valid = true;
         let msg = gb.msg.enterField;
         let showFeedback = true;

         let value = $(element).is('select') && $(element).find(':selected').data('option-value') || element.value;
         let req = element.dataset.required;
         let rules = $(element).data('validation-rules');

         if (!value) {
            if (req) {
               valid = false;
            } else {
               showFeedback = false;
            }
         } else {
            if (rules) {

               if (rules.min !== undefined) {
                  if (value < parseInt(rules.min)) {
                     valid = false;
                     msg = gb.msg.dimensionValueTooSmall.replace('{0}', rules.min);
                  }
               }

               if (rules.max !== undefined) {

                  let max;

                  if (rules.max.dependence !== undefined) {

                     let dependentStepId = rules.max.dependence;
                     let dependentValue  = $('.js-step-' + dependentStepId).find('.js-form-validate').val();

                     if (dependentValue) {
                        if (rules.max.greater && rules.max.less) {
                           max = (value > parseInt(dependentValue)) ? parseInt(rules.max.greater) : parseInt(rules.max.less);
                        } else {
                           max = parseInt(dependentValue);
                        }
                     }

                  } else {
                     max = parseInt(rules.max);
                  }

                  if (value > max) {
                     valid = false;
                     msg = gb.msg.dimensionValueTooLarge.replace('{0}', max);
                  }
               }

               if (rules.less_than && rules.less_than.step) {

                  let lessThan = rules.less_than;

                  let dependentStepId = lessThan.step;
                  let dependentStep = $('.js-step-' + dependentStepId).find('.js-form-validate');
                  let dependentValue  = parseInt(dependentStep.is('select') && dependentStep.find(':selected').data('option-value')) || parseInt(dependentStep.val());

                  if (lessThan.value) {
                     dependentValue -= parseInt(lessThan.value);
                  }
                  if (dependentValue < value) {
                     valid = false;
                     if (rules.less_than.message) {
                        msg = rules.less_than.message;
                     }
                  }
               }
            }
         }

         if ($(element).is('select')) {
            let selected = $('option:selected', element);
            let rules = selected.data('validation-rules');
            if (rules && rules.exclude !== undefined) {
               let excludeRules = rules.exclude;
               if ($.isArray(excludeRules)) {
                  excludeRules.forEach((excludeRule) => {
                     if (excludeRule.step && excludeRule.options) {
                        let step    = $(`.js-step-input-${excludeRule.step}`);
                        excludeRule.options.forEach((optionId) => {
                           let option  = step.find(`option[data-option-id="${optionId}"]:selected`);
                           if (option.length > 0) {
                              valid = false;
                              msg = excludeRule.message;
                           }
                        });
                     }
                  });
               }
            }
         }

         if (showFeedback) {
            if (valid) {
               isValid(element);
            } else {
               isInvalid(element, msg);
            }
         }
         return valid;
      }

   }

   function createInstance(element) {
      instance = new ConfiguratorObject(element);
      return instance;
   }

   return {
      getInstance: (element) => {
         if (!instance)
            instance = createInstance(element);
         return instance;
      }
   }

})();

const configurator = Configurator.getInstance(document.querySelector('.js-configurator'));
configurator.init();
