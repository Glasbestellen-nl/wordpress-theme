jQuery(document).ready(function($) {

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

   function updateLead() {
      const data = $('.js-lead-form').serialize() + '&action=update_lead';
      $.post(gb.ajaxUrl, data, function(response) {
         console.log(response);
      });
   }

});
