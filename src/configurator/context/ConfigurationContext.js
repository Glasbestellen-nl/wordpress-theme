const { createContext, useState, useEffect } = wp.element;
import {
  getConfiguration,
  storeConfiguration,
} from "../services/configuration";

export const ConfigurationContext = createContext();

export const ConfigurationProvider = (props) => {
  const [configuration, setConfiguration] = useState({});

  useEffect(() => {
    (async () => {
      try {
        const response = await getConfiguration(window.gb.configuratorId);
        if (response && response.data && response.data.configuration) {
          setConfiguration(response.data.configuration);
        }
      } catch (err) {
        console.error(err);
      }
    })();
  }, []);

  useEffect(() => {
    (async () => {
      try {
        await storeConfiguration(window.gb.configuratorId, configuration);
      } catch (err) {
        console.error(err);
      }
    })();
  }, [configuration]);

  return (
    <ConfigurationContext.Provider value={{ configuration, setConfiguration }}>
      {props.children}
    </ConfigurationContext.Provider>
  );
};
