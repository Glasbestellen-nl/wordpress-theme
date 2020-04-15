const Configurator = (function() {

   let instance;

   function ConfiguratorObject(element) {

      const $ = jQuery;

      this.element = element;

      this.init = function() {

         /**
         * Delegate configurator click events
         */
         this.element.addEventListener('click', e => {

            // Add configuration to cart
            if (e.target && e.target.closest('.js-configurator-to-cart')) {
               this.toCart();
            }
         });

         /**
         * Delegate configurator submit events
         */
         this.element.addEventListener('submit', e => {
         });

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

            // Show and hide child step
            const stepId = $(this).data('step-id');
            const childStepId = $('option:selected', this).data('child-step');
            if (childStepId) {
               $('.js-step-' + childStepId).removeClass('d-none');
            } else {
               $('.js-step-parent-' + stepId).addClass('d-none');
            }

            const form = $(this).parents('.js-configurator-blur-update');

            if (form) {

               const formData = self.initFormData(form[0]);

               $(':input', form).each(function(index, element) {
                  if ($(element).val())
                     self.validateInput(element);
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

               showModalForm(title, formtype, metadata);

            }.bind(this));

         });

      }

      this.updateTotalPrice = function() {
         let totalPrice = this.element.querySelector('.js-config-total-price');
         let data = {
            action: 'get_configurator_total_price',
            configurator_id: gb.configuratorId
         }
         $.get(gb.ajaxUrl, data, function(price) {
            totalPrice.innerHTML = price;
         });
      }

      this.toCart = function(quantity = 1, message = '') {
         let data = {
            action: 'handle_configurator_to_cart',
            configurator_id: gb.configuratorId,
            quantity: quantity,
            message: message
         }
         $.post(gb.ajaxUrl, data, function(response) {
            console.log(response);
            if (response.url)
               window.location.replace(response.url);
         });
      }

      this.initFormData = function(form) {
         const formData = new FormData(form);
         formData.append('action', 'handle_configurator_form_submit');
         formData.append('configurator_id', gb.configuratorId);
         return formData;
      }

      this.validateForm = function(form, callback) {

         const self = this;

         const formData = this.initFormData(form[0]);

         let valid = true;
         let invalidInputs = [];
         $(':input', form).each(function(index, element) {
            if (!self.validateInput(element)) {
               valid = false;
               invalidInputs.push(element);
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

               // if (response.price_table)
               //    console.log(response.price_table);

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

         let value = element.value;
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
                  if (value > parseInt(rules.max)) {
                     valid = false;
                     msg = gb.msg.dimensionValueTooLarge.replace('{0}', rules.max);
                  }
               }
            }
         }

         if ($(element).is('select')) {
            let selected = $('option:selected', element);
            let rules = selected.data('validation-rules');
            if (rules) {
               if (rules.exclude !== undefined) {
                  let exclude = rules.exclude;
                  if (exclude.step && exclude.option) {
                     let step    = $(`.js-step-input-${exclude.step}`);
                     let option  = step.find(`option[data-option-id="${exclude.option}"]:selected`);
                     if (option.length > 0) {
                        valid = false;
                        msg = exclude.message;
                     }
                  }
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
