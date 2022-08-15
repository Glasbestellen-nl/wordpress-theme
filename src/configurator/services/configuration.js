import axios from "axios";
import qs from "qs";

export const getConfiguration = async (configuratorId) => {
  const response = await axios.post(
    window.gb.ajaxUrl,
    qs.stringify({
      action: "get_configuration",
      configurator_id: configuratorId,
    })
  );
  return response;
};

export const storeConfiguration = async (configuratorId, configuration) => {
  const response = await axios.post(
    window.gb.ajaxUrl,
    qs.stringify({
      action: "handle_configurator_form_submit",
      configurator_id: configuratorId,
      configuration,
    })
  );
  return response;
};
