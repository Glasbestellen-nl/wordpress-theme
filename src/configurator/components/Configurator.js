const { useContext, useEffect, useState, useRef } = wp.element;
import { showModalForm } from "../../main/functions";
import { validateBasic, validateByRules } from "../utils/validation";
import { formatTextBySizeUnit } from "../utils/sizeUnit";
import { getStepsData, getStepsMap, getOptionValue } from "../utils/steps";
import {
  addConfigurationToCart,
  storeConfiguration,
} from "../utils/configuration";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import Step from "./Step";
import StickyBar from "./StickyBar";

const stepsMap = getStepsMap();

const Configurator = () => {
  const steps = getStepsData().filter((step) => !step.parent_step);
  const {
    configuration,
    totalPriceHtml,
    setTotalPriceHtml,
    loading,
    submitting,
    setSubmitting,
    sizeUnit,
    setInvalidFields,
  } = useContext(ConfiguratorContext);
  const [quantity, setQuantity] = useState(1);
  const [message, setMessage] = useState("");
  const ref = useRef();

  useEffect(() => {
    if (totalPriceHtml !== "") updatePriceOutsideConfigurator();
  }, [totalPriceHtml]);

  useEffect(() => {
    if (configuration) {
      validateForm();
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
    }
  }, [configuration, firstValidation]);

  const handleSubmitButtonClick = async (e) => {
    e.preventDefault();
    if (!validateForm()) {
      scrollToInvalidFields();
    } else {
      try {
        setSubmitting(true);
        const cartUrl = await addToCart();
        if (cartUrl) {
          setSubmitting(false);
          window.location.replace(cartUrl);
        }
      } catch (err) {
        setSubmitting(false);
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

  const updatePriceOutsideConfigurator = () => {
    jQuery(".js-config-total-price").html(totalPriceHtml); // Temporary set with jQuery
  };

  const addToCart = async () => {
    const response = await addConfigurationToCart(
      window?.configurator?.productId,
      quantity,
      message
    );
    return response?.data?.url;
  };

  const scrollToInvalidFields = () => {
    jQuery(".js-configurator-steps").scrollTo(-100);
  };

  const showSaveButtonModal = () => {
    showModalForm(
      "Samenstelling als offerte ontvangen",
      "save-configuration",
      window?.configurator?.configuratorId,
      () => jQuery(".js-form-content-field").val(message)
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
          configuration,
          sizeUnit
        );
    }
    return validationResult;
  };

  const validateForm = () => {
    let invalid = {};
    steps?.forEach((step) => {
      const { id, required, options, rules } = step;
      let value = configuration[id];
      if (options) {
        const optionValue = getOptionValue(id, value);
        if (optionValue) value = optionValue;
        invalid = { ...invalid, ...getInvalidOptionCombinations(id) };
      }
      const { valid, message } = validate(value, required, rules, sizeUnit);
      if (!valid) invalid[id] = formatTextBySizeUnit(message, sizeUnit);
    });
    setInvalidFields(invalid);
    return Object.keys(invalid).length === 0;
  };

  const getInvalidOptionCombinations = (id) => {
    let invalid = {};
    if (configuration[id]) {
      const selectedOption = getSelectedOption(id);
      if (!selectedOption || !selectedOption.rules) return invalid;
      const { exclude } = selectedOption.rules;
      if (!exclude) return invalid;
      exclude?.forEach((rule) => {
        const { step, options, message } = rule;
        if (configuration[step]) {
          const compareConfig = configuration[step];
          if (options.includes(compareConfig)) {
            invalid[id] = formatTextBySizeUnit(message, sizeUnit);
          }
        }
      });
    }
    return invalid;
  };

  const getSelectedOption = (id) => {
    if (!stepsMap[id] || !stepsMap[id].options || !configuration[id]) return;
    return stepsMap[id].options.find(
      (option) => option.id === configuration[id]
    );
  };

  return (
    <>
      <div className="configurator__form-rows js-configurator-steps" ref={ref}>
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
              onChange={(e) => setMessage(e.target.value)}
              value={message}
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
              onChange={(e) => setQuantity(e.target.value)}
              value={quantity}
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
            disabled={loading}
          >
            {(!submitting && "In winkelwagen") || "Een moment.."}
          </button>
        </div>
        <div className="configurator__form-button space-below">
          <button
            className="btn btn--block btn--aside"
            onClick={handleSaveButtonClick}
            disabled={loading}
          >
            <i class="fas fa-file-import"></i> &nbsp;&nbsp; Mail mij een offerte
          </button>
        </div>
      </div>
      <StickyBar
        submitButtonHandler={handleSubmitButtonClick}
        saveButtonHandler={handleSaveButtonClick}
        scrollTargetRef={ref}
      />
    </>
  );
};

export default Configurator;
