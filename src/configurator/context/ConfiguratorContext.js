const { createContext, useState, useEffect, useContext } = wp.element;
import {
  getConfiguration,
  storeConfiguration,
} from "../services/configuration";

export const ConfiguratorContext = createContext();

export const ConfiguratorProvider = (props) => {
  const [sizeUnit, setSizeUnit] = useState("mm");
  const [steps, setSteps] = useState([]);

  useEffect(() => {
    // if (window.gb.configuratorSettings) {
    //   if (data.sizeUnit) setSizeUnit(data.sizeUnit);
    // }

    (async () => {
      try {
        if (window.gb.configuratorSettings) {
          const settings = window.gb.configuratorSettings;
          let steps = settings.steps;
          const response = await getConfiguration(window.gb.configuratorId);
          if (response && response.data && response.data.configuration) {
            const configuration = response.data.configuration;
            steps = steps.map((step) => {
              if (configuration[step.id]) {
                step.value = configuration[step.id];
              }
              return step;
            });
          }
          if (steps) setSteps(steps);
        }
      } catch (err) {
        console.error(err);
      }
    })();
  }, []);

  useEffect(() => {
    (async () => {
      try {
        const configuration = {};
        steps.forEach((step) => {
          configuration[step.id] = step.value;
        });
        const response = await storeConfiguration(
          window.gb.configuratorId,
          configuration
        );
      } catch (err) {
        console.error(err);
      }
    })();
  }, [steps]);

  return (
    <ConfiguratorContext.Provider
      value={{ steps, setSteps, sizeUnit, setSizeUnit }}
    >
      {props.children}
    </ConfiguratorContext.Provider>
  );
};
