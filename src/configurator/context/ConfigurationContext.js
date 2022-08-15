const { createContext, useState, useEffect, useContext } = wp.element;
import { SettingsContext } from "./SettingsContext";
import {
  getConfiguration,
  storeConfiguration,
} from "../services/configuration";

export const ConfigurationContext = createContext();

export const ConfigurationProvider = (props) => {
  const { steps } = useContext(SettingsContext);
  const [configuration, setConfiguration] = useState({});

  const filterConfiguration = (configuration) => {
    return Object.fromEntries(
      Object.entries(configuration).filter((row) => {
        const id = row[0];
        const step = steps.find((step) => id == step.id);
        if (step && step.parent_step) {
          const parentId = step.parent_step;
          const parentStep = steps.find((step) => parentId == step.id);
          if (
            parentStep &&
            parentStep.options &&
            parentStep.options.length > 0
          ) {
            const activeOption = parentStep.options.find(
              (option) => option.id == configuration[parentId]
            );
            if (activeOption && activeOption.child_steps) {
              if (Array.isArray(activeOption.child_steps)) {
                return activeOption.child_steps.includes(id);
              } else {
                return activeOption.child_steps == id;
              }
            }
          }
        }
        return true;
      })
    );
  };

  const updateConfiguration = (configuration) => {
    setConfiguration((prevConfiguration) => ({
      ...prevConfiguration,
      ...configuration,
    }));
  };

  useEffect(() => {
    (async () => {
      try {
        const response = await getConfiguration(window.gb.configuratorId);
        if (response && response.data && response.data.configuration) {
          //console.log(response.data.configuration);
          const filteredConfiguration = filterConfiguration(
            response.data.configuration
          );
          //console.log(filteredConfiguration);
          setConfiguration(filteredConfiguration);
        }
      } catch (err) {
        console.error(err);
      }
    })();
  }, [steps]);

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
    <ConfigurationContext.Provider
      value={{ configuration, updateConfiguration }}
    >
      {props.children}
    </ConfigurationContext.Provider>
  );
};
