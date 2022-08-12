/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/configurator/components/Configurator.js":
/*!*****************************************************!*\
  !*** ./src/configurator/components/Configurator.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _context_SettingsContext__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../context/SettingsContext */ "./src/configurator/context/SettingsContext.js");
/* harmony import */ var _Step__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Step */ "./src/configurator/components/Step.js");

const {
  useContext
} = wp.element;



const Configurator = () => {
  const {
    steps
  } = useContext(_context_SettingsContext__WEBPACK_IMPORTED_MODULE_1__.SettingsContext);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, steps.map(step => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Step__WEBPACK_IMPORTED_MODULE_2__["default"], {
    key: step.id,
    step: step
  })));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Configurator);

/***/ }),

/***/ "./src/configurator/components/Field_Dropdown.js":
/*!*******************************************************!*\
  !*** ./src/configurator/components/Field_Dropdown.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Option__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Option */ "./src/configurator/components/Option.js");



const Field_Dropdown = props => {
  const {
    options
  } = props;

  const getDefault = () => {
    if (!options || options.length == 0) return;
    return options.find(option => option.default);
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("select", {
    class: "dropdown configurator__dropdown configurator__form-control"
  }, !getDefault() && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", null, "Geen"), options && options.length > 0 && options.map(option => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Option__WEBPACK_IMPORTED_MODULE_1__["default"], {
    key: option.id,
    option: option
  })));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Field_Dropdown);

/***/ }),

/***/ "./src/configurator/components/Field_Number.js":
/*!*****************************************************!*\
  !*** ./src/configurator/components/Field_Number.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _context_SettingsContext__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../context/SettingsContext */ "./src/configurator/context/SettingsContext.js");

const {
  useContext
} = wp.element;


const Field_Number = () => {
  const {
    sizeUnit
  } = useContext(_context_SettingsContext__WEBPACK_IMPORTED_MODULE_1__.SettingsContext);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "number",
    className: "form-control configurator__form-control",
    placeholder: sizeUnit
  });
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Field_Number);

/***/ }),

/***/ "./src/configurator/components/Option.js":
/*!***********************************************!*\
  !*** ./src/configurator/components/Option.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);


const Option = _ref => {
  let {
    option
  } = _ref;
  const {
    id,
    title,
    value
  } = option;

  const getId = () => {
    return id;
  };

  const getTitle = () => {
    return title;
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
    value: getId()
  }, getTitle());
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Option);

/***/ }),

/***/ "./src/configurator/components/Step.js":
/*!*********************************************!*\
  !*** ./src/configurator/components/Step.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Field_Number__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Field_Number */ "./src/configurator/components/Field_Number.js");
/* harmony import */ var _Field_Dropdown__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Field_Dropdown */ "./src/configurator/components/Field_Dropdown.js");




const Step = _ref => {
  let {
    step
  } = _ref;
  const {
    title,
    required,
    options,
    description
  } = step;

  const isRequired = () => {
    return required && options && options.length == 0 || required && options && options.length > 0 && options.length > 1;
  };

  const getDescriptionId = () => {
    return description && description.id;
  };

  const hasOptions = () => {
    return options && options.length > 0;
  };

  const renderInputField = () => {
    if (hasOptions()) {
      if (options.length == 1 && isRequired()) {
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, options[0].title), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
          type: "hidden",
          value: "",
          class: "js-input-hidden"
        }));
      } else {
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Field_Dropdown__WEBPACK_IMPORTED_MODULE_2__["default"], {
          options: options
        });
      }
    } else {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Field_Number__WEBPACK_IMPORTED_MODULE_1__["default"], null);
    }
  };

  const getInputRowClasses = () => {
    const classes = ["configurator__form-col", "configurator__form-input"];

    if (hasOptions() && options.length == 1 && isRequired()) {
      classes.push("configurator__form-input--default");
    }

    return classes.join(" ");
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "configurator__form-row"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "configurator__form-col"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "configurator__form-label",
    "data-explanation-id": getDescriptionId()
  }, title), " ", isRequired() && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, "*")), getDescriptionId() && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "configurator__form-col configurator__form-info"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("i", {
    className: "fas fa-info-circle configurator__info-icon js-popup-explanation",
    "data-explanation-id": getDescriptionId()
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: getInputRowClasses()
  }, renderInputField(), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "invalid-feedback js-invalid-feedback"
  })));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Step);

/***/ }),

/***/ "./src/configurator/context/SettingsContext.js":
/*!*****************************************************!*\
  !*** ./src/configurator/context/SettingsContext.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "SettingsContext": () => (/* binding */ SettingsContext),
/* harmony export */   "SettingsProvider": () => (/* binding */ SettingsProvider)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const {
  createContext,
  useState,
  useEffect
} = wp.element;
const SettingsContext = createContext();
const SettingsProvider = props => {
  const [settings, setSettings] = useState({
    steps: [],
    sizeUnit: "mm"
  });
  useEffect(() => {
    if (window.gb && window.gb.configuratorSettings) {
      const data = window.gb.configuratorSettings;
      if (data.sizeUnit) setSettings(prevState => {
        return { ...prevState,
          sizeUnit: data.size
        };
      });
      if (data.steps) setSettings(prevState => {
        return { ...prevState,
          steps: data.steps
        };
      });
    }
  }, [window.gb.configuratorSettings]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SettingsContext.Provider, {
    value: { ...settings,
      setSettings
    }
  }, props.children);
};

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***********************************!*\
  !*** ./src/configurator/index.js ***!
  \***********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _context_SettingsContext__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./context/SettingsContext */ "./src/configurator/context/SettingsContext.js");
/* harmony import */ var _components_Configurator__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/Configurator */ "./src/configurator/components/Configurator.js");

const {
  render
} = wp.element;



if (document.getElementById("react_configurator")) {
  render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_context_SettingsContext__WEBPACK_IMPORTED_MODULE_1__.SettingsProvider, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_Configurator__WEBPACK_IMPORTED_MODULE_2__["default"], null)), document.getElementById("react_configurator"));
}
})();

/******/ })()
;
//# sourceMappingURL=configurator.js.map