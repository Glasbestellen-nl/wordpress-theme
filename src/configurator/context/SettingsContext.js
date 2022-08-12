const { createContext, useState, useEffect } = wp.element;

export const SettingsContext = createContext();

export const SettingsProvider = (props) => {
  const [settings, setSettings] = useState({
    steps: [],
    sizeUnit: "mm",
  });

  useEffect(() => {
    if (window.gb && window.gb.configuratorSettings) {
      const data = window.gb.configuratorSettings;
      if (data.sizeUnit)
        setSettings((prevState) => {
          return { ...prevState, sizeUnit: data.size };
        });
      if (data.steps)
        setSettings((prevState) => {
          return { ...prevState, steps: data.steps };
        });
    }
  }, [window.gb.configuratorSettings]);

  return (
    <SettingsContext.Provider value={{ ...settings, setSettings }}>
      {props.children}
    </SettingsContext.Provider>
  );
};
