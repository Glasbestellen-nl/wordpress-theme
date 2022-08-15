const { createContext, useState, useEffect } = wp.element;

export const SettingsContext = createContext();

export const SettingsProvider = (props) => {
  const [settings, setSettings] = useState({
    steps: [],
    sizeUnit: "mm",
  });

  const setSizeUnit = (sizeUnit) => {
    setSettings((prevState) => {
      return { ...prevState, sizeUnit };
    });
  };

  const setSteps = (steps) => {
    setSettings((prevState) => {
      return { ...prevState, steps };
    });
  };

  useEffect(() => {
    if (window.gb.configuratorSettings) {
      const data = window.gb.configuratorSettings;
      if (data.sizeUnit) setSizeUnit(data.sizeUnit);
      if (data.steps) setSteps(data.steps);
    }
  }, []);

  return (
    <SettingsContext.Provider value={{ ...settings, setSettings }}>
      {props.children}
    </SettingsContext.Provider>
  );
};
