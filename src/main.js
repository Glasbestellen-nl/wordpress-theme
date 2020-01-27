(function($) {

   /**
    * Closest polyfil
    */
   if (!Element.prototype.matches) {
      Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
   }

   if (!Element.prototype.closest) {
      Element.prototype.closest = function(s) {
      var el = this;

      do {
         if (el.matches(s)) return el;
            el = el.parentElement || el.parentNode;
      } while (el !== null && el.nodeType === 1);
         return null;
      };
   }

   /**
    * jQuery plugin: Checks whether element in viewport
    */
   $.fn.isInViewport = function() {
      var elementTop = $(this).offset().top;
      var elementBottom = elementTop + $(this).outerHeight();
      var viewportTop = $(window).scrollTop();
      var viewportBottom = viewportTop + $(window).height();
      return elementBottom > viewportTop && elementTop < viewportBottom;
   };

   /**
    * jQuery plugin: Scrolls to given element
    */
   $.fn.scrollTo = function(offset) {
      offset = typeof offset !== 'undefined' ? offset : -30;
      $('html, body').animate({
         scrollTop: $(this).offset().top + offset
      }, 500);
   };

   // Fancybox
   $('.fancybox').fancybox({
      prevEffect: 'none',
      nextEffect: 'none',
   });

   // Fancybox iframe
   $('.fancybox-various').fancybox({
      maxWidth: 800,
      maxHeight: 600,
      fitToView: false,
      width: '80%',
      height: '80%',
      autoSize: true,
      closeClick: false,
      openEffect: 'none',
      closeEffect: 'none'
   });

   /**
    * Toggle side nav
    */
   $('.js-side-nav-list-toggler').on('click', function() {
      let targetElement = $(this).parent().find('.js-side-nav-list');
      targetElement.toggleClass('d-none');
   });

   /**
    * Masonry
    */
   $('.js-bricks').each(function() {
      const $bricks = $(this);
      const update = function() {
         $bricks.masonry({
            itemSelector: '.js-brick'
         });
      };
      $bricks.masonry({
         itemSelector: '.js-brick'
      });
      this.addEventListener('load', update, true);
   });

   // Hide element when in viewport on scroll
   $(window).on('scroll', function() {
      $('.js-hide-when').each(function(index, element) {
         const target = $(element).data('hide-when');
         if ($(target).isInViewport()) {
            $(element).hide();
         } else {
            $(element).show();
         }
      });
   });

   // Scroll to specific element
   $('.js-scroll-to').click(function() {
      const target = $(this).data('scroll-to');
      $(target).scrollTo(20);
   });

   /**
    * Rotator
    */
   (function() {
      const rotators = document.querySelectorAll('.js-rotator');
      if (rotators !== null) {
         rotators.forEach(rotator => {

            let items = rotator.querySelectorAll('.js-rotator-item');
            let isPaused = false;
            let index = 0;

            rotate();
            setInterval(rotate, 4000);

            rotator.addEventListener('mouseenter', () => {
               isPaused = true;
            });
            rotator.addEventListener('mouseleave', () => {
               isPaused = false;
            });

            function rotate() {
               if (!isPaused) {
                  items[index].classList.add('visible');
                  items.forEach(item => {
                     if (item !== items[index]) {
                        item.classList.remove('visible');
                     }
                  });
                  index ++;
                  if (index == items.length)
                     index = 0;
               }
            }
         });
      }
   })();

   /**
    * Main navigation
    */
   (function() {

      const parentSelector = '.js-nav-item-parent';

      // Stops bubbling up in the DOM by click a menu subitem link
      $(document).on('click', parentSelector + ', .js-nav-subitem-link', function(e) {
         e.stopPropagation();
      })

      // Closes sublevels by click outside
      .on('click', 'body', function() {
         $(parentSelector).removeClass('open');
      })

      // Opens sublevel and closes siblings
      .on('click', parentSelector, function(e) {
         e.preventDefault();
         $(this).toggleClass('open');
         $(parentSelector).not(this).removeClass('open');
      })

      // Toggles nav menu on mobile menu
      .on('click', '.js-nav-toggler', function() {
         $(this).toggleClass('open');
         $('.js-nav-items').toggleClass('open');
      });

   })();

   /**
    * Image slider
    */
   (function() {

      const container     = $('.js-image-slider');
      const main          = $('.js-main', container);
      const totalSlides   = $('.js-thumb img', container).length;
      let currentIndex    = 1;

      container.on('click', '.js-thumb img', function() {
         const index = $(this).data('index');
         change(index);
      })
      .on('click', '.js-next', next)
      .on('click', '.js-prev', previous);

      function change(index) {

         // Change current index
         if (index > totalSlides) {
            currentIndex = 1;
         } else if (index < 1) {
            currentIndex = totalSlides;
         } else {
            currentIndex = index;
         }

         // Get current element
         const current = $('[data-index="' + currentIndex + '"]', container);
         const url = current.data('image');

         // Change main image url
         main.attr('src', url);

         // Change current index class
         const currentClass = 'current';
         current.parent().addClass(currentClass).siblings().removeClass(currentClass);
      }

      function next() {
         change(currentIndex + 1);
      }

      function previous() {
         change(currentIndex - 1);
      }

   })();

   /**
    * Delegate click events
    */
   document.addEventListener('click', e => {

      if (e.target) {

         /**
          * Collapse box
          */
         if (e.target.closest('.js-collapse-box')) {
            e.target.closest('.js-collapse-box').classList.toggle('open');
            return;
         }

         /**
          * Close modal by css class handlers
          */
         if (e.target.closest('.js-close-modal') || e.target.matches('.js-modal')) {
            hideModal();
            return;
         }

         /**
          * Hide target
          */
         if (e.target.closest('.js-hide-target-trigger')) {
            let target = e.target.dataset.hideTarget;
            let element = document.querySelector(target);
            element.classList.add('d-none');
            element.classList.remove('d-block');
            return;
         }

         /**
          * Show target
          */
         if (e.target.closest('.js-show-target-trigger')) {
            let target = e.target.dataset.showTarget;
            let element = document.querySelector(target);
            element.classList.add('d-block');
            element.classList.remove('d-none');
            return;
         }

         /**
          * Toggle target
          */
         if (e.target.closest('.js-toggle-target-trigger')) {
            let target = e.target.dataset.toggleTarget;
            let element = document.querySelector(target);
            element.classList.toggle('d-block');
            element.classList.toggle('d-none');
            return;
         }

      }

   });

   /**
    * Delegate change events
    */
   document.addEventListener('change', e => {

      if (e.target) {

         /**
         * Dropdown that loads url on change
         */
         if (e.target.matches('.js-url-dropdown')) {
            const selectedIndex = e.target.selectedIndex;
            const url = e.target.options[selectedIndex].value;
            if (url) {
               window.location = url;
            }
            return;
         }

         /**
          * On change file input field
          *
          * Changes text to show how many files are selected
          */
         if (e.target.closest('.js-file-input-field')) {
            const filesCount = e.target.files.length;
            e.target.parentNode.querySelector('.js-file-input-trigger-text').innerHTML = filesCount + ' ' + gb.msg.filesSelected;
            return;
         }
      }
   });

   /**
    * Delegate form events
    */
   document.addEventListener('submit', e => {

      /**
       * Full form validation on submit
       */
      if (e.target && e.target.matches('.js-form-validation')) {

         e.preventDefault();

         const form = e.target;

         validateForm(form, function(form) {

            //Create formdata object
            const formData = new FormData(form);
            const action = form.querySelector('.js-form-action').value;
            const submitButton = form.querySelector('button[type="submit"]');

            if (action !== undefined) {

               // Append action, nonce and request uri
               formData.append('action', action);
               formData.append('nonce', gb.ajaxNonce);
               formData.append('request_uri', gb.requestURI);

               // Handle files
               let fileField = form.querySelector('.js-file-input-field');
               if (fileField !== null) {
                  let files = fileField.files;
                  if (files.length > 0) {
                     for (let i = 0; i < files.length; i ++) {
                        formData.append('attachment[]', files[i]);
                     }
                  }
               }
               $.ajax({
                  url: gb.ajaxUrl,
                  data: formData,
                  method: 'POST',
                  processData: false,
                  contentType: false,
                  beforeSend: function() {
                     // Disable submit button
                     form.querySelector('button[type=submit]').disabled = true;
                  },
                  success: function(response) {
                     console.log(response);
                     if (response) {
                        let parsed = JSON.parse(response);
                        if (parsed.error) {
                           showErrorAlert(parsed.error, form);
                        } else {
                           hideErrorAlert(form);
                           form.querySelector('button[type=submit]').disabled = false;
                           if (parsed.redirect) {
                              window.location.href = parsed.redirect;
                           }
                        }
                     }
                  }
               });
            }
         });
         return;
      }
   });

   /**
    * Form validation per input on blur
    */
   $(document).on('blur', '.js-form-validate', function() {
      validateInput(this);
   });

   /**
    * Popup form
    */
   $(document).on('click', '.js-popup-form', function() {
      let data = {
         action: 'get_form_modal_input',
         formtype: $(this).data('formtype')
      }
      $.get(gb.ajaxUrl, data, function(json) {
         let response = JSON.parse(json);
         showModal(response.html, response.title);
      });
   });

   /**
    * Popup pin
    */
   $(document).on('click', '.js-popup-pin', function() {
      let data = {
         action: 'get_single_popup_html',
         post_id: $(this).data('pin-id')
      }
      $.get(gb.ajaxUrl, data, function(html) {
         showModal(html, gb.msg.inspiration, 'large');
      });
   });


})(jQuery);

