const { createContext, useState, useEffect } = wp.element;
import {
  getConfiguration,
  storeConfiguration,
} from "../services/configuration";
export const ConfiguratorContext = createContext();

export const ConfiguratorProvider = (props) => {
  const [sizeUnit, setSizeUnit] = useState(
    window?.configurator?.settings?.size_unit || "mm"
    // "mm"
  );
  const [configuration, setConfiguration] = useState({});
  const [totalPriceHtml, setTotalPriceHtml] = useState("");

  useEffect(() => {
    (async () => {
      const response = await getConfiguration(
        window.configurator.configuratorId
      );
      if (response && response.data && response.data.configuration)
        setConfiguration(response.data.configuration);
    })();
  }, []);

  useEffect(() => {
    (async () => {
      try {
        const { productId } = window.configurator;
        // Store configuration in server session and receive total price html
        const response = await storeConfiguration(productId, configuration);
        if (response && response.data && response.data.price_html) {
          setTotalPriceHtml(response.data.price_html);
        }
      } catch (err) {
        console.error(err);
      }
    })();
  }, [configuration]);

  return (
    <ConfiguratorContext.Provider
      value={{
        configuration,
        setConfiguration,
        sizeUnit,
        totalPriceHtml,
      }}
    >
      {props.children}
    </ConfiguratorContext.Provider>
  );
};
