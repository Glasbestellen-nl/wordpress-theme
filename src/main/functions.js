/**
 * Shows modal form
 */
export const showModalForm = (title, formtype, metadata, callback) => {
  showModal(title);

  let data = {
    action: "get_form_modal_input",
    post_id: gb.postId,
    formtype: formtype,
    metadata: metadata,
  };
  jQuery.get(gb.ajaxUrl, data, function (html) {
    loadModalContent(html, false, function (modalElement) {
      if (callback) callback(modalElement);
    });
  });
};

/**
 * Shows modal
 */
export const showModal = (title, size = "small") => {
  jQuery(".js-modal-title").html(title);
  // Remove modal size classes
  jQuery(".js-modal").removeClass(function (index, className) {
    return (className.match(/(^|\s)modal-\S+/g) || []).join(" ");
  });
  jQuery(".js-modal-loader").show();
  jQuery(".js-modal-inner").hide();
  jQuery(".js-modal").addClass("show modal-" + size);
};

/**
 * Hides modal
 */
export const hideModal = () => {
  const modal = jQuery(".js-modal");
  if (modal !== null) {
    modal.removeClass("show");
    jQuery(".js-modal-body").html("");
  }
};

/**
 * Loads modal content
 */
export const loadModalContent = (html, title = "", callback) => {
  jQuery(".js-modal-body").html(html);
  if (title) {
    jQuery(".js-modal-title").html(title);
  }
  jQuery(".js-modal-loader").hide();
  jQuery(".js-modal-inner").fadeIn(300);
  if (callback) callback(jQuery(".js-modal"));
};
