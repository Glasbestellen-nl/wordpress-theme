"use strict";var Cart=function(){function a(a){this.element=a,this.init=function(){var b=this;jQuery(a).on("change",".js-cart-item-quantity",function(){var a={action:"handle_cart_item_quantity",quantity:jQuery(this).val(),id:b.getItemId(this)};jQuery.post(gb.ajaxUrl,a,function(a){window.location.replace(a)})}).on("click",".js-cart-item-delete",function(){var a={action:"handle_cart_item_delete",id:b.getItemId(this)};jQuery.post(gb.ajaxUrl,a,function(a){window.location.replace(a)})}).on("click",".js-cart-item-edit",function(){var a={action:"handle_cart_item_edit",id:b.getItemId(this)};jQuery.post(gb.ajaxUrl,a,function(a){window.location.replace(a)})}).on("click",".js-cart-item-redo",function(){var a={action:"handle_cart_item_redo",id:b.getItemId(this)};jQuery.post(gb.ajaxUrl,a,function(a){window.location.replace(a)})})},this.getItemId=function(a){return jQuery(a).parents(".js-cart-item").data("item-id")}}function b(b){return c=new a(b),c}var c;return{getInstance:function getInstance(a){return c||(c=b(a)),c}}}(),cart=Cart.getInstance(document.querySelector(".js-cart"));cart.init();