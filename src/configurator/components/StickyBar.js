const { useContext, useRef, useEffect, useState } = wp.element;
import { ConfiguratorContext } from "../context/ConfiguratorContext";

const StickyBar = ({
  submitButtonHandler,
  saveButtonHandler,
  scrollTargetRef,
  disableQuoteButton,
}) => {
  const [visible, setVisible] = useState(false);
  const ref = useRef(null);
  const [state] = useContext(ConfiguratorContext);

  useEffect(() => {
    const showOnScroll = () => {
      const viewportTop = window.scrollY;
      const elementTop = scrollTargetRef.current.offsetTop;
      if (viewportTop > elementTop) {
        setVisible(true);
      } else {
        setVisible(false);
      }
    };
    window.addEventListener("scroll", showOnScroll);
    return () => {
      window.removeEventListener("scroll", showOnScroll);
    };
  }, []);

  return (
    <>
      <div
        ref={ref}
        className="sticky-bar sticky-bar--desktop-top"
        style={{ left: 0, display: visible ? "block" : "none" }}
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
                  disabled={state.loading}
                >
                  In winkelwagen
                </button>
                {!disableQuoteButton && (
                  <button
                    className="d-none d-md-flex align-items-center justify-content-center btn btn--block btn--aside js-configurator-save-button small-space-left"
                    data-popup-title=""
                    data-formtype="save-configuration"
                    data-meta=""
                    onClick={saveButtonHandler}
                    disabled={state.loading}
                  >
                    <i className="fas fa-file-import"></i> &nbsp;&nbsp; Offerte
                  </button>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default StickyBar;
