const { createContext, useState, useEffect, useContext } = wp.element;
import {
  getConfiguration,
  storeConfiguration,
} from "../services/configuration";
export const ConfiguratorContext = createContext();

export const ConfiguratorProvider = (props) => {
  const [sizeUnit, setSizeUnit] = useState("mm");
  const [configuration, setConfiguration] = useState({});

  useEffect(() => {
    (async () => {
      const response = await getConfiguration(window.gb.configuratorId);
      console.log(response);
      if (response && response.data && response.data.configuration)
        setConfiguration(response.data.configuration);
    })();
  }, []);

  useEffect(() => {
    (async () => {
      const response = await storeConfiguration(
        window.gb.configuratorId,
        configuration
      );
    })();
  }, [configuration]);

  return (
    <ConfiguratorContext.Provider
      value={{
        configuration,
        setConfiguration,
        sizeUnit,
      }}
    >
      {props.children}
    </ConfiguratorContext.Provider>
  );
};
