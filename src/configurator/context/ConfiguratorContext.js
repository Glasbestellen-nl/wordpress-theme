const { createContext, useState, useEffect } = wp.element;
import { getConfiguration } from "../utils/configuration";
export const ConfiguratorContext = createContext();

export const ConfiguratorProvider = (props) => {
  const [sizeUnit] = useState(
    window?.configurator?.settings?.size_unit || "mm"
  );
  const [configuration, setConfiguration] = useState(false);
  const [totalPriceHtml, setTotalPriceHtml] = useState("");
  const [loading, setLoading] = useState(true);
  const [submitting, setSubmitting] = useState(false);
  const [invalidFields, setInvalidFields] = useState({});

  useEffect(() => {
    (async () => {
      const response = await getConfiguration(
        window.configurator.configuratorId
      );
      if (response && response.data && response.data.configuration) {
        setConfiguration(response.data.configuration);
        setLoading(false);
      }
    })();
  }, []);

  const addInvalidField = (id, message) => {
    setInvalidFields((prevFields) => ({ ...prevFields, [id]: message }));
  };

  const removeInvalidField = (id) => {
    setInvalidFields((prevFields) => {
      if (prevFields[id]) delete prevFields[id];
      return { ...prevFields };
    });
  };

  return (
    <ConfiguratorContext.Provider
      value={{
        configuration,
        setConfiguration,
        sizeUnit,
        totalPriceHtml,
        setTotalPriceHtml,
        loading,
        setLoading,
        submitting,
        setSubmitting,
        invalidFields,
        setInvalidFields,
        addInvalidField,
        removeInvalidField,
      }}
    >
      {props.children}
    </ConfiguratorContext.Provider>
  );
};