/**
* Hides modal
*/
function hideModal() {
   const modal = document.querySelector('.js-modal');
   if (modal !== null) {
      modal.classList.remove('show');
   }
}

/**
* Shows modal
*/
function showModal(html, title, size = 'small') {
   jQuery('.js-modal-title').html(title);
   jQuery('.js-modal-body').html(html);
   // Remove modal size classes
   jQuery('.js-modal').removeClass(function (index, className) {
      return (className.match (/(^|\s)modal-\S+/g) || []).join(' ');
   });
   jQuery('.js-modal').addClass('show modal-' + size);
}

/**
* Validates a form
*/
function validateForm(form, callback) {
   let valid = true;
   const formElements = form.querySelectorAll('.js-form-validate');
   if (formElements !== null) {
      formElements.forEach(element => {
         if (!validateInput(element)) {
            valid = false;
         }
      });
   }
   if (valid) {
      callback(form);
   }
}

/**
* Validates a form input
*/
function validateInput(element) {

   clearValidate(element)

   let valid = true;

   let type   = element.type;
   let value  = element.value;
   let req    = element.dataset.required;

   let msg = gb.msg.enterField;

   if (!value) {
      if (req !== undefined) {
         valid = false;
      }
   } else {

      if (type == 'email') {
         if (!emailIsValid(value)) {
            valid = false;
            msg = gb.msg.enterValidEmail;
         }
      }
   }

   if (valid) {
      isValid(element);
   } else {
      isInvalid(element, msg);
   }
   return valid;
}

