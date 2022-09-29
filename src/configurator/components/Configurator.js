const { useEffect, useState, useRef, useReducer } = wp.element;
import {
  configuratorReducer,
  initialState,
} from "../reducers/configuratorReducer";
import { getStepsData, getStepsMap, getOptionValue } from "../utils/steps";
import {
  addConfigurationToCart,
  storeConfiguration,
  getConfiguration,
} from "../utils/configuration";
import { formatTextBySizeUnit } from "../utils/sizeUnit";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import { showModalForm } from "../../main/functions";
import { validateBasic, validateByRules } from "../utils/validation";
import Step from "./Step";
import StickyBar from "./StickyBar";

const stepsMap = getStepsMap();
const steps = getStepsData().filter((step) => !step.parent_step);

const Configurator = () => {
  const [state, dispatch] = useReducer(configuratorReducer, initialState);
  const ref = useRef();
  const isMounted = useRef(false);
  const [configInit, setConfigInit] = useState(false);
  const [totalPriceHtml, setTotalPriceHtml] = useState("");

  useEffect(() => {
    (async () => {
      const response = await getConfiguration(
        window.configurator.configuratorId
      );
      if (response?.data?.configuration) {
        let configuration = response.data.configuration;

        // Filter configuration on steps with parent on mount
        const parentStepIds = steps.map((step) => step.id);
        for (const property in configuration) {
          if (!parentStepIds.includes(property)) {
            delete configuration[property];
          }
        }
        dispatch({
          type: "set_configuration",
          payload: configuration,
        });
      }
    })();
  }, []);

  useEffect(() => {
    console.log(state.configuration);
  }, [state.configuration]);

  useEffect(() => {
    if (totalPriceHtml !== "") updatePriceOutsideConfigurator();
  }, [totalPriceHtml]);

  useEffect(() => {
    if (isMounted.current && state.configuration) {
      // To not validate when loading for first time
      if (configInit) validateForm();
      else setConfigInit(true);

      (async () => {
        try {
          const { productId } = window.configurator;
          // Store configuration in server session and receive total price html
          const response = await storeConfiguration(
            productId,
            state.configuration
          );
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
  }, [state.configuration]);

  const handleSubmitButtonClick = async (e) => {
    e.preventDefault();
    if (!validateForm()) {
      scrollToInvalidFields();
    } else {
      try {
        dispatch({ type: "submitting", payload: true });
        const cartUrl = await addToCart();
        if (cartUrl) {
          dispatch({ type: "submitting", payload: false });
          window.location.replace(cartUrl);
        }
      } catch (err) {
        dispatch({ type: "submitting", payload: false });
        console.err(err);
      }
    }
  };

  const handleSaveButtonClick = (e) => {
    e.preventDefault();
    if (!validateForm()) {
      scrollToInvalidFields();
    } else {
      showSaveButtonModal();
    }
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
    jQuery(".js-configurator-steps").scrollTo(-100); // Temporary set with jQuery
  };

  const updatePriceOutsideConfigurator = () => {
    jQuery(".js-config-total-price").html(totalPriceHtml); // Temporary set with jQuery
  };

  const showSaveButtonModal = () => {
    showModalForm(
      "Samenstelling als offerte ontvangen",
      "save-configuration",
      window?.configurator?.configuratorId,
      () => jQuery(".js-form-content-field").val(state.message) // Temporary set with jQuery
    );
  };

  const validate = (value, required, rules, sizeUnit) => {
    let validationResult = required
      ? validateBasic(value)
      : { valid: true, message: "" };
    if (validationResult.valid) {
      if (rules)
        validationResult = validateByRules(
          value,
          rules,
          state.configuration,
          sizeUnit
        );
    }
    return validationResult;
  };

  const validateForm = () => {
    let invalid = {};
    steps?.forEach((step) => {
      const { id, required, options, rules } = step;
      let value = state.configuration[id];
      if (options) {
        const optionValue = getOptionValue(id, value);
        if (optionValue) value = optionValue;
        invalid = { ...invalid, ...getInvalidOptionCombinations(id) };
      }
      const { valid, message } = validate(
        value,
        required,
        rules,
        state.sizeUnit
      );
      if (!valid) invalid[id] = formatTextBySizeUnit(message, state.sizeUnit);
    });
    dispatch({ type: "set_invalid_fields", payload: invalid });
    return Object.keys(invalid).length === 0;
  };

  const getInvalidOptionCombinations = (id) => {
    let invalid = {};
    if (state.configuration[id]) {
      const selectedOption = getSelectedOption(id);
      if (!selectedOption || !selectedOption.rules) return invalid;
      const { exclude } = selectedOption.rules;
      if (!exclude) return invalid;
      exclude?.forEach((rule) => {
        const { step, options, message } = rule;
        if (state.configuration[step]) {
          const compareConfig = state.configuration[step];
          if (options.includes(compareConfig)) {
            invalid[id] = formatTextBySizeUnit(message, state.sizeUnit);
          }
        }
      });
    }
    return invalid;
  };

  const getSelectedOption = (id) => {
    if (!stepsMap[id] || !stepsMap[id].options || !state.configuration[id])
      return;
    return stepsMap[id].options.find(
      (option) => option.id === state.configuration[id]
    );
  };

  return (
    <>
      <ConfiguratorContext.Provider value={[state, dispatch]}>
        <div
          className="configurator__form-rows js-configurator-steps"
          ref={ref}
        >
          {steps.map((step) => {
            return (
              <Step
                key={step.id}
                step={step}
                validate={validate}
                getSelectedOption={getSelectedOption}
              />
            );
          })}
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
        </div>
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
