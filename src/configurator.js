const Configurator = (function() {

   let instance;

   function ConfiguratorObject(element) {

      this.element = element;

      this.init = function() {

         /**
         * Delegate configurator click events
         */
         this.element.addEventListener('click', e => {

            // Select choice
            if (e.target && e.target.closest('.js-choice')) {
               let choice = e.target.closest('.js-choice');
               let partId = choice.dataset.choiceValue;
               this.selectChoice(choice);
               this.updateChoiceEnlargement(partId);
            }

            // Show step modal
            if (e.target && e.target.closest('.js-v-step')) {

               let step = e.target.closest('.js-v-step');
               let stepId = step.dataset.stepId;
               let title  = step.dataset.stepTitle;

               const self = this;
               this.showStep(stepId, title, function(stepId) {
                  let choiceField = self.element.querySelector('.js-configurator-step-choice');
                  if (choiceField !== null) {
                     let partId = choiceField.value;
                     self.updateChoiceEnlargement(partId);
                  }
               });
            }

            // Add configuration to cart
            if (e.target && e.target.closest('.js-configurator-to-cart')) {
               this.toCart();
            }

         });

         /**
         * Delegate configurator submit events
         */
         this.element.addEventListener('submit', e => {

            // Submit step form
            if (e.target && e.target.matches('.js-configurator-step-form')) {
               e.preventDefault();
               const form = e.target;
               this.submitStep(form);
            }

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

         jQuery(this.element).on('change', '.js-configurator-blur-update .js-form-validate', function() {

            if (self.validateInput(this)) {

               const form = jQuery(this).parents('.js-configurator-blur-update');
               if (form) {
                  const formData = new FormData(form[0]);
                  formData.append('action', 'handle_configurator_form_submit');
                  formData.append('configurator_id', gb.configuratorId);

                  jQuery.ajax({
                     url: gb.ajaxUrl,
                     type: 'POST',
                     data: formData,
                     processData: false,
                     contentType: false,
                     context: self,
                     success: function(response) {
                        console.log(response);
                        this.updateTotalPrice();
                     }
                  });
               }
            }
         }).on('click', '.js-configurator-cart-button', function(e) {

            e.preventDefault();

            const parentForm = jQuery(this).parents('form');
            let toCart = true;
            let invalidInputs = [];
            jQuery(':input', parentForm).each(function(index, element) {
               if (!self.validateInput(element)) {
                  toCart = false;
                  invalidInputs.push(element);
               }
            });
            if (toCart) {
               let quantity = jQuery('.js-configurator-quantity').val() || 1;
               let message  = jQuery('.js-configurator-message').val() || "";
               self.toCart(quantity, message);
            } else {
               // Scroll to first invalid field
               const firstInput = jQuery(invalidInputs[0]);
               if (!firstInput.isInViewport())
                  firstInput.scrollTo(-200);

            }
         });

      }

      this.selectChoice = function(choice) {

         let id = choice.dataset.choiceValue;

         choice.classList.add('current');
         const choices = choice.closest('.js-choices').querySelectorAll('.js-choice');
         if (choices !== null) {
            choices.forEach(sibling => {
               if (sibling !== choice) {
                  sibling.classList.remove('current');
               }
            });
         }

         // Set value to hidden field
         const hiddenField = choice.closest('form').querySelector('.js-configurator-step-choice');
         if (hiddenField !== null) {
            hiddenField.value = id;
         }
      }

      this.updateChoiceEnlargement = function(partId) {

         let container = this.element.querySelector('.js-choice-enlargement');

         if (container !== null) {
            let data = {
               action: 'get_configurator_choice_enlargement_html',
               part_id: partId
            }
            jQuery.get(gb.ajaxUrl, data, function(html) {
               container.innerHTML = html;
            });
         }
      }

      this.showStep = function(stepId, title, callback) {
         showModal(title, 'large');
         let data = {
            action: 'get_configurator_step_html',
            configurator_id: gb.configuratorId,
            step_id: stepId
         };
         jQuery.get(gb.ajaxUrl, data, function(html) {
            loadModalContent(html);
            callback(stepId);
         });
      }

      this.updateSteps = function() {
         let stepsContainer = this.element.querySelector('.js-v-steps');
         let data = {
            action: 'get_configurator_steps_html',
            configurator_id: gb.configuratorId
         };
         jQuery.get(gb.ajaxUrl, data, function(html) {
            stepsContainer.innerHTML = html;
         });
      }

      this.updateTotalPrice = function() {
         let totalPrice = this.element.querySelector('.js-config-total-price');
         let data = {
            action: 'get_configurator_total_price',
            configurator_id: gb.configuratorId
         }
         jQuery.get(gb.ajaxUrl, data, function(price) {
            totalPrice.innerHTML = price;
         });
      }

      this.submitStep = function(form) {

         let valid = true;

         let formElements = form.querySelectorAll('.js-form-validate');
         if (formElements !== null) {
            formElements.forEach(element => {
               if (!this.validateInput(element)) {
                  valid = false;
               }
            });
         }

         if (valid) {
            const formData = new FormData(form);
            const action = form.querySelector('.js-form-action').value;
            formData.append('action', action);

            jQuery.ajax({
               url: gb.ajaxUrl,
               type: 'POST',
               data: formData,
               processData: false,
               contentType: false,
               context: this,
               success: function(response) {
                  hideModal();
                  this.updateSteps();
                  this.updateTotalPrice();
               }
            });
         }
      }

      this.toCart = function(quantity = 1, message = '') {
         let data = {
            action: 'handle_configurator_to_cart',
            configurator_id: gb.configuratorId,
            quantity: quantity,
            message: message
         }
         jQuery.post(gb.ajaxUrl, data, function(cartUrl) {
            if (cartUrl)
               window.location.replace(cartUrl);
         });
      }

      this.validateInput = function(element) {

         clearValidate(element);

         let valid = true;
         let msg = gb.msg.enterField;
         let showFeedback = true;

         let value = element.value;
         let req = element.dataset.required;
         let jsonRules = element.dataset.validationRules;

         if (!value) {
            if (req) {
               valid = false;
            } else {
               showFeedback = false;
            }
         } else {
            if (jsonRules) {
               const rules = JSON.parse(jsonRules);
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
