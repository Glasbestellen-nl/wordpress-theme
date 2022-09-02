const { useContext, useEffect, useState } = wp.element;
import { showModalForm } from "../../main/functions";
import { validateBasic, validateByRules } from "../services/validation";
import { formatTextBySizeUnit } from "../services/sizeUnit";
import { getStepsData } from "../services/steps";
import { addConfigurationToCart } from "../services/configuration";
import { ConfiguratorContext } from "../context/ConfiguratorContext";
import Step from "./Step";

const Configurator = () => {
  const steps = getStepsData().filter((step) => !step.parent_step);
  const {
    configuration,
    totalPriceHtml,
    submitting,
    setSubmitting,
    sizeUnit,
    invalidFields,
    setInvalidFields,
  } = useContext(ConfiguratorContext);
  const [quantity, setQuantity] = useState(1);
  const [message, setMessage] = useState("");

  useEffect(() => {
    // Elements outside of react
    jQuery(".js-configurator-cart-button").on("click", (e) => {
      handleSubmitButtonClick(e);
    });
    jQuery(".js-configurator-save-button").on("click", (e) => {
      handleSaveButtonClick(e);
    });
  }, []);

  useEffect(() => {
    if (totalPriceHtml !== "")
      // Temporary set total price with jQuery
      jQuery(".js-config-total-price").html(totalPriceHtml);
  }, [totalPriceHtml]);

  const isValidForm = () => {
    console.log(invalidFields);
    return Object.keys(invalidFields).length === 0;
  };

  const handleSubmitButtonClick = async (e) => {
    e.preventDefault();
    validateForm();
    if (!isValidForm()) return;
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
  };

  const handleSaveButtonClick = () => {
    validateForm();
    if (!isValidForm()) return;
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
    const invalid = {};
    steps?.forEach((step) => {
      const { id, required, rules } = step;
      const value = configuration[id];
      const { valid, message } = validate(value, required, rules, sizeUnit);
      if (!valid) (invalid[id] = formatTextBySizeUnit(message)), sizeUnit;
    });
    setInvalidFields((prevFields) => ({
      ...prevFields,
      ...invalid,
    }));
  };

  return (
    <>
      {steps.map((step) => {
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
        >
          {(!submitting && "In winkelwagen") || "Een moment.."}
        </button>
      </div>
      <div className="configurator__form-button space-below">
        <span
          className="btn btn--block btn--aside"
          onClick={handleSaveButtonClick}
        >
          <i class="fas fa-file-import"></i> &nbsp;&nbsp; Mail mij een offerte
        </span>
      </div>
    </>
  );
};

export default Configurator;
