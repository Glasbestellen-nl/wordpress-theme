const { createContext, useState, useEffect, useContext } = wp.element;
import { getConfiguration } from "../services/configuration";
export const ConfiguratorContext = createContext();

export const ConfiguratorProvider = (props) => {
  const [sizeUnit, setSizeUnit] = useState("mm");
  const [configuration, setConfiguration] = useState({});
  const [collapsedSteps, setCollapsedSteps] = useState([
    "makeup_mirror_type_lit",
    "makeup_mirror_type_unlit",
  ]);

  useEffect(() => {
    (async () => {
      const response = await getConfiguration(window.gb.configuratorId);
      if (response.data && response.data.configuration) {
        //console.log(response.data.configuration);
        // setConfiguration(response.data.configuration);
        // console.log(response.data.configuration);
      }
    })();
  }, []);

  return (
    <ConfiguratorContext.Provider
      value={{
        configuration,
        setConfiguration,
        collapsedSteps,
        setCollapsedSteps,
        sizeUnit,
        setSizeUnit,
      }}
    >
      {props.children}
    </ConfiguratorContext.Provider>
  );
};
