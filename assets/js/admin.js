jQuery(document).ready(function($) {

   /**
    * Change current lead editor
    */
   $(window).on('load', function() {

      function checkCurrentEditedLeads() {
         const selector = '.js-someone-editing';
         const leadIDs  = [];
         $(selector).each(function(index, element) {
            leadIDs.push($(element).data('lead-id'));
         });
         const data = {
            action: 'check_leads_current_editor',
            lead_ids: leadIDs
         };
         $.get(ajaxurl, data, function(leads) {
            if (leads) {
               for (const [id, editing] of Object.entries(leads)) {
                  if (editing) {
                     $(selector + '-' + id).fadeIn();
                  } else {
                     $(selector + '-' + id).fadeOut();
                  }
               }
            }
         });
      }

      if (undefined == window.location.search)
         return;

      const urlParams = new URLSearchParams(window.location.search);
      const page = urlParams.get('page');

      if ('crm' == page) {
         const leadID = urlParams.get('lead_id');

         // Lead single screen
         if (leadID) {
            const data = {
               action: 'update_lead_current_editor',
               lead_id: leadID
            };
            $.post(ajaxurl, data, function(response) {
               if (response.other_editor) {
                  $('.js-current-editor-notice').show();
               }
            });

         // CRM table screen
         } else {
            checkCurrentEditedLeads();
            setInterval(checkCurrentEditedLeads, 5000);
         }
      }
   }).unload(function() {

      const urlParams = new URLSearchParams(window.location.search);
      const page = urlParams.get('page');

      if ('crm' == page) {
         const leadID = urlParams.get('lead_id');
         if (leadID) {
            const data = new FormData();
            data.append('action', 'unset_lead_current_editor');
            data.append('lead_id', leadID);
            navigator.sendBeacon(ajaxurl, data);
         }
      }
   });

   /**
    * Confirmation when clicking delete link
    */
   $('.js-lead-row-delete-link').click(function() {
      return confirm(gb.msg.sureDeleteLead);
   });

   /**
    * Offline conversion tracking dashboard
    */
   (function() {

      const dashboard = $('.js-conversion-tracking-dashboard');

      $(dashboard).on('click', '.js-add-item-button', function(e) {

         e.preventDefault();
         let data = {
            action: 'get_dashboard_item_row_html'
         };
         $.get(gb.ajaxUrl, data, function(row) {
            $('.js-items-table tbody', dashboard).append(row);
         });

      }).on('click', '.js-submit-button', function(e) {

         e.preventDefault();

         let self = $(this);

         let leadId = $('[name="lead_id"]').val();
         let data   = $(':input', dashboard).serialize() + '&action=save_dasboard_conversion&lead_id=' + leadId;

         $.post(gb.ajaxUrl, data, function(response) {
         });

      }).on('click', '.js-delete-item-button', function(e) {
         e.preventDefault();
         $(this).parents('tr').remove();
      });

   })();

   $('.js-change-update-lead').change(updateLead);
   $('.js-blur-update-lead').blur(updateLead);
   $('.js-delete-lead').click(function(e) {
      e.preventDefault();
      if (confirm(gb.msg.sureDeleteLead)) {
         let lead_id = $('[name="lead_id"]').val();
         let data = {
            action: 'delete_lead',
            lead_id: lead_id
         };
         $.post(gb.ajaxUrl, data, function(redirect) {
            window.location.replace(redirect);
         });
      }
   });
   $('.js-conversion-tracking-settings').on('click', '.js-add-item-button', function(e) {
      e.preventDefault();
   });

   function updateLead(callback) {
      const data = $('.js-lead-form').serialize() + '&action=update_lead';
      $.post(gb.ajaxUrl, data, function(response) {
         callback();
      });
   }

   $('.js-toggle-target').on('click', function(e) {
      e.preventDefault();
      let target = $(this).data('toggle-target');
      $(target).slideToggle();
   });

   $(function() {

   	var enabled = true;
   	$('textarea.js-tab-support').keydown(function(e) {

   		// Escape key toggles tab on/off
   		if (e.keyCode == 27) {
   			enabled = !enabled;
   			return false;
   		}

   		// Enter Key?
   		if (e.keyCode === 13 && enabled) {
   			// selection?
   			if (this.selectionStart == this.selectionEnd) {

   				// find start of the current line
   				var sel = this.selectionStart;
   				var text = $(this).val();
   				while (sel > 0 && text[sel-1] != '\n')
   				sel--;

   				var lineStart = sel;
   				while (text[sel] == ' ' || text[sel]=='\t')
   				sel++;

   				if (sel > lineStart) {

   					// Insert carriage return and indented text
   					document.execCommand('insertText', false, "\n" + text.substr(lineStart, sel-lineStart));

   					// Scroll caret visible
   					this.blur();
   					this.focus();
   					return false;
   				}
   			}
   		}

   		// Tab key?
   		if(e.keyCode === 9 && enabled) {
   			// selection?
   			if (this.selectionStart == this.selectionEnd) {
   				// These single character operations are undoable
   				if (!e.shiftKey) {
   					document.execCommand('insertText', false, "\t");
   				}
   				else {
   					var text = this.value;
   					if (this.selectionStart > 0 && text[this.selectionStart-1]=='\t') {
   						document.execCommand('delete');
   					}
   				}
   			}
   			else {
   				// Block indent/unindent trashes undo stack.
   				// Select whole lines
   				var selStart = this.selectionStart;
   				var selEnd = this.selectionEnd;
   				var text = $(this).val();
   				while (selStart > 0 && text[selStart - 1] != '\n')
   					selStart --;
   				while (selEnd > 0 && text[selEnd-1]!='\n' && selEnd < text.length)
   					selEnd ++;

   				// Get selected text
   				var lines = text.substr(selStart, selEnd - selStart).split('\n');

   				// Insert tabs
   				for (var i = 0; i < lines.length; i ++) {
   					// Don't indent last line if cursor at start of line
   					if (i == lines.length-1 && lines[i].length==0)
   						continue;

   					// Tab or Shift+Tab?
   					if (e.shiftKey) {
   						if (lines[i].startsWith('\t'))
   							lines[i] = lines[i].substr(1);
   						else if (lines[i].startsWith("    "))
   							lines[i] = lines[i].substr(4);
   					}
   					else
   						lines[i] = "\t" + lines[i];
   				}
   				lines = lines.join('\n');

   				// Update the text area
   				this.value = text.substr(0, selStart) + lines + text.substr(selEnd);
   				this.selectionStart = selStart;
   				this.selectionEnd = selStart + lines.length;
   			}

   			return false;
   		}
   		enabled = true;
   		return true;
   	});
   });

});
