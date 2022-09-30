const { useReducer, useEffect, useRef } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";

import {
  initialState,
  configuratorReducer,
} from "../reducers/configuratorReducer";
import { getStepsData } from "../utils/steps";
import { getConfiguration } from "../utils/configuration";

import Step from "./Step";

const Configurator = () => {
  const [state, dispatch] = useReducer(configuratorReducer, initialState);
  const ref = useRef();

  useEffect(() => {
    (async () => {
      const steps = getStepsData();
      const response = await getConfiguration(
        window.configurator.configuratorId
      );
      if (response?.data?.configuration) {
        const { configuration } = response.data;
        dispatch({ type: "init_steps", payload: { steps, configuration } });
      }
    })();
  }, []);

  useEffect(() => {
    //console.log(state.steps);
  }, [state.steps]);

  return (
    <>
      <ConfiguratorContext.Provider value={[state, dispatch]}>
        <div
          className="configurator__form-rows js-configurator-steps"
          ref={ref}
        >
          {state.steps.map((step) => step.active && <Step step={step} />)}
        </div>
      </ConfiguratorContext.Provider>
    </>
  );
};

export default Configurator;
