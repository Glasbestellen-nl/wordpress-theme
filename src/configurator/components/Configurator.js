const { useContext, useEffect, useState, useRef } = wp.element;
import { showModalForm } from "../../main/functions";
import { validateBasic, validateByRules } from "../services/validation";
import { formatTextBySizeUnit } from "../services/sizeUnit";
import { getStepsData } from "../services/steps";
import { addConfigurationToCart } from "../services/configuration";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import Step from "./Step";
import StickyBar from "./StickyBar";

const Configurator = () => {
  const steps = getStepsData().filter((step) => !step.parent_step);
  const {
    configuration,
    totalPriceHtml,
    loading,
    submitting,
    setSubmitting,
    sizeUnit,
    invalidFields,
    setInvalidFields,
  } = useContext(ConfiguratorContext);
  const [quantity, setQuantity] = useState(1);
  const [message, setMessage] = useState("");
  const ref = useRef();

  useEffect(() => {
    if (totalPriceHtml !== "")
      // Temporary set total price with jQuery
      jQuery(".js-config-total-price").html(totalPriceHtml);
  }, [totalPriceHtml]);

  const handleSubmitButtonClick = async (e) => {
    e.preventDefault();
    if (!validateForm()) {
      jQuery(".js-configurator-steps").scrollTo(-100);
    } else {
      try {
        setSubmitting(true);
        const response = await addConfigurationToCart(
          window?.configurator?.productId,
          quantity,
          message
        );
        if (response && response.data && response.data.url) {
          setSubmitting(false);
          window.location.replace(response.data.url);
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
      jQuery(".js-configurator-steps").scrollTo(-100);
    } else {
      showModalForm(
        "Samenstelling als offerte ontvangen",
        "save-configuration",
        window?.configurator?.configuratorId,
        () => jQuery(".js-form-content-field").val(message)
      );
    }
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
      const { id, required, rules } = step;
      const value = configuration[id];
      const { valid, message } = validate(value, required, rules, sizeUnit);
      if (!valid) invalid[id] = formatTextBySizeUnit(message, sizeUnit);
    });
    setInvalidFields((prevFields) => {
      return { ...prevFields, ...invalid };
    });
    invalid = { ...invalidFields, ...invalid };
    return Object.keys(invalid).length === 0;
  };

  return (
    <>
      <div className="configurator__form-rows js-configurator-steps" ref={ref}>
        {steps.map((step, index) => {
          return <Step key={step.id} step={step} validate={validate} />;
        })}
        <div className="configurator__form-row">
          <div className="configurator__form-col configurator__form-label">
            <label>Opmerking</label>
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
