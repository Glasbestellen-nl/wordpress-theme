const Cart = (function() {

   let instance;

   function CartObject(element) {

      this.element = element;

      this.init = function() {

         // Change quantity dropdown
         let quantityDropdown = element.querySelector('.js-quantity-dropdown');
         if (quantityDropdown !== null) {
            quantityDropdown.addEventListener('change', e => {
               let data = {
                  action: 'handle_cart_item_quantity',
                  quantity: e.target.value,
                  id: this.getItemId(e.target)
               }
               jQuery.post(gb.ajaxUrl, data, () => {
                  console.log('Changed!');
               });
            });
         }

      }

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
