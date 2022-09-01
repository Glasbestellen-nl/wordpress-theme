import axios from "axios";
import qs from "qs";

const { ajaxUrl } = window.gb;

export const getConfiguration = async (configuratorId) => {
  const response = await axios.post(
    ajaxUrl,
    qs.stringify({
      action: "get_configuration",
      configurator_id: configuratorId,
    })
  );
  return response;
};

export const storeConfiguration = async (productId, configuration) => {
  const response = await axios.post(
    ajaxUrl,
    qs.stringify({
      action: "handle_configurator_form_submit",
      product_id: productId,
      configuration,
    })
  );
  return response;
};

export const getConfigurationTotalPrice = async (productId) => {
  const response = await axios.post(
    ajaxUrl,
    qs.stringify({
      action: "get_configurator_total_price",
      product_id: productId,
    })
  );
  return response;
};

export const addConfigurationToCart = async (productId, quantity, message) => {
  const response = await axios.post(
    ajaxUrl,
    qs.stringify({
      action: "handle_configurator_to_cart",
      product_id: window?.configurator?.productId,
      quantity,
      message,
    })
  );
  return response;
};
