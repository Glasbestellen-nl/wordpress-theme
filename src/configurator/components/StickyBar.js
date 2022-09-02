const { useContext } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";

const StickyBar = ({ submitButtonHandler, saveButtonHandler }) => {
  const { loading } = useContext(ConfiguratorContext);
  return (
    <div
      className="sticky-bar sticky-bar--desktop-top js-sticky-bar"
      style={{ left: 0 }}
    >
      <div className="container">
        <div className="row d-flex align-items-center">
          <div className="col-4 col-lg-2 offset-lg-6">
            <span className="js-config-total-price d-block text-size-medium text-color-blue text-weight-bold"></span>
            <span className="text-size-tiny text-color-grey">
              Prijs incl. BTW.
            </span>
          </div>
          <div className="col-7 offset-1 col-lg-4 offset-lg-0">
            <div className="d-flex">
              <button
                className="btn btn--block btn--primary btn--tiny"
                onClick={submitButtonHandler}
                disabled={loading}
              >
                In winkelwagen
              </button>
              <button
                className="d-none d-md-flex align-items-center justify-content-center btn btn--block btn--aside js-configurator-save-button small-space-left"
                data-popup-title=""
                data-formtype="save-configuration"
                data-meta=""
                onClick={saveButtonHandler}
                disabled={loading}
              >
                <i className="fas fa-file-import"></i> &nbsp;&nbsp; Offerte
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default StickyBar;
