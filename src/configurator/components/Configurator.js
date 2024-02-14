const { useReducer, useState, useEffect, useRef } = wp.element;
import isEmpty from "lodash/isEmpty";
import isEqual from "lodash/isEqual";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import StickyBar from "./StickyBar";
import {
  initialState,
  configuratorReducer,
} from "../reducers/configuratorReducer";
import { showModalForm } from "../../main/functions";
import { validate } from "../utils/validation";
import { getStepsData, getOptionValue } from "../utils/steps";
import { formatTextBySizeUnit } from "../utils/sizeUnit";
import {
  getConfigurationFromSteps,
  getConfiguration,
  storeConfiguration,
  addConfigurationToCart,
} from "../utils/configuration";

import Step from "./Step";

const Configurator = () => {
  const settings = window.configurator;
  const [state, dispatch] = useReducer(configuratorReducer, initialState);
  const ref = useRef();
  const isMounted = useRef(false);
  const [totalPriceHtml, setTotalPriceHtml] = useState("");
  const [configuration, setConfiguration] = useState({});
  const [configInit, setConfigInit] = useState(false);

  useEffect(() => {
    (async () => {
      const steps = getStepsData();
      const response = await getConfiguration(settings.configuratorId);
      if (response?.data?.configuration) {
        const { configuration } = response.data;
        dispatch({ type: "init_steps", payload: { steps, configuration } });
      }
    })();
  }, []);

  useEffect(() => {
    if (!isEmpty(state.steps)) {
      let updatedConfig = getConfigurationFromSteps(state.steps);
      setConfiguration((prevConfig) => {
        return !isEqual(prevConfig, updatedConfig) ? updatedConfig : prevConfig;
      });
    }
  }, [state.steps]);

  useEffect(() => {
    if (isMounted.current && !isEmpty(configuration)) {
      if (configInit) validateForm();
      else setConfigInit(true);
      (async () => {
        try {
          const { productId } = settings;
          // Store configuration in server session and receive total price html
          const response = await storeConfiguration(productId, configuration);
          if (response && response.data && response.data.price_html) {
            setTotalPriceHtml(response.data.price_html);
          }
        } catch (err) {
          console.error(err);
        }
      })();
    } else {
      isMounted.current = true;
    }
  }, [configuration]);

  useEffect(() => {
    if (!isEmpty(totalPriceHtml)) updatePriceOutsideConfigurator();
  }, [totalPriceHtml]);

  const handleSubmitButtonClick = async (e) => {
    e.preventDefault();
    if (!validateForm()) {
      scrollToInvalidFields();
    } else {
      try {
        dispatch({ type: "submitting", payload: true });
        const cartUrl = await addToCart();
        if (cartUrl) {
          window.location.replace(cartUrl);
        }
      } catch (err) {
        dispatch({ type: "submitting", payload: false });
        console.error(err);
      }
    }
  };

  const handleSaveButtonClick = async (e) => {
    e.preventDefault();
    if (!validateForm()) {
      scrollToInvalidFields();
    } else {
      showSaveButtonModal();
    }
  };

  const validateForm = () => {
    let invalidSteps = [];
    state.steps.forEach((step) => {
      const { id, required, options, rules, active } = step;
      if (active) {
        let value = step.value;
        if (options) {
          const optionValue = getOptionValue(id, value);
          if (optionValue) value = optionValue;
          invalidSteps = [...invalidSteps, ...getInvalidOptionCombinations(id)];
        }
        const { valid, message } = validate(
          value,
          required,
          rules,
          configuration,
          state.sizeUnit
        );
        if (!valid)
          invalidSteps.push({
            id,
            message: formatTextBySizeUnit(message, state.sizeUnit),
          });
      }
    });
    dispatch({ type: "update_invalid_steps", payload: invalidSteps });
    return invalidSteps.length === 0;
  };

  const getSelectedOption = (id) => {
    const step = state.steps.find((step) => step.id === id);
    if (!step || !step.options || !step.value) return;
    return step.options.find((option) => option.id === step.value);
  };

  const getInvalidOptionCombinations = (id) => {
    let invalid = [];
    if (configuration[id]) {
      const selectedOption = getSelectedOption(id);
      if (!selectedOption || !selectedOption.rules) return invalid;
      const { exclude } = selectedOption.rules;
      if (!exclude) return invalid;
      exclude.forEach((rule) => {
        const { step, options, message } = rule;
        if (configuration[step]) {
          const compareConfig = configuration[step];
          if (options.includes(compareConfig)) {
            invalid.push({
              id,
              message: formatTextBySizeUnit(message, state.sizeUnit),
            });
          }
        }
      });
    }
    return invalid;
  };

  const addToCart = async () => {
    const response = await addConfigurationToCart(
      window?.configurator?.productId,
      state.quantity,
      state.message
    );
    return response?.data?.url;
  };

  const scrollToInvalidFields = () => {
    jQuery(".js-invalid-configurator-step").scrollTo(-100); // Temporary set with jQuery
  };

  const updatePriceOutsideConfigurator = () => {
    jQuery(".js-config-total-price").html(totalPriceHtml); // Temporary set with jQuery
  };

  const showSaveButtonModal = () => {
    showModalForm(
      "Samenstelling als offerte ontvangen",
      "save-configuration",
      settings.configuratorId,
      () => jQuery(".js-form-content-field").val(state.message) // Temporary set with jQuery
    );
  };

  return (
    <>
      <ConfiguratorContext.Provider value={[state, dispatch]}>
        <div
          className="configurator__form-rows js-configurator-steps"
          ref={ref}
        >
          {state.steps.map((step) => step.active && <Step step={step} />)}
        </div>
        <div className="configurator__form-row">
          <div className="configurator__form-col configurator__form-label">
            <label>{`Opmerking`}</label>
          </div>

          <div className="configurator__form-col configurator__form-input">
            <textarea
              class="form-control"
              placeholder={`Maximaal ${235} karakters`}
              maxlength="235"
              onChange={(e) =>
                dispatch({ type: "update_message", payload: e.target.value })
              }
              value={state.message}
            ></textarea>
          </div>
        </div>
        <div className="configurator__form-row space-below">
          <div className="configurator__form-col configurator__form-label">
            <label>Aantal</label>
          </div>
          <div className="configurator__form-col configurator__form-input">
            <select
              className="dropdown configurator__form-control"
              onChange={(e) =>
                dispatch({ type: "update_quantity", payload: e.target.value })
              }
              value={state.quantity}
            >
              {(() => {
                const options = [];
                for (let number = 1; number <= 10; number++) {
                  options.push(<option value={number}>{number}</option>);
                }
                return options;
              })()}
            </select>
          </div>
        </div>
        <div className="configurator__form-button small-space-below">
          <button
            className="btn btn--primary btn--block btn--next"
            onClick={handleSubmitButtonClick}
            disabled={state.loading}
          >
            {(!state.submitting && "In winkelwagen") || "Een moment.."}
          </button>
        </div>
        {!settings.quotationDisabled && (
          <div className="configurator__form-button space-below">
            <button
              className="btn btn--block btn--aside"
              onClick={handleSaveButtonClick}
              disabled={state.loading}
            >
              <i class="fas fa-file-import"></i> &nbsp;&nbsp; Mail mij een
              offerte
            </button>
          </div>
        )}

        <StickyBar
          submitButtonHandler={handleSubmitButtonClick}
          saveButtonHandler={handleSaveButtonClick}
          scrollTargetRef={ref}
        />
      </ConfiguratorContext.Provider>
    </>
  );
};

export default Configurator;