/**
* Clears form input styles and invalid feedback
*/
function clearValidate(element) {
   const parent = jQuery(element).parents('.js-form-group');
   const feedback = parent.find('.js-invalid-feedback');
   element.classList.remove('valid', 'invalid');
   feedback.text('');
}

/**
* Adds valid input styles and removes invalid feedback
*/
function isValid(element) {
   const parent = jQuery(element).parents('.js-form-group');
   const feedback = parent.find('.js-invalid-feedback');
   element.classList.remove('invalid');
   element.classList.add('valid');
   feedback.text('');
}

/**
* Adds invalid input styles and shows invalid feedback
*/
function isInvalid(element, msg) {
   const parent = jQuery(element).parents('.js-form-group');
   const feedback = parent.find('.js-invalid-feedback');
   element.classList.remove('valid');
   element.classList.add('invalid');
   feedback.text(msg);
}

/**
* Checks whether an email is valid
*/
function emailIsValid(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

/**
* Shows error alert
*/
function showErrorAlert(error, parent) {
   let alert = document.querySelector('.js-error-alert');
   if (parent) {
      alert = parent.querySelector('.js-error-alert');
   }
   if (alert !== null) {
      alert.innerHTML = error;
      alert.style.display = 'block';
   }
}

/**
* Hides error alert
*/
function hideErrorAlert(parent) {
   let alert = document.querySelector('.js-error-alert');
   if (parent) {
      alert = parent.querySelector('.js-error-alert');
   }
   if (alert !== null) {
      alert.innerHTML = '';
      alert.style.display = 'none';
   }
}
