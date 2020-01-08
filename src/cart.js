const Cart = (function() {

   let instance;

   function CartObject(element) {

      this.element = element;

      this.init = function() {

         let self = this;

         // Change quantity
         jQuery(element).on('change', '.js-cart-item-quantity', function() {
            let data = {
               action: 'handle_cart_item_quantity',
               quantity: jQuery(this).val(),
               id: self.getItemId(this)
            }
            jQuery.post(gb.ajaxUrl, data, url => {
               window.location.replace(url);
            });

         // Delete item
         }).on('click', '.js-cart-item-delete', function() {
            let data = {
               action: 'handle_cart_item_delete',
               id: self.getItemId(this)
            }
            jQuery.post(gb.ajaxUrl, data, url => {
               window.location.replace(url);
            });
         })
         // Edit item
         .on('click', '.js-cart-item-edit', function() {
            let data = {
               action: 'handle_cart_item_edit',
               id: self.getItemId(this)
            }
            jQuery.post(gb.ajaxUrl, data, url => {
               window.location.replace(url);
            });
         })
         // Redo configuration with same item
         .on('click', '.js-cart-item-redo', function() {
            let data = {
               action: 'handle_cart_item_redo',
               id: self.getItemId(this)
            }
            jQuery.post(gb.ajaxUrl, data, url => {
               window.location.replace(url);
            });
         });
      }

      // Returns cart item id
      this.getItemId = function(element) {
         return jQuery(element).parents('.js-cart-item').data('item-id');
      }

   }

   function createInstance(element) {
      instance = new CartObject(element);
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

const cart = Cart.getInstance(document.querySelector('.js-cart'));
cart.init();
