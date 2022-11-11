import {
  showModalForm,
  showModal,
  hideModal,
  loadModalContent,
} from "./functions";

const { render } = wp.element;
import LeadForm from "./components/LeadForm";
if (document.getElementById("react_lead_form")) {
  render(<LeadForm />, document.getElementById("react_lead_form"));
}

/**
 * jQuery plugin: Checks whether element in viewport
 */
jQuery.fn.isInViewport = function () {
  var elementTop = jQuery(this).offset().top;
  var elementBottom = elementTop + jQuery(this).outerHeight();
  var viewportTop = jQuery(window).scrollTop();
  var viewportBottom = viewportTop + jQuery(window).height();
  return elementBottom > viewportTop && elementTop < viewportBottom;
};

/**
 * jQuery plugin: Scrolls to given element
 */
jQuery.fn.scrollTo = function (offset) {
  offset = typeof offset !== "undefined" ? offset : -30;
  jQuery("html, body").animate(
    {
      scrollTop: jQuery(this).offset().top + offset,
    },
    500
  );
};

(function ($) {
  /**
   * Closest polyfil
   */
  if (!Element.prototype.matches) {
    Element.prototype.matches =
      Element.prototype.msMatchesSelector ||
      Element.prototype.webkitMatchesSelector;
  }

  if (!Element.prototype.closest) {
    Element.prototype.closest = function (s) {
      var el = this;

      do {
        if (el.matches(s)) return el;
        el = el.parentElement || el.parentNode;
      } while (el !== null && el.nodeType === 1);
      return null;
    };
  }

  /**
   * Foreach polyfil
   */
  if (!Array.prototype.forEach) {
    Array.prototype.forEach = function (fn, scope) {
      for (var i = 0, len = this.length; i < len; ++i) {
        fn.call(scope, this[i], i, this);
      }
    };
  }

  /**
   * Toggle side nav
   */
  $(".js-side-nav-list-toggler").on("click", function () {
    let targetElement = $(this).parent().find(".js-side-nav-list");
    targetElement.toggleClass("d-none");
  });

  /**
   * Masonry
   */
  $(".js-bricks").each(function () {
    const $bricks = $(this);
    const update = function () {
      $bricks.masonry({
        itemSelector: ".js-brick",
      });
    };
    $bricks.masonry({
      itemSelector: ".js-brick",
    });
    this.addEventListener("load", update, true);
  });

  // Hide element when in viewport on scroll
  $(window).on("scroll", function () {
    $(".js-hide-when").each(function (index, element) {
      const target = $(element).data("hide-when");
      if ($(target).isInViewport()) {
        $(element).hide();
      } else {
        $(element).show();
      }
    });
  });

  // Scroll to specific element
  $(".js-scroll-to").click(function () {
    const target = $(this).data("scroll-to");
    $(target).scrollTo(-10);
  });

  // Cart edit item
  $(".js-cart-item-edit").on("click", function (e) {
    e.preventDefault();
    let itemKey = $(this).data("cart-item-key");
    $.post(
      gb.ajaxUrl,
      { action: "edit_cart_item", cart_item_key: itemKey },
      function (response) {
        if (response.redirect_url) window.location.href = response.redirect_url;
      },
      "json"
    );
  });

  /**
   * Rotator
   */
  (function () {
    const rotators = document.querySelectorAll(".js-rotator");
    if (rotators !== null) {
      rotators.forEach((rotator) => {
        let items = rotator.querySelectorAll(".js-rotator-item");
        let isPaused = false;
        let index = 0;

        rotate();
        setInterval(rotate, 4000);

        rotator.addEventListener("mouseenter", () => {
          isPaused = true;
        });
        rotator.addEventListener("mouseleave", () => {
          isPaused = false;
        });

        function rotate() {
          if (!isPaused) {
            items[index].classList.add("visible");
            items.forEach((item) => {
              if (item !== items[index]) {
                item.classList.remove("visible");
              }
            });
            index++;
            if (index == items.length) index = 0;
          }
        }
      });
    }
  })();

  /**
   * Main navigation
   */
  (function () {
    const parentSelector = ".js-nav-item-parent";

    function showSublevel(element) {
      $(element).addClass("open");
    }

    function hideSublevel(element) {
      $(element).removeClass("open");
    }

    function toggleSublevel(element) {
      $(element).toggleClass("open");
      $(parentSelector).not(element).removeClass("open");
    }

    // Stops bubbling up in the DOM by click a menu subitem link
    $(document)
      .on("click", parentSelector + ", .js-nav-subitem-link", function (e) {
        e.stopPropagation();
      })

      // Closes sublevels by click outside
      .on("click", "body", function () {
        $(parentSelector).removeClass("open");
      })

      // Opens sublevel and closes siblings
      .on("mouseenter", parentSelector, function (e) {
        if ($(window).width() > 768) {
          e.preventDefault();
          showSublevel(this);
        }
      })
      .on("mouseleave", parentSelector, function (e) {
        if ($(window).width() > 768) {
          e.preventDefault();
          hideSublevel(this);
        }
      })

      .on("click", parentSelector, function (e) {
        if ($(window).width() <= 768) {
          e.preventDefault();
          toggleSublevel(this);
        }
      })

      // Toggles nav menu on mobile menu
      .on("click", ".js-nav-toggler", function () {
        $(this).toggleClass("open");
        $(".js-nav-items").toggleClass("open");
      });
  })();

  /**
   * Image slider
   */
  (function () {
    const container = $(".js-image-slider");
    const main = $(".js-main", container);
    const totalSlides = $(".js-thumb img", container).length;
    let currentIndex = 1;

    container
      .on("click", ".js-thumb img", function () {
        const index = $(this).data("index");
        change(index);
      })
      .on("click", ".js-next", next)
      .on("click", ".js-prev", previous);

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
      const url = current.data("image");
      const title = current.attr("title");

      // Change main image url
      if (main.is("picture")) {
        main.find("source").attr("srcset", url);
        main.find("img").attr("src", url);
        main.parent("a").attr("href", url);
      } else {
        main.attr("src", url).parent("a").attr("href", url);
      }

      // Change main image title
      main.parent("a").attr("title", title);
      main.parent("a").attr("data-caption", title);

      // Change current index class
      const currentClass = "current";
      current
        .parent()
        .addClass(currentClass)
        .siblings()
        .removeClass(currentClass);
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
  document.addEventListener("click", (e) => {
    if (e.target) {
      /**
       * Collapse box
       */
      if (e.target.closest(".js-collapse-box")) {
        e.target.closest(".js-collapse-box").classList.toggle("open");
        return;
      }

      /**
       * Close modal by css class handlers
       */
      if (
        e.target.closest(".js-close-modal") ||
        e.target.matches(".js-modal")
      ) {
        hideModal();
        return;
      }

      /**
       * Hide target
       */
      if (e.target.closest(".js-hide-target-trigger")) {
        let target = e.target.dataset.hideTarget;
        let element = document.querySelector(target);
        element.classList.add("d-none");
        element.classList.remove("d-block");
        return;
      }

      /**
       * Show target
       */
      if (e.target.closest(".js-show-target-trigger")) {
        let hideAfter = e.target.dataset.hideAfter || false;
        let target = e.target.dataset.showTarget;
        let element = document.querySelector(target);
        element.classList.add("d-block");
        element.classList.remove("d-none");
        if (hideAfter) $(e.target).hide();
        return;
      }

      /**
       * Toggle target
       */
      if (e.target.closest(".js-toggle-target-trigger")) {
        let target = e.target.dataset.toggleTarget;
        let element = document.querySelector(target);
        element.classList.toggle("d-block");
        element.classList.toggle("d-none");
        return;
      }
    }
  });

  /**
   * Empty dropdown and submit form
   */
  $(".js-empty-dropdown").click(function () {
    let dropdownGroup = $(this).parents(".js-dropdown-group");
    let dropdown = dropdownGroup.find(".js-dropdown");
    dropdown.val("");
    let submitAfter = $(this).data("submit");
    if (submitAfter) dropdown.parents("form").submit();
  });

  /**
   * Sticky bar
   */
  $(document).on("scroll", function () {
    let $stickyBar = $(".js-sticky-bar");
    let triggerData = $stickyBar.data("trigger");
    let viewportTop = $(window).scrollTop();
    let viewPortWidth = $(window).width();

    let show = false;

    if (!triggerData) return;
    triggerData.forEach(function (data) {
      if (!data.screen || !data.element) return;
      let elementTop = $(data.element).offset().top;

      if (viewportTop > elementTop) {
        if (data.screen == "mobile" && viewPortWidth < 768) {
          show = true;
        } else if (data.screen == "desktop" && viewPortWidth >= 768) {
          show = true;
        }
      }
    });
    if (show) $stickyBar.fadeIn(100);
    else $stickyBar.fadeOut(100);
  });

  /**
   * Delegate change events
   */
  document.addEventListener("change", (e) => {
    if (e.target) {
      /**
       * Dropdown that loads url on change
       */
      if (e.target.matches(".js-url-dropdown")) {
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
      if (e.target.closest(".js-file-input-field")) {
        const filesCount = e.target.files.length;
        e.target.parentNode.querySelector(
          ".js-file-input-trigger-text"
        ).innerHTML = filesCount + " " + gb.msg.filesSelected;
        return;
      }
    }
  });

  /**
   * Full form validation on submit
   */
  $(document).on("submit", ".js-form-validation", function (e) {
    e.preventDefault();

    const form = this;

    validateForm(form, function (form) {
      //Create formdata object
      const formData = new FormData(form);
      const action = form.querySelector(".js-form-action").value;
      const submitButton = jQuery('button[type="submit"]', form);
      const submitButtonText = submitButton.text();

      if (action !== undefined) {
        // Append action, nonce and request uri
        formData.append("action", action);
        formData.append("nonce", gb.ajaxNonce);
        formData.append("request_uri", gb.requestURI);

        // Handle files
        let fileField = form.querySelector(".js-file-input-field");
        if (fileField !== null) {
          let files = fileField.files;
          if (files.length > 0) {
            let combinedFilesize = 0;
            for (let i = 0; i < files.length; i++) {
              let file = files[i];
              combinedFilesize += file.size;
              formData.append("attachment[]", file);
            }

            // Check combined file size does not exceed max file size
            const maxCombinedFileSize = 8000000;
            if (combinedFilesize > maxCombinedFileSize) {
              showErrorAlert(
                gb.msg.fileUploadLimit.replace(
                  "{0}",
                  maxCombinedFileSize / 1000000
                ),
                form
              );
              return;
            }
          }
        }
        $.ajax({
          url: gb.ajaxUrl,
          data: formData,
          method: "POST",
          processData: false,
          contentType: false,
          beforeSend: function () {
            // Disable submit button
            submitButton.attr("disabled", true).text(gb.msg.pleaseWait);
          },
          success: function (response) {
            if (response) {
              submitButton.attr("disabled", false).text(gb.msg.sent);
              let parsed = JSON.parse(response);
              if (parsed.error) {
                showErrorAlert(parsed.error, form);
              } else {
                hideErrorAlert(form);
                if (parsed.redirect) {
                  window.location.href = parsed.redirect;
                }
              }
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
          },
        });
      }
    });
  });

  /**
   * Form validation per input on blur
   */
  $(document).on("blur", ".js-form-validation .js-form-validate", function () {
    validateInput(this);
  });

  /**
   * Popup form
   */
  $(document).on("click", ".js-popup-form", function () {
    let title = $(this).data("popup-title");
    let formtype = $(this).data("formtype");
    let metadata = $(this).data("meta");

    showModalForm(title, formtype, metadata);
  });

  /**
   * Popup pin
   */
  $(document).on("click", ".js-popup-pin", function () {
    showModal(gb.msg.inspiration, "large");

    let data = {
      action: "get_single_popup_html",
      post_id: $(this).data("pin-id"),
    };
    $.get(gb.ajaxUrl, data, function (html) {
      loadModalContent(html);
    });
  });

  /**
   * Popup explanation
   */
  $(document).on("click", ".js-popup-explanation", function () {
    showModal("", "medium");

    let data = {
      action: "get_explanation_content",
      post_id: $(this).data("explanation-id"),
    };
    $.get(gb.ajaxUrl, data, function (response) {
      loadModalContent(response.html, response.title);
    });
  });
})(jQuery);

/**
 * Validates a form
 */
function validateForm(form, callback) {
  let valid = true;
  let invalidInputs = [];
  const formElements = form.querySelectorAll(".js-form-validate");
  if (formElements !== null) {
    formElements.forEach((element) => {
      if (!validateInput(element)) {
        valid = false;
        invalidInputs.push(element);
      }
    });
  }
  if (valid) {
    callback(form);
  } else {
    // Scroll to first invalid field
    const firstInput = jQuery(invalidInputs[0]);
    if (!firstInput.isInViewport()) firstInput.scrollTo(-50);
  }
}

/**
 * Validates a form input
 */
function validateInput(element) {
  clearValidate(element);

  let valid = true;
  let showFeedback = true;

  let type = element.type;
  let value = element.value;
  let req = element.dataset.required;

  let msg = gb.msg.enterField;

  if (!value) {
    if (req !== undefined) {
      valid = false;
    } else {
      showFeedback = false;
    }
  } else {
    if (type == "email") {
      if (!emailIsValid(value)) {
        valid = false;
        msg = gb.msg.enterValidEmail;
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

/**
 * Clears form input styles and invalid feedback
 */
function clearValidate(element) {
  const parent = jQuery(element).parents(".js-form-group");
  const feedback = parent.find(".js-invalid-feedback");
  jQuery(element).removeClass("valid invalid");
  feedback.text("");
}

/**
 * Adds valid input styles and removes invalid feedback
 */
function isValid(element) {
  const parent = jQuery(element).parents(".js-form-group");
  const feedback = parent.find(".js-invalid-feedback");
  jQuery(element).removeClass("invalid");
  jQuery(element).addClass("valid");
  feedback.hide().text("");
}

/**
 * Adds invalid input styles and shows invalid feedback
 */
function isInvalid(element, msg) {
  const parent = jQuery(element).parents(".js-form-group");
  const feedback = parent.find(".js-invalid-feedback");
  jQuery(element).removeClass("valid");
  jQuery(element).addClass("invalid");
  feedback.show().text(msg);
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
  let alert = document.querySelector(".js-error-alert");
  if (parent) {
    alert = parent.querySelector(".js-error-alert");
  }
  if (alert !== null) {
    alert.innerHTML = error;
    alert.style.display = "block";
  }
}

/**
 * Hides error alert
 */
function hideErrorAlert(parent) {
  let alert = document.querySelector(".js-error-alert");
  if (parent) {
    alert = parent.querySelector(".js-error-alert");
  }
  if (alert !== null) {
    alert.innerHTML = "";
    alert.style.display = "none";
  }
}
