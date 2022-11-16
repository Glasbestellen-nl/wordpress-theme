/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/main/components/FileUploader.js":
/*!*********************************************!*\
  !*** ./src/main/components/FileUploader.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const {
  useRef,
  useState
} = wp.element;

const FileUploader = _ref => {
  let {
    files,
    addFilesHandler,
    removeFileHandler
  } = _ref;
  const fileFieldRef = useRef();
  const [error, setError] = useState(false);
  const headClassNames = ["p-2 flex border border-gray-300 bg-[#fcfcfc] rounded-tl rounded-tr"];

  if (files.length === 0) {
    headClassNames.push("rounded-bl rounded-br");
  }

  const handleSelectButtonClick = e => {
    e.preventDefault();
    fileFieldRef.current.click();
  };

  const handleChange = e => {
    setError(false);
    const newFiles = e.target.files;
    if (!newFiles) return;
    const maxCombinedFileSize = 8000000;
    const allowedFileTypes = window.gb.allowedFileTypes;
    let combinedFileSize = 0;
    let notAllowedFileType = false; // File size and type check

    [...files, ...newFiles].forEach(file => {
      if (!Object.values(allowedFileTypes).includes(file.type)) notAllowedFileType = file.type;
      combinedFileSize += file.size;
    });

    if (combinedFileSize > maxCombinedFileSize) {
      setError(gb.msg.fileUploadLimit.replace("{0}", maxCombinedFileSize / 1000000));
    } else if (notAllowedFileType) {
      setError(gb.msg.fileTypeNotAllowed.replace("{0}", notAllowedFileType));
    } else {
      addFilesHandler([...newFiles]);
    }
  };

  const handleFileDeleteButtonClick = index => {
    setError(false);
    removeFileHandler(index);
  };

  const formatBytes = function (bytes) {
    let decimals = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 2;
    if (!+bytes) return "0 Bytes";
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, error && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    className: "alert alert--danger mb-2"
  }, error), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "shadow-sm"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: headClassNames.join(" ")
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    className: "px-3 py-2 border border-gray-300 rounded text-sm shadow-sm bg-white",
    onClick: handleSelectButtonClick
  }, "Selecteer bijlage(s)"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "file",
    className: "hidden",
    ref: fileFieldRef,
    onChange: handleChange,
    multiple: true
  })), files && files.length > 0 && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "border border-t-0 border-gray-300 rounded-bl rounded-br"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", null, files.map((file, index) => {
    const fileName = file.name.length > 30 ? file.name.slice(0, 30) + "..." : file.name;
    const fileSize = formatBytes(file.size);
    const classNames = ["py-3 px-4 flex justify-between"];

    if (index + 1 != files.length) {
      classNames.push("border-b border-gray-300");
    }

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      className: classNames.join(" "),
      key: index
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      className: "text-sm"
    }, `${fileName} (${fileSize})`)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "flex items-center",
      onClick: () => handleFileDeleteButtonClick(index)
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 512 512",
      className: "w-5 fill-[#eb4240] cursor-pointer"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      d: "M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"
    }), " ")));
  })))));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (FileUploader);

/***/ }),

/***/ "./src/main/components/LeadForm.js":
/*!*****************************************!*\
  !*** ./src/main/components/LeadForm.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../functions */ "./src/main/functions.js");
/* harmony import */ var _FileUploader__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FileUploader */ "./src/main/components/FileUploader.js");

const {
  useReducer
} = wp.element;


const initialState = {
  errors: {},
  valid: {},
  fields: {
    message: "",
    name: "",
    email: "",
    place: "",
    phone: ""
  },
  files: []
};

const reducer = (state, action) => {
  const {
    type,
    payload
  } = action;

  switch (type) {
    case "add_files":
      return { ...state,
        files: [...state.files, ...payload.files]
      };

    case "remove_file":
      return { ...state,
        files: state.files.filter((file, i) => i !== payload.index)
      };

    case "set_field":
      return { ...state,
        fields: { ...state.fields,
          [payload.name]: payload.value
        }
      };

    case "set_field_error":
      return { ...state,
        errors: { ...state.errors,
          [payload.name]: payload.message
        },
        valid: { ...state.valid,
          [payload.name]: false
        }
      };

    case "set_field_valid":
      return { ...state,
        valid: { ...state.valid,
          [payload.name]: true
        },
        errors: { ...state.errors,
          [payload.name]: false
        }
      };

    default:
      return state;
  }
};

const LeadForm = () => {
  const [state, dispatch] = useReducer(reducer, initialState);

  const addFilesHandler = files => {
    dispatch({
      type: "add_files",
      payload: {
        files
      }
    });
  };

  const removeFileHandler = index => {
    dispatch({
      type: "remove_file",
      payload: {
        index
      }
    });
  };

  const handleChange = e => {
    const name = e.target.name;
    const value = e.target.value;
    dispatch({
      type: "set_field",
      payload: {
        name,
        value
      }
    });
    validate(name, value);
  };

  const validate = (name, value) => {
    let valid = true;
    let errorMessage = "";

    switch (name) {
      case "email":
        if (value.length === 0 || !(0,_functions__WEBPACK_IMPORTED_MODULE_1__.emailIsValid)(value)) {
          valid = false;
          errorMessage = gb.msg.enterValidEmail;
        }

        break;

      case "phone":
        valid = true;
        break;

      default:
        if (value.length === 0) {
          valid = false;
          errorMessage = gb.msg.enterField;
        }

    }

    if (valid && value.length > 0) {
      dispatch({
        type: "set_field_valid",
        payload: {
          name
        }
      });
    } else {
      dispatch({
        type: "set_field_error",
        payload: {
          name,
          message: errorMessage
        }
      });
    }

    return valid;
  };

  const handleSubmitButtonClick = e => {
    e.preventDefault();
    let valid = true;
    const fieldNames = Object.keys(state.fields);
    fieldNames.forEach(name => {
      const value = state.fields[name];

      if (!validate(name, value)) {
        valid = false;
      }
    });

    if (valid) {
      console.log("Go!");
    }
  };

  const getFieldClassName = name => {
    const classNames = [];

    if (state.errors[name]) {
      classNames.push("invalid");
    } else if (state.valid[name]) {
      classNames.push("valid");
    }

    return classNames.join(" ");
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("form", {
    className: "p-6 md:p-8"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "mb-4"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "form-label"
  }, "Beschrijf uw wensen en uw situatie ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "req"
  }, "*")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("textarea", {
    name: "message",
    className: `form-control ${getFieldClassName("message")}`,
    rows: "6",
    placeholder: "Beschrijf uw wensen en uw situatie",
    onChange: handleChange,
    value: state.fields.message
  }), state.errors.message && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "invalid-feedback"
  }, state.errors.message)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "mb-4 grid md:grid-cols-2 gap-5"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: ""
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "form-label"
  }, "Naam: ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "req"
  }, "*")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    name: "name",
    type: "text",
    className: `form-control ${getFieldClassName("name")}`,
    placeholder: "Naam",
    onChange: handleChange,
    value: state.fields.name
  }), state.errors.name && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "invalid-feedback"
  }, state.errors.name)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: ""
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "form-label"
  }, "E-mail: ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "req"
  }, "*")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    name: "email",
    type: "email",
    className: `form-control ${getFieldClassName("email")}`,
    placeholder: "E-mail",
    onChange: handleChange,
    value: state.fields.email
  }), state.errors.email && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "invalid-feedback"
  }, state.errors.email)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: ""
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "form-label"
  }, "Woonplaats: ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "req"
  }, "*")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    name: "place",
    type: "text",
    className: `form-control ${getFieldClassName("place")}`,
    placeholder: "Woonplaats",
    onChange: handleChange,
    value: state.fields.place
  }), state.errors.place && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "invalid-feedback"
  }, state.errors.place)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: ""
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "form-label"
  }, "Telefoonnummer:"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    name: "phone",
    type: "phone",
    className: `form-control ${getFieldClassName("phone")}`,
    placeholder: "Telefoonnummer",
    onChange: handleChange,
    value: state.phone
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "mb-6"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "form-label"
  }, "Voeg foto's of tekeningen toe."), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_FileUploader__WEBPACK_IMPORTED_MODULE_2__["default"], {
    files: state.files,
    addFilesHandler: addFilesHandler,
    removeFileHandler: removeFileHandler
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "flex justify-end"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    className: "btn btn--primary btn--next w-full block md:inline md:w-auto",
    type: "submit",
    onClick: handleSubmitButtonClick
  }, "Verstuur"))));
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (LeadForm);

/***/ }),

/***/ "./src/main/fancybox.js":
/*!******************************!*\
  !*** ./src/main/fancybox.js ***!
  \******************************/
/***/ (function(__unused_webpack_module, exports) {

// @fancyapps/ui/Fancybox v4.0.27
!function (t, e) {
   true ? e(exports) : 0;
}(this, function (t) {
  "use strict";

  function e(t, e) {
    var i = Object.keys(t);

    if (Object.getOwnPropertySymbols) {
      var n = Object.getOwnPropertySymbols(t);
      e && (n = n.filter(function (e) {
        return Object.getOwnPropertyDescriptor(t, e).enumerable;
      })), i.push.apply(i, n);
    }

    return i;
  }

  function i(t) {
    for (var i = 1; i < arguments.length; i++) {
      var n = null != arguments[i] ? arguments[i] : {};
      i % 2 ? e(Object(n), !0).forEach(function (e) {
        r(t, e, n[e]);
      }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(t, Object.getOwnPropertyDescriptors(n)) : e(Object(n)).forEach(function (e) {
        Object.defineProperty(t, e, Object.getOwnPropertyDescriptor(n, e));
      });
    }

    return t;
  }

  function n(t) {
    return n = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
      return typeof t;
    } : function (t) {
      return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
    }, n(t);
  }

  function o(t, e) {
    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
  }

  function a(t, e) {
    for (var i = 0; i < e.length; i++) {
      var n = e[i];
      n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(t, n.key, n);
    }
  }

  function s(t, e, i) {
    return e && a(t.prototype, e), i && a(t, i), Object.defineProperty(t, "prototype", {
      writable: !1
    }), t;
  }

  function r(t, e, i) {
    return e in t ? Object.defineProperty(t, e, {
      value: i,
      enumerable: !0,
      configurable: !0,
      writable: !0
    }) : t[e] = i, t;
  }

  function l(t, e) {
    if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
    t.prototype = Object.create(e && e.prototype, {
      constructor: {
        value: t,
        writable: !0,
        configurable: !0
      }
    }), Object.defineProperty(t, "prototype", {
      writable: !1
    }), e && h(t, e);
  }

  function c(t) {
    return c = Object.setPrototypeOf ? Object.getPrototypeOf : function (t) {
      return t.__proto__ || Object.getPrototypeOf(t);
    }, c(t);
  }

  function h(t, e) {
    return h = Object.setPrototypeOf || function (t, e) {
      return t.__proto__ = e, t;
    }, h(t, e);
  }

  function d(t) {
    if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    return t;
  }

  function u(t, e) {
    if (e && ("object" == typeof e || "function" == typeof e)) return e;
    if (void 0 !== e) throw new TypeError("Derived constructors may only return object or undefined");
    return d(t);
  }

  function f(t) {
    var e = function () {
      if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
      if (Reflect.construct.sham) return !1;
      if ("function" == typeof Proxy) return !0;

      try {
        return Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})), !0;
      } catch (t) {
        return !1;
      }
    }();

    return function () {
      var i,
          n = c(t);

      if (e) {
        var o = c(this).constructor;
        i = Reflect.construct(n, arguments, o);
      } else i = n.apply(this, arguments);

      return u(this, i);
    };
  }

  function v(t, e) {
    for (; !Object.prototype.hasOwnProperty.call(t, e) && null !== (t = c(t)););

    return t;
  }

  function p() {
    return p = "undefined" != typeof Reflect && Reflect.get ? Reflect.get : function (t, e, i) {
      var n = v(t, e);

      if (n) {
        var o = Object.getOwnPropertyDescriptor(n, e);
        return o.get ? o.get.call(arguments.length < 3 ? t : i) : o.value;
      }
    }, p.apply(this, arguments);
  }

  function g(t, e) {
    return function (t) {
      if (Array.isArray(t)) return t;
    }(t) || function (t, e) {
      var i = null == t ? null : "undefined" != typeof Symbol && t[Symbol.iterator] || t["@@iterator"];
      if (null == i) return;
      var n,
          o,
          a = [],
          s = !0,
          r = !1;

      try {
        for (i = i.call(t); !(s = (n = i.next()).done) && (a.push(n.value), !e || a.length !== e); s = !0);
      } catch (t) {
        r = !0, o = t;
      } finally {
        try {
          s || null == i.return || i.return();
        } finally {
          if (r) throw o;
        }
      }

      return a;
    }(t, e) || y(t, e) || function () {
      throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
    }();
  }

  function m(t) {
    return function (t) {
      if (Array.isArray(t)) return b(t);
    }(t) || function (t) {
      if ("undefined" != typeof Symbol && null != t[Symbol.iterator] || null != t["@@iterator"]) return Array.from(t);
    }(t) || y(t) || function () {
      throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
    }();
  }

  function y(t, e) {
    if (t) {
      if ("string" == typeof t) return b(t, e);
      var i = Object.prototype.toString.call(t).slice(8, -1);
      return "Object" === i && t.constructor && (i = t.constructor.name), "Map" === i || "Set" === i ? Array.from(t) : "Arguments" === i || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i) ? b(t, e) : void 0;
    }
  }

  function b(t, e) {
    (null == e || e > t.length) && (e = t.length);

    for (var i = 0, n = new Array(e); i < e; i++) n[i] = t[i];

    return n;
  }

  function x(t, e) {
    var i = "undefined" != typeof Symbol && t[Symbol.iterator] || t["@@iterator"];

    if (!i) {
      if (Array.isArray(t) || (i = y(t)) || e && t && "number" == typeof t.length) {
        i && (t = i);

        var n = 0,
            o = function () {};

        return {
          s: o,
          n: function () {
            return n >= t.length ? {
              done: !0
            } : {
              done: !1,
              value: t[n++]
            };
          },
          e: function (t) {
            throw t;
          },
          f: o
        };
      }

      throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
    }

    var a,
        s = !0,
        r = !1;
    return {
      s: function () {
        i = i.call(t);
      },
      n: function () {
        var t = i.next();
        return s = t.done, t;
      },
      e: function (t) {
        r = !0, a = t;
      },
      f: function () {
        try {
          s || null == i.return || i.return();
        } finally {
          if (r) throw a;
        }
      }
    };
  }

  var w = function (t) {
    return "object" === n(t) && null !== t && t.constructor === Object && "[object Object]" === Object.prototype.toString.call(t);
  },
      k = function t() {
    for (var e = !1, i = arguments.length, o = new Array(i), a = 0; a < i; a++) o[a] = arguments[a];

    "boolean" == typeof o[0] && (e = o.shift());
    var s = o[0];
    if (!s || "object" !== n(s)) throw new Error("extendee must be an object");

    for (var r = o.slice(1), l = r.length, c = 0; c < l; c++) {
      var h = r[c];

      for (var d in h) if (h.hasOwnProperty(d)) {
        var u = h[d];

        if (e && (Array.isArray(u) || w(u))) {
          var f = Array.isArray(u) ? [] : {};
          s[d] = t(!0, s.hasOwnProperty(d) ? s[d] : f, u);
        } else s[d] = u;
      }
    }

    return s;
  },
      S = function (t) {
    var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 1e4;
    return t = parseFloat(t) || 0, Math.round((t + Number.EPSILON) * e) / e;
  },
      C = function t(e) {
    return !!(e && "object" === n(e) && e instanceof Element && e !== document.body) && !e.__Panzoom && (function (t) {
      var e = getComputedStyle(t)["overflow-y"],
          i = getComputedStyle(t)["overflow-x"],
          n = ("scroll" === e || "auto" === e) && Math.abs(t.scrollHeight - t.clientHeight) > 1,
          o = ("scroll" === i || "auto" === i) && Math.abs(t.scrollWidth - t.clientWidth) > 1;
      return n || o;
    }(e) ? e : t(e.parentNode));
  },
      $ = "undefined" != typeof window && window.ResizeObserver || function () {
    function t(e) {
      o(this, t), this.observables = [], this.boundCheck = this.check.bind(this), this.boundCheck(), this.callback = e;
    }

    return s(t, [{
      key: "observe",
      value: function (t) {
        if (!this.observables.some(function (e) {
          return e.el === t;
        })) {
          var e = {
            el: t,
            size: {
              height: t.clientHeight,
              width: t.clientWidth
            }
          };
          this.observables.push(e);
        }
      }
    }, {
      key: "unobserve",
      value: function (t) {
        this.observables = this.observables.filter(function (e) {
          return e.el !== t;
        });
      }
    }, {
      key: "disconnect",
      value: function () {
        this.observables = [];
      }
    }, {
      key: "check",
      value: function () {
        var t = this.observables.filter(function (t) {
          var e = t.el.clientHeight,
              i = t.el.clientWidth;
          if (t.size.height !== e || t.size.width !== i) return t.size.height = e, t.size.width = i, !0;
        }).map(function (t) {
          return t.el;
        });
        t.length > 0 && this.callback(t), window.requestAnimationFrame(this.boundCheck);
      }
    }]), t;
  }(),
      E = s(function t(e) {
    o(this, t), this.id = self.Touch && e instanceof Touch ? e.identifier : -1, this.pageX = e.pageX, this.pageY = e.pageY, this.clientX = e.clientX, this.clientY = e.clientY;
  }),
      P = function (t, e) {
    return e ? Math.sqrt(Math.pow(e.clientX - t.clientX, 2) + Math.pow(e.clientY - t.clientY, 2)) : 0;
  },
      T = function (t, e) {
    return e ? {
      clientX: (t.clientX + e.clientX) / 2,
      clientY: (t.clientY + e.clientY) / 2
    } : t;
  },
      L = function (t) {
    return "changedTouches" in t;
  },
      _ = function () {
    function t(e) {
      var i = this,
          n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {},
          a = n.start,
          s = void 0 === a ? function () {
        return !0;
      } : a,
          r = n.move,
          l = void 0 === r ? function () {} : r,
          c = n.end,
          h = void 0 === c ? function () {} : c;
      o(this, t), this._element = e, this.startPointers = [], this.currentPointers = [], this._pointerStart = function (t) {
        if (!(t.buttons > 0 && 0 !== t.button)) {
          var e = new E(t);
          i.currentPointers.some(function (t) {
            return t.id === e.id;
          }) || i._triggerPointerStart(e, t) && (window.addEventListener("mousemove", i._move), window.addEventListener("mouseup", i._pointerEnd));
        }
      }, this._touchStart = function (t) {
        for (var e = 0, n = Array.from(t.changedTouches || []); e < n.length; e++) {
          var o = n[e];

          i._triggerPointerStart(new E(o), t);
        }
      }, this._move = function (t) {
        var e,
            n = i.currentPointers.slice(),
            o = L(t) ? Array.from(t.changedTouches).map(function (t) {
          return new E(t);
        }) : [new E(t)],
            a = [],
            s = x(o);

        try {
          var r = function () {
            var t = e.value,
                n = i.currentPointers.findIndex(function (e) {
              return e.id === t.id;
            });
            if (n < 0) return "continue";
            a.push(t), i.currentPointers[n] = t;
          };

          for (s.s(); !(e = s.n()).done;) r();
        } catch (t) {
          s.e(t);
        } finally {
          s.f();
        }

        i._moveCallback(n, i.currentPointers.slice(), t);
      }, this._triggerPointerEnd = function (t, e) {
        var n = i.currentPointers.findIndex(function (e) {
          return e.id === t.id;
        });
        return !(n < 0) && (i.currentPointers.splice(n, 1), i.startPointers.splice(n, 1), i._endCallback(t, e), !0);
      }, this._pointerEnd = function (t) {
        t.buttons > 0 && 0 !== t.button || i._triggerPointerEnd(new E(t), t) && (window.removeEventListener("mousemove", i._move, {
          passive: !1
        }), window.removeEventListener("mouseup", i._pointerEnd, {
          passive: !1
        }));
      }, this._touchEnd = function (t) {
        for (var e = 0, n = Array.from(t.changedTouches || []); e < n.length; e++) {
          var o = n[e];

          i._triggerPointerEnd(new E(o), t);
        }
      }, this._startCallback = s, this._moveCallback = l, this._endCallback = h, this._element.addEventListener("mousedown", this._pointerStart, {
        passive: !1
      }), this._element.addEventListener("touchstart", this._touchStart, {
        passive: !1
      }), this._element.addEventListener("touchmove", this._move, {
        passive: !1
      }), this._element.addEventListener("touchend", this._touchEnd), this._element.addEventListener("touchcancel", this._touchEnd);
    }

    return s(t, [{
      key: "stop",
      value: function () {
        this._element.removeEventListener("mousedown", this._pointerStart, {
          passive: !1
        }), this._element.removeEventListener("touchstart", this._touchStart, {
          passive: !1
        }), this._element.removeEventListener("touchmove", this._move, {
          passive: !1
        }), this._element.removeEventListener("touchend", this._touchEnd), this._element.removeEventListener("touchcancel", this._touchEnd), window.removeEventListener("mousemove", this._move), window.removeEventListener("mouseup", this._pointerEnd);
      }
    }, {
      key: "_triggerPointerStart",
      value: function (t, e) {
        return !!this._startCallback(t, e) && (this.currentPointers.push(t), this.startPointers.push(t), !0);
      }
    }]), t;
  }(),
      A = function (t, e) {
    return t.split(".").reduce(function (t, e) {
      return t && t[e];
    }, e);
  },
      O = function () {
    function t() {
      var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
      o(this, t), this.options = k(!0, {}, e), this.plugins = [], this.events = {};

      for (var i = 0, n = ["on", "once"]; i < n.length; i++) for (var a = n[i], s = 0, r = Object.entries(this.options[a] || {}); s < r.length; s++) {
        var l = r[s];
        this[a].apply(this, m(l));
      }
    }

    return s(t, [{
      key: "option",
      value: function (t, e) {
        t = String(t);
        var i = A(t, this.options);

        if ("function" == typeof i) {
          for (var n, o = arguments.length, a = new Array(o > 2 ? o - 2 : 0), s = 2; s < o; s++) a[s - 2] = arguments[s];

          i = (n = i).call.apply(n, [this, this].concat(a));
        }

        return void 0 === i ? e : i;
      }
    }, {
      key: "localize",
      value: function (t) {
        var e = this,
            i = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : [];
        return t = (t = String(t).replace(/\{\{(\w+).?(\w+)?\}\}/g, function (t, n, o) {
          var a = "";
          o ? a = e.option("".concat(n[0] + n.toLowerCase().substring(1), ".l10n.").concat(o)) : n && (a = e.option("l10n.".concat(n))), a || (a = t);

          for (var s = 0; s < i.length; s++) a = a.split(i[s][0]).join(i[s][1]);

          return a;
        })).replace(/\{\{(.*)\}\}/, function (t, e) {
          return e;
        });
      }
    }, {
      key: "on",
      value: function (t, e) {
        var i = this;

        if (w(t)) {
          for (var n = 0, o = Object.entries(t); n < o.length; n++) {
            var a = o[n];
            this.on.apply(this, m(a));
          }

          return this;
        }

        return String(t).split(" ").forEach(function (t) {
          var n = i.events[t] = i.events[t] || [];
          -1 == n.indexOf(e) && n.push(e);
        }), this;
      }
    }, {
      key: "once",
      value: function (t, e) {
        var i = this;

        if (w(t)) {
          for (var n = 0, o = Object.entries(t); n < o.length; n++) {
            var a = o[n];
            this.once.apply(this, m(a));
          }

          return this;
        }

        return String(t).split(" ").forEach(function (t) {
          var n = function n() {
            i.off(t, n);

            for (var o = arguments.length, a = new Array(o), s = 0; s < o; s++) a[s] = arguments[s];

            e.call.apply(e, [i, i].concat(a));
          };

          n._ = e, i.on(t, n);
        }), this;
      }
    }, {
      key: "off",
      value: function (t, e) {
        var i = this;
        if (!w(t)) return t.split(" ").forEach(function (t) {
          var n = i.events[t];
          if (!n || !n.length) return i;

          for (var o = -1, a = 0, s = n.length; a < s; a++) {
            var r = n[a];

            if (r && (r === e || r._ === e)) {
              o = a;
              break;
            }
          }

          -1 != o && n.splice(o, 1);
        }), this;

        for (var n = 0, o = Object.entries(t); n < o.length; n++) {
          var a = o[n];
          this.off.apply(this, m(a));
        }
      }
    }, {
      key: "trigger",
      value: function (t) {
        for (var e = arguments.length, i = new Array(e > 1 ? e - 1 : 0), n = 1; n < e; n++) i[n - 1] = arguments[n];

        var o,
            a = x(m(this.events[t] || []).slice());

        try {
          for (a.s(); !(o = a.n()).done;) {
            var s = o.value;
            if (s && !1 === s.call.apply(s, [this, this].concat(i))) return !1;
          }
        } catch (t) {
          a.e(t);
        } finally {
          a.f();
        }

        var r,
            l = x(m(this.events["*"] || []).slice());

        try {
          for (l.s(); !(r = l.n()).done;) {
            var c = r.value;
            if (c && !1 === c.call.apply(c, [this, t, this].concat(i))) return !1;
          }
        } catch (t) {
          l.e(t);
        } finally {
          l.f();
        }

        return !0;
      }
    }, {
      key: "attachPlugins",
      value: function (t) {
        for (var e = {}, i = 0, n = Object.entries(t || {}); i < n.length; i++) {
          var o = g(n[i], 2),
              a = o[0],
              s = o[1];
          !1 === this.options[a] || this.plugins[a] || (this.options[a] = k({}, s.defaults || {}, this.options[a]), e[a] = new s(this));
        }

        for (var r = 0, l = Object.entries(e); r < l.length; r++) {
          var c = g(l[r], 2);
          c[0], c[1].attach(this);
        }

        return this.plugins = Object.assign({}, this.plugins, e), this;
      }
    }, {
      key: "detachPlugins",
      value: function () {
        for (var t in this.plugins) {
          var e = void 0;
          (e = this.plugins[t]) && "function" == typeof e.detach && e.detach(this);
        }

        return this.plugins = {}, this;
      }
    }]), t;
  }(),
      z = {
    touch: !0,
    zoom: !0,
    pinchToZoom: !0,
    panOnlyZoomed: !1,
    lockAxis: !1,
    friction: 0.64,
    decelFriction: 0.88,
    zoomFriction: 0.74,
    bounceForce: 0.2,
    baseScale: 1,
    minScale: 1,
    maxScale: 2,
    step: 0.5,
    textSelection: !1,
    click: "toggleZoom",
    wheel: "zoom",
    wheelFactor: 42,
    wheelLimit: 5,
    draggableClass: "is-draggable",
    draggingClass: "is-dragging",
    ratio: 1
  },
      M = function (t) {
    l(n, t);
    var e = f(n);

    function n(t) {
      var i,
          a = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
      o(this, n), (i = e.call(this, k(!0, {}, z, a))).state = "init", i.$container = t;

      for (var s = 0, r = ["onLoad", "onWheel", "onClick"]; s < r.length; s++) {
        var l = r[s];
        i[l] = i[l].bind(d(i));
      }

      return i.initLayout(), i.resetValues(), i.attachPlugins(n.Plugins), i.trigger("init"), i.updateMetrics(), i.attachEvents(), i.trigger("ready"), !1 === i.option("centerOnStart") ? i.state = "ready" : i.panTo({
        friction: 0
      }), t.__Panzoom = d(i), i;
    }

    return s(n, [{
      key: "initLayout",
      value: function () {
        var t = this.$container;
        if (!(t instanceof HTMLElement)) throw new Error("Panzoom: Container not found");
        var e = this.option("content") || t.querySelector(".panzoom__content");
        if (!e) throw new Error("Panzoom: Content not found");
        this.$content = e;
        var i,
            n = this.option("viewport") || t.querySelector(".panzoom__viewport");
        n || !1 === this.option("wrapInner") || ((n = document.createElement("div")).classList.add("panzoom__viewport"), (i = n).append.apply(i, m(t.childNodes)), t.appendChild(n));
        this.$viewport = n || e.parentNode;
      }
    }, {
      key: "resetValues",
      value: function () {
        this.updateRate = this.option("updateRate", /iPhone|iPad|iPod|Android/i.test(navigator.userAgent) ? 250 : 24), this.container = {
          width: 0,
          height: 0
        }, this.viewport = {
          width: 0,
          height: 0
        }, this.content = {
          origWidth: 0,
          origHeight: 0,
          width: 0,
          height: 0,
          x: this.option("x", 0),
          y: this.option("y", 0),
          scale: this.option("baseScale")
        }, this.transform = {
          x: 0,
          y: 0,
          scale: 1
        }, this.resetDragPosition();
      }
    }, {
      key: "onLoad",
      value: function (t) {
        this.updateMetrics(), this.panTo({
          scale: this.option("baseScale"),
          friction: 0
        }), this.trigger("load", t);
      }
    }, {
      key: "onClick",
      value: function (t) {
        if (!t.defaultPrevented) if (this.option("textSelection") && window.getSelection().toString().length) t.stopPropagation();else {
          var e = this.$content.getClientRects()[0];
          if ("ready" !== this.state && (this.dragPosition.midPoint || Math.abs(e.top - this.dragStart.rect.top) > 1 || Math.abs(e.left - this.dragStart.rect.left) > 1)) return t.preventDefault(), void t.stopPropagation();
          !1 !== this.trigger("click", t) && this.option("zoom") && "toggleZoom" === this.option("click") && (t.preventDefault(), t.stopPropagation(), this.zoomWithClick(t));
        }
      }
    }, {
      key: "onWheel",
      value: function (t) {
        !1 !== this.trigger("wheel", t) && this.option("zoom") && this.option("wheel") && this.zoomWithWheel(t);
      }
    }, {
      key: "zoomWithWheel",
      value: function (t) {
        void 0 === this.changedDelta && (this.changedDelta = 0);
        var e = Math.max(-1, Math.min(1, -t.deltaY || -t.deltaX || t.wheelDelta || -t.detail)),
            i = this.content.scale,
            n = i * (100 + e * this.option("wheelFactor")) / 100;

        if (e < 0 && Math.abs(i - this.option("minScale")) < 0.01 || e > 0 && Math.abs(i - this.option("maxScale")) < 0.01 ? (this.changedDelta += Math.abs(e), n = i) : (this.changedDelta = 0, n = Math.max(Math.min(n, this.option("maxScale")), this.option("minScale"))), !(this.changedDelta > this.option("wheelLimit")) && (t.preventDefault(), n !== i)) {
          var o = this.$content.getBoundingClientRect(),
              a = t.clientX - o.left,
              s = t.clientY - o.top;
          this.zoomTo(n, {
            x: a,
            y: s
          });
        }
      }
    }, {
      key: "zoomWithClick",
      value: function (t) {
        var e = this.$content.getClientRects()[0],
            i = t.clientX - e.left,
            n = t.clientY - e.top;
        this.toggleZoom({
          x: i,
          y: n
        });
      }
    }, {
      key: "attachEvents",
      value: function () {
        var t = this;
        this.$content.addEventListener("load", this.onLoad), this.$container.addEventListener("wheel", this.onWheel, {
          passive: !1
        }), this.$container.addEventListener("click", this.onClick, {
          passive: !1
        }), this.initObserver();
        var e = new _(this.$container, {
          start: function (i, n) {
            if (!t.option("touch")) return !1;
            if (t.velocity.scale < 0) return !1;
            var o = n.composedPath()[0];

            if (!e.currentPointers.length) {
              if (-1 !== ["BUTTON", "TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].indexOf(o.nodeName)) return !1;
              if (t.option("textSelection") && function (t, e, i) {
                for (var n = t.childNodes, o = document.createRange(), a = 0; a < n.length; a++) {
                  var s = n[a];

                  if (s.nodeType === Node.TEXT_NODE) {
                    o.selectNodeContents(s);
                    var r = o.getBoundingClientRect();
                    if (e >= r.left && i >= r.top && e <= r.right && i <= r.bottom) return s;
                  }
                }

                return !1;
              }(o, i.clientX, i.clientY)) return !1;
            }

            return !C(o) && !1 !== t.trigger("touchStart", n) && ("mousedown" === n.type && n.preventDefault(), t.state = "pointerdown", t.resetDragPosition(), t.dragPosition.midPoint = null, t.dragPosition.time = Date.now(), !0);
          },
          move: function (i, n, o) {
            if ("pointerdown" === t.state) if (!1 !== t.trigger("touchMove", o)) {
              if (!(n.length < 2 && !0 === t.option("panOnlyZoomed") && t.content.width <= t.viewport.width && t.content.height <= t.viewport.height && t.transform.scale <= t.option("baseScale")) && (!(n.length > 1) || t.option("zoom") && !1 !== t.option("pinchToZoom"))) {
                var a = T(i[0], i[1]),
                    s = T(n[0], n[1]),
                    r = s.clientX - a.clientX,
                    l = s.clientY - a.clientY,
                    c = P(i[0], i[1]),
                    h = P(n[0], n[1]),
                    d = c && h ? h / c : 1;
                t.dragOffset.x += r, t.dragOffset.y += l, t.dragOffset.scale *= d, t.dragOffset.time = Date.now() - t.dragPosition.time;
                var u = 1 === t.dragStart.scale && t.option("lockAxis");

                if (u && !t.lockAxis) {
                  if (Math.abs(t.dragOffset.x) < 6 && Math.abs(t.dragOffset.y) < 6) return void o.preventDefault();
                  var f = Math.abs(180 * Math.atan2(t.dragOffset.y, t.dragOffset.x) / Math.PI);
                  t.lockAxis = f > 45 && f < 135 ? "y" : "x";
                }

                if ("xy" === u || "y" !== t.lockAxis) {
                  if (o.preventDefault(), o.stopPropagation(), o.stopImmediatePropagation(), t.lockAxis && (t.dragOffset["x" === t.lockAxis ? "y" : "x"] = 0), t.$container.classList.add(t.option("draggingClass")), t.transform.scale === t.option("baseScale") && "y" === t.lockAxis || (t.dragPosition.x = t.dragStart.x + t.dragOffset.x), t.transform.scale === t.option("baseScale") && "x" === t.lockAxis || (t.dragPosition.y = t.dragStart.y + t.dragOffset.y), t.dragPosition.scale = t.dragStart.scale * t.dragOffset.scale, n.length > 1) {
                    var v = T(e.startPointers[0], e.startPointers[1]),
                        p = v.clientX - t.dragStart.rect.x,
                        g = v.clientY - t.dragStart.rect.y,
                        m = t.getZoomDelta(t.content.scale * t.dragOffset.scale, p, g),
                        y = m.deltaX,
                        b = m.deltaY;
                    t.dragPosition.x -= y, t.dragPosition.y -= b, t.dragPosition.midPoint = s;
                  } else t.setDragResistance();

                  t.transform = {
                    x: t.dragPosition.x,
                    y: t.dragPosition.y,
                    scale: t.dragPosition.scale
                  }, t.startAnimation();
                }
              }
            } else o.preventDefault();
          },
          end: function (n, o) {
            if ("pointerdown" === t.state) if (t._dragOffset = i({}, t.dragOffset), e.currentPointers.length) t.resetDragPosition();else if (t.state = "decel", t.friction = t.option("decelFriction"), t.recalculateTransform(), t.$container.classList.remove(t.option("draggingClass")), !1 !== t.trigger("touchEnd", o) && "decel" === t.state) {
              var a = t.option("minScale");
              if (t.transform.scale < a) t.zoomTo(a, {
                friction: 0.64
              });else {
                var s = t.option("maxScale");

                if (t.transform.scale - s > 0.01) {
                  var r = t.dragPosition.midPoint || n,
                      l = t.$content.getClientRects()[0];
                  t.zoomTo(s, {
                    friction: 0.64,
                    x: r.clientX - l.left,
                    y: r.clientY - l.top
                  });
                } else ;
              }
            }
          }
        });
        this.pointerTracker = e;
      }
    }, {
      key: "initObserver",
      value: function () {
        var t = this;
        this.resizeObserver || (this.resizeObserver = new $(function () {
          t.updateTimer || (t.updateTimer = setTimeout(function () {
            var e = t.$container.getBoundingClientRect();
            e.width && e.height ? ((Math.abs(e.width - t.container.width) > 1 || Math.abs(e.height - t.container.height) > 1) && (t.isAnimating() && t.endAnimation(!0), t.updateMetrics(), t.panTo({
              x: t.content.x,
              y: t.content.y,
              scale: t.option("baseScale"),
              friction: 0
            })), t.updateTimer = null) : t.updateTimer = null;
          }, t.updateRate));
        }), this.resizeObserver.observe(this.$container));
      }
    }, {
      key: "resetDragPosition",
      value: function () {
        this.lockAxis = null, this.friction = this.option("friction"), this.velocity = {
          x: 0,
          y: 0,
          scale: 0
        };
        var t = this.content,
            e = t.x,
            n = t.y,
            o = t.scale;
        this.dragStart = {
          rect: this.$content.getBoundingClientRect(),
          x: e,
          y: n,
          scale: o
        }, this.dragPosition = i(i({}, this.dragPosition), {}, {
          x: e,
          y: n,
          scale: o
        }), this.dragOffset = {
          x: 0,
          y: 0,
          scale: 1,
          time: 0
        };
      }
    }, {
      key: "updateMetrics",
      value: function (t) {
        !0 !== t && this.trigger("beforeUpdate");

        var e,
            n = this.$container,
            o = this.$content,
            a = this.$viewport,
            s = o instanceof HTMLImageElement,
            r = this.option("zoom"),
            l = this.option("resizeParent", r),
            c = this.option("width"),
            h = this.option("height"),
            d = c || (e = o, Math.max(parseFloat(e.naturalWidth || 0), parseFloat(e.width && e.width.baseVal && e.width.baseVal.value || 0), parseFloat(e.offsetWidth || 0), parseFloat(e.scrollWidth || 0))),
            u = h || function (t) {
          return Math.max(parseFloat(t.naturalHeight || 0), parseFloat(t.height && t.height.baseVal && t.height.baseVal.value || 0), parseFloat(t.offsetHeight || 0), parseFloat(t.scrollHeight || 0));
        }(o);

        Object.assign(o.style, {
          width: c ? "".concat(c, "px") : "",
          height: h ? "".concat(h, "px") : "",
          maxWidth: "",
          maxHeight: ""
        }), l && Object.assign(a.style, {
          width: "",
          height: ""
        });
        var f = this.option("ratio");
        c = d = S(d * f), h = u = S(u * f);
        var v = o.getBoundingClientRect(),
            p = a.getBoundingClientRect(),
            g = a == n ? p : n.getBoundingClientRect(),
            m = Math.max(a.offsetWidth, S(p.width)),
            y = Math.max(a.offsetHeight, S(p.height)),
            b = window.getComputedStyle(a);

        if (m -= parseFloat(b.paddingLeft) + parseFloat(b.paddingRight), y -= parseFloat(b.paddingTop) + parseFloat(b.paddingBottom), this.viewport.width = m, this.viewport.height = y, r) {
          if (Math.abs(d - v.width) > 0.1 || Math.abs(u - v.height) > 0.1) {
            var x = function (t, e, i, n) {
              var o = Math.min(i / t || 0, n / e);
              return {
                width: t * o || 0,
                height: e * o || 0
              };
            }(d, u, Math.min(d, v.width), Math.min(u, v.height));

            c = S(x.width), h = S(x.height);
          }

          Object.assign(o.style, {
            width: "".concat(c, "px"),
            height: "".concat(h, "px"),
            transform: ""
          });
        }

        if (l && (Object.assign(a.style, {
          width: "".concat(c, "px"),
          height: "".concat(h, "px")
        }), this.viewport = i(i({}, this.viewport), {}, {
          width: c,
          height: h
        })), s && r && "function" != typeof this.options.maxScale) {
          var w = this.option("maxScale");

          this.options.maxScale = function () {
            return this.content.origWidth > 0 && this.content.fitWidth > 0 ? this.content.origWidth / this.content.fitWidth : w;
          };
        }

        this.content = i(i({}, this.content), {}, {
          origWidth: d,
          origHeight: u,
          fitWidth: c,
          fitHeight: h,
          width: c,
          height: h,
          scale: 1,
          isZoomable: r
        }), this.container = {
          width: g.width,
          height: g.height
        }, !0 !== t && this.trigger("afterUpdate");
      }
    }, {
      key: "zoomIn",
      value: function (t) {
        this.zoomTo(this.content.scale + (t || this.option("step")));
      }
    }, {
      key: "zoomOut",
      value: function (t) {
        this.zoomTo(this.content.scale - (t || this.option("step")));
      }
    }, {
      key: "toggleZoom",
      value: function () {
        var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {},
            e = this.option("maxScale"),
            i = this.option("baseScale"),
            n = this.content.scale > i + 0.5 * (e - i) ? i : e;
        this.zoomTo(n, t);
      }
    }, {
      key: "zoomTo",
      value: function () {
        var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : this.option("baseScale"),
            e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {},
            i = e.x,
            n = void 0 === i ? null : i,
            o = e.y,
            a = void 0 === o ? null : o;
        t = Math.max(Math.min(t, this.option("maxScale")), this.option("minScale"));
        var s = S(this.content.scale / (this.content.width / this.content.fitWidth), 1e7);
        null === n && (n = this.content.width * s * 0.5), null === a && (a = this.content.height * s * 0.5);
        var r = this.getZoomDelta(t, n, a),
            l = r.deltaX,
            c = r.deltaY;
        n = this.content.x - l, a = this.content.y - c, this.panTo({
          x: n,
          y: a,
          scale: t,
          friction: this.option("zoomFriction")
        });
      }
    }, {
      key: "getZoomDelta",
      value: function (t) {
        var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 0,
            i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 0,
            n = this.content.fitWidth * this.content.scale,
            o = this.content.fitHeight * this.content.scale,
            a = e > 0 && n ? e / n : 0,
            s = i > 0 && o ? i / o : 0,
            r = this.content.fitWidth * t,
            l = this.content.fitHeight * t,
            c = (r - n) * a,
            h = (l - o) * s;
        return {
          deltaX: c,
          deltaY: h
        };
      }
    }, {
      key: "panTo",
      value: function () {
        var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {},
            e = t.x,
            n = void 0 === e ? this.content.x : e,
            o = t.y,
            a = void 0 === o ? this.content.y : o,
            s = t.scale,
            r = t.friction,
            l = void 0 === r ? this.option("friction") : r,
            c = t.ignoreBounds,
            h = void 0 !== c && c;

        if (s = s || this.content.scale || 1, !h) {
          var d = this.getBounds(s),
              u = d.boundX,
              f = d.boundY;
          u && (n = Math.max(Math.min(n, u.to), u.from)), f && (a = Math.max(Math.min(a, f.to), f.from));
        }

        this.friction = l, this.transform = i(i({}, this.transform), {}, {
          x: n,
          y: a,
          scale: s
        }), l ? (this.state = "panning", this.velocity = {
          x: (1 / this.friction - 1) * (n - this.content.x),
          y: (1 / this.friction - 1) * (a - this.content.y),
          scale: (1 / this.friction - 1) * (s - this.content.scale)
        }, this.startAnimation()) : this.endAnimation();
      }
    }, {
      key: "startAnimation",
      value: function () {
        var t = this;
        this.rAF ? cancelAnimationFrame(this.rAF) : this.trigger("startAnimation"), this.rAF = requestAnimationFrame(function () {
          return t.animate();
        });
      }
    }, {
      key: "animate",
      value: function () {
        var t = this;
        if (this.setEdgeForce(), this.setDragForce(), this.velocity.x *= this.friction, this.velocity.y *= this.friction, this.velocity.scale *= this.friction, this.content.x += this.velocity.x, this.content.y += this.velocity.y, this.content.scale += this.velocity.scale, this.isAnimating()) this.setTransform();else if ("pointerdown" !== this.state) return void this.endAnimation();
        this.rAF = requestAnimationFrame(function () {
          return t.animate();
        });
      }
    }, {
      key: "getBounds",
      value: function (t) {
        var e = this.boundX,
            i = this.boundY;
        if (void 0 !== e && void 0 !== i) return {
          boundX: e,
          boundY: i
        };
        e = {
          from: 0,
          to: 0
        }, i = {
          from: 0,
          to: 0
        }, t = t || this.transform.scale;
        var n = this.content.fitWidth * t,
            o = this.content.fitHeight * t,
            a = this.viewport.width,
            s = this.viewport.height;

        if (n < a) {
          var r = S(0.5 * (a - n));
          e.from = r, e.to = r;
        } else e.from = S(a - n);

        if (o < s) {
          var l = 0.5 * (s - o);
          i.from = l, i.to = l;
        } else i.from = S(s - o);

        return {
          boundX: e,
          boundY: i
        };
      }
    }, {
      key: "setEdgeForce",
      value: function () {
        if ("decel" === this.state) {
          var t,
              e,
              i,
              n,
              o = this.option("bounceForce"),
              a = this.getBounds(Math.max(this.transform.scale, this.content.scale)),
              s = a.boundX,
              r = a.boundY;

          if (s && (t = this.content.x < s.from, e = this.content.x > s.to), r && (i = this.content.y < r.from, n = this.content.y > r.to), t || e) {
            var l = ((t ? s.from : s.to) - this.content.x) * o,
                c = this.content.x + (this.velocity.x + l) / this.friction;
            c >= s.from && c <= s.to && (l += this.velocity.x), this.velocity.x = l, this.recalculateTransform();
          }

          if (i || n) {
            var h = ((i ? r.from : r.to) - this.content.y) * o,
                d = this.content.y + (h + this.velocity.y) / this.friction;
            d >= r.from && d <= r.to && (h += this.velocity.y), this.velocity.y = h, this.recalculateTransform();
          }
        }
      }
    }, {
      key: "setDragResistance",
      value: function () {
        if ("pointerdown" === this.state) {
          var t,
              e,
              i,
              n,
              o = this.getBounds(this.dragPosition.scale),
              a = o.boundX,
              s = o.boundY;

          if (a && (t = this.dragPosition.x < a.from, e = this.dragPosition.x > a.to), s && (i = this.dragPosition.y < s.from, n = this.dragPosition.y > s.to), (t || e) && (!t || !e)) {
            var r = t ? a.from : a.to,
                l = r - this.dragPosition.x;
            this.dragPosition.x = r - 0.3 * l;
          }

          if ((i || n) && (!i || !n)) {
            var c = i ? s.from : s.to,
                h = c - this.dragPosition.y;
            this.dragPosition.y = c - 0.3 * h;
          }
        }
      }
    }, {
      key: "setDragForce",
      value: function () {
        "pointerdown" === this.state && (this.velocity.x = this.dragPosition.x - this.content.x, this.velocity.y = this.dragPosition.y - this.content.y, this.velocity.scale = this.dragPosition.scale - this.content.scale);
      }
    }, {
      key: "recalculateTransform",
      value: function () {
        this.transform.x = this.content.x + this.velocity.x / (1 / this.friction - 1), this.transform.y = this.content.y + this.velocity.y / (1 / this.friction - 1), this.transform.scale = this.content.scale + this.velocity.scale / (1 / this.friction - 1);
      }
    }, {
      key: "isAnimating",
      value: function () {
        return !(!this.friction || !(Math.abs(this.velocity.x) > 0.05 || Math.abs(this.velocity.y) > 0.05 || Math.abs(this.velocity.scale) > 0.05));
      }
    }, {
      key: "setTransform",
      value: function (t) {
        var e, n, o, a, s;
        (t ? (e = S(this.transform.x), n = S(this.transform.y), o = this.transform.scale, this.content = i(i({}, this.content), {}, {
          x: e,
          y: n,
          scale: o
        })) : (e = S(this.content.x), n = S(this.content.y), o = this.content.scale / (this.content.width / this.content.fitWidth), this.content = i(i({}, this.content), {}, {
          x: e,
          y: n
        })), this.trigger("beforeTransform"), e = S(this.content.x), n = S(this.content.y), t && this.option("zoom")) ? (a = S(this.content.fitWidth * o), s = S(this.content.fitHeight * o), this.content.width = a, this.content.height = s, this.transform = i(i({}, this.transform), {}, {
          width: a,
          height: s,
          scale: o
        }), Object.assign(this.$content.style, {
          width: "".concat(a, "px"),
          height: "".concat(s, "px"),
          maxWidth: "none",
          maxHeight: "none",
          transform: "translate3d(".concat(e, "px, ").concat(n, "px, 0) scale(1)")
        })) : this.$content.style.transform = "translate3d(".concat(e, "px, ").concat(n, "px, 0) scale(").concat(o, ")");
        this.trigger("afterTransform");
      }
    }, {
      key: "endAnimation",
      value: function (t) {
        cancelAnimationFrame(this.rAF), this.rAF = null, this.velocity = {
          x: 0,
          y: 0,
          scale: 0
        }, this.setTransform(!0), this.state = "ready", this.handleCursor(), !0 !== t && this.trigger("endAnimation");
      }
    }, {
      key: "handleCursor",
      value: function () {
        var t = this.option("draggableClass");
        t && this.option("touch") && (1 == this.option("panOnlyZoomed") && this.content.width <= this.viewport.width && this.content.height <= this.viewport.height && this.transform.scale <= this.option("baseScale") ? this.$container.classList.remove(t) : this.$container.classList.add(t));
      }
    }, {
      key: "detachEvents",
      value: function () {
        this.$content.removeEventListener("load", this.onLoad), this.$container.removeEventListener("wheel", this.onWheel, {
          passive: !1
        }), this.$container.removeEventListener("click", this.onClick, {
          passive: !1
        }), this.pointerTracker && (this.pointerTracker.stop(), this.pointerTracker = null), this.resizeObserver && (this.resizeObserver.disconnect(), this.resizeObserver = null);
      }
    }, {
      key: "destroy",
      value: function () {
        "destroy" !== this.state && (this.state = "destroy", clearTimeout(this.updateTimer), this.updateTimer = null, cancelAnimationFrame(this.rAF), this.rAF = null, this.detachEvents(), this.detachPlugins(), this.resetDragPosition());
      }
    }]), n;
  }(O);

  M.version = "4.0.27", M.Plugins = {};

  var I = function (t, e) {
    var i = 0;
    return function () {
      var n = new Date().getTime();
      if (!(n - i < e)) return i = n, t.apply(void 0, arguments);
    };
  },
      R = function () {
    function t(e) {
      o(this, t), this.$container = null, this.$prev = null, this.$next = null, this.carousel = e, this.onRefresh = this.onRefresh.bind(this);
    }

    return s(t, [{
      key: "option",
      value: function (t) {
        return this.carousel.option("Navigation.".concat(t));
      }
    }, {
      key: "createButton",
      value: function (t) {
        var e,
            i = this,
            n = document.createElement("button");
        n.setAttribute("title", this.carousel.localize("{{".concat(t.toUpperCase(), "}}")));
        var o = this.option("classNames.button") + " " + this.option("classNames.".concat(t));
        return (e = n.classList).add.apply(e, m(o.split(" "))), n.setAttribute("tabindex", "0"), n.innerHTML = this.carousel.localize(this.option("".concat(t, "Tpl"))), n.addEventListener("click", function (e) {
          e.preventDefault(), e.stopPropagation(), i.carousel["slide".concat("next" === t ? "Next" : "Prev")]();
        }), n;
      }
    }, {
      key: "build",
      value: function () {
        var t;
        this.$container || (this.$container = document.createElement("div"), (t = this.$container.classList).add.apply(t, m(this.option("classNames.main").split(" "))), this.carousel.$container.appendChild(this.$container));
        this.$next || (this.$next = this.createButton("next"), this.$container.appendChild(this.$next)), this.$prev || (this.$prev = this.createButton("prev"), this.$container.appendChild(this.$prev));
      }
    }, {
      key: "onRefresh",
      value: function () {
        var t = this.carousel.pages.length;
        t <= 1 || t > 1 && this.carousel.elemDimWidth < this.carousel.wrapDimWidth && !Number.isInteger(this.carousel.option("slidesPerPage")) ? this.cleanup() : (this.build(), this.$prev.removeAttribute("disabled"), this.$next.removeAttribute("disabled"), this.carousel.option("infiniteX", this.carousel.option("infinite")) || (this.carousel.page <= 0 && this.$prev.setAttribute("disabled", ""), this.carousel.page >= t - 1 && this.$next.setAttribute("disabled", "")));
      }
    }, {
      key: "cleanup",
      value: function () {
        this.$prev && this.$prev.remove(), this.$prev = null, this.$next && this.$next.remove(), this.$next = null, this.$container && this.$container.remove(), this.$container = null;
      }
    }, {
      key: "attach",
      value: function () {
        this.carousel.on("refresh change", this.onRefresh);
      }
    }, {
      key: "detach",
      value: function () {
        this.carousel.off("refresh change", this.onRefresh), this.cleanup();
      }
    }]), t;
  }();

  R.defaults = {
    prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M15 3l-9 9 9 9"/></svg>',
    nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M9 3l9 9-9 9"/></svg>',
    classNames: {
      main: "carousel__nav",
      button: "carousel__button",
      next: "is-next",
      prev: "is-prev"
    }
  };

  var F = function () {
    function t(e) {
      o(this, t), this.carousel = e, this.$list = null, this.events = {
        change: this.onChange.bind(this),
        refresh: this.onRefresh.bind(this)
      };
    }

    return s(t, [{
      key: "buildList",
      value: function () {
        var t = this;

        if (!(this.carousel.pages.length < this.carousel.option("Dots.minSlideCount"))) {
          var e = document.createElement("ol");
          return e.classList.add("carousel__dots"), e.addEventListener("click", function (e) {
            if ("page" in e.target.dataset) {
              e.preventDefault(), e.stopPropagation();
              var i = parseInt(e.target.dataset.page, 10),
                  n = t.carousel;
              i !== n.page && (n.pages.length < 3 && n.option("infinite") ? n[0 == i ? "slidePrev" : "slideNext"]() : n.slideTo(i));
            }
          }), this.$list = e, this.carousel.$container.appendChild(e), this.carousel.$container.classList.add("has-dots"), e;
        }
      }
    }, {
      key: "removeList",
      value: function () {
        this.$list && (this.$list.parentNode.removeChild(this.$list), this.$list = null), this.carousel.$container.classList.remove("has-dots");
      }
    }, {
      key: "rebuildDots",
      value: function () {
        var t = this,
            e = this.$list,
            i = !!e,
            n = this.carousel.pages.length;
        if (n < 2) i && this.removeList();else {
          i || (e = this.buildList());
          var o = this.$list.children.length;
          if (o > n) for (var a = n; a < o; a++) this.$list.removeChild(this.$list.lastChild);else {
            for (var s = function (e) {
              var i = document.createElement("li");
              i.classList.add("carousel__dot"), i.dataset.page = e, i.setAttribute("role", "button"), i.setAttribute("tabindex", "0"), i.setAttribute("title", t.carousel.localize("{{GOTO}}", [["%d", e + 1]])), i.addEventListener("keydown", function (t) {
                var e,
                    n = t.code;
                "Enter" === n || "NumpadEnter" === n ? e = i : "ArrowRight" === n ? e = i.nextSibling : "ArrowLeft" === n && (e = i.previousSibling), e && e.click();
              }), t.$list.appendChild(i);
            }, r = o; r < n; r++) s(r);

            this.setActiveDot();
          }
        }
      }
    }, {
      key: "setActiveDot",
      value: function () {
        if (this.$list) {
          this.$list.childNodes.forEach(function (t) {
            t.classList.remove("is-selected");
          });
          var t = this.$list.childNodes[this.carousel.page];
          t && t.classList.add("is-selected");
        }
      }
    }, {
      key: "onChange",
      value: function () {
        this.setActiveDot();
      }
    }, {
      key: "onRefresh",
      value: function () {
        this.rebuildDots();
      }
    }, {
      key: "attach",
      value: function () {
        this.carousel.on(this.events);
      }
    }, {
      key: "detach",
      value: function () {
        this.removeList(), this.carousel.off(this.events), this.carousel = null;
      }
    }]), t;
  }(),
      N = function () {
    function t(e) {
      o(this, t), this.carousel = e, this.selectedIndex = null, this.friction = 0, this.onNavReady = this.onNavReady.bind(this), this.onNavClick = this.onNavClick.bind(this), this.onNavCreateSlide = this.onNavCreateSlide.bind(this), this.onTargetChange = this.onTargetChange.bind(this);
    }

    return s(t, [{
      key: "addAsTargetFor",
      value: function (t) {
        this.target = this.carousel, this.nav = t, this.attachEvents();
      }
    }, {
      key: "addAsNavFor",
      value: function (t) {
        this.target = t, this.nav = this.carousel, this.attachEvents();
      }
    }, {
      key: "attachEvents",
      value: function () {
        this.nav.options.initialSlide = this.target.options.initialPage, this.nav.on("ready", this.onNavReady), this.nav.on("createSlide", this.onNavCreateSlide), this.nav.on("Panzoom.click", this.onNavClick), this.target.on("change", this.onTargetChange), this.target.on("Panzoom.afterUpdate", this.onTargetChange);
      }
    }, {
      key: "onNavReady",
      value: function () {
        this.onTargetChange(!0);
      }
    }, {
      key: "onNavClick",
      value: function (t, e, i) {
        var n = i.target.closest(".carousel__slide");

        if (n) {
          i.stopPropagation();
          var o = parseInt(n.dataset.index, 10),
              a = this.target.findPageForSlide(o);
          this.target.page !== a && this.target.slideTo(a, {
            friction: this.friction
          }), this.markSelectedSlide(o);
        }
      }
    }, {
      key: "onNavCreateSlide",
      value: function (t, e) {
        e.index === this.selectedIndex && this.markSelectedSlide(e.index);
      }
    }, {
      key: "onTargetChange",
      value: function () {
        var t = this.target.pages[this.target.page].indexes[0],
            e = this.nav.findPageForSlide(t);
        this.nav.slideTo(e), this.markSelectedSlide(t);
      }
    }, {
      key: "markSelectedSlide",
      value: function (t) {
        this.selectedIndex = t, m(this.nav.slides).filter(function (t) {
          return t.$el && t.$el.classList.remove("is-nav-selected");
        });
        var e = this.nav.slides[t];
        e && e.$el && e.$el.classList.add("is-nav-selected");
      }
    }, {
      key: "attach",
      value: function (t) {
        var e = t.options.Sync;
        (e.target || e.nav) && (e.target ? this.addAsNavFor(e.target) : e.nav && this.addAsTargetFor(e.nav), this.friction = e.friction);
      }
    }, {
      key: "detach",
      value: function () {
        this.nav && (this.nav.off("ready", this.onNavReady), this.nav.off("Panzoom.click", this.onNavClick), this.nav.off("createSlide", this.onNavCreateSlide)), this.target && (this.target.off("Panzoom.afterUpdate", this.onTargetChange), this.target.off("change", this.onTargetChange));
      }
    }]), t;
  }();

  N.defaults = {
    friction: 0.92
  };

  var D = {
    Navigation: R,
    Dots: F,
    Sync: N
  },
      B = {
    slides: [],
    preload: 0,
    slidesPerPage: "auto",
    initialPage: null,
    initialSlide: null,
    friction: 0.92,
    center: !0,
    infinite: !0,
    fill: !0,
    dragFree: !1,
    prefix: "",
    classNames: {
      viewport: "carousel__viewport",
      track: "carousel__track",
      slide: "carousel__slide",
      slideSelected: "is-selected"
    },
    l10n: {
      NEXT: "Next slide",
      PREV: "Previous slide",
      GOTO: "Go to slide #%d"
    }
  },
      H = function (t) {
    l(n, t);
    var e = f(n);

    function n(t) {
      var i,
          a = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
      if (o(this, n), a = k(!0, {}, B, a), (i = e.call(this, a)).state = "init", i.$container = t, !(i.$container instanceof HTMLElement)) throw new Error("No root element provided");
      return i.slideNext = I(i.slideNext.bind(d(i)), 250), i.slidePrev = I(i.slidePrev.bind(d(i)), 250), i.init(), t.__Carousel = d(i), i;
    }

    return s(n, [{
      key: "init",
      value: function () {
        this.pages = [], this.page = this.pageIndex = null, this.prevPage = this.prevPageIndex = null, this.attachPlugins(n.Plugins), this.trigger("init"), this.initLayout(), this.initSlides(), this.updateMetrics(), this.$track && this.pages.length && (this.$track.style.transform = "translate3d(".concat(-1 * this.pages[this.page].left, "px, 0px, 0) scale(1)")), this.manageSlideVisiblity(), this.initPanzoom(), this.state = "ready", this.trigger("ready");
      }
    }, {
      key: "initLayout",
      value: function () {
        var t,
            e,
            i,
            n,
            o = this.option("prefix"),
            a = this.option("classNames");
        (this.$viewport = this.option("viewport") || this.$container.querySelector(".".concat(o).concat(a.viewport)), this.$viewport) || (this.$viewport = document.createElement("div"), (t = this.$viewport.classList).add.apply(t, m((o + a.viewport).split(" "))), (e = this.$viewport).append.apply(e, m(this.$container.childNodes)), this.$container.appendChild(this.$viewport));
        (this.$track = this.option("track") || this.$container.querySelector(".".concat(o).concat(a.track)), this.$track) || (this.$track = document.createElement("div"), (i = this.$track.classList).add.apply(i, m((o + a.track).split(" "))), (n = this.$track).append.apply(n, m(this.$viewport.childNodes)), this.$viewport.appendChild(this.$track));
      }
    }, {
      key: "initSlides",
      value: function () {
        var t = this;
        this.slides = [], this.$viewport.querySelectorAll(".".concat(this.option("prefix")).concat(this.option("classNames.slide"))).forEach(function (e) {
          var i = {
            $el: e,
            isDom: !0
          };
          t.slides.push(i), t.trigger("createSlide", i, t.slides.length);
        }), Array.isArray(this.options.slides) && (this.slides = k(!0, m(this.slides), this.options.slides));
      }
    }, {
      key: "updateMetrics",
      value: function () {
        var t,
            e = this,
            n = 0,
            o = [];
        this.slides.forEach(function (i, a) {
          var s = i.$el,
              r = i.isDom || !t ? e.getSlideMetrics(s) : t;
          i.index = a, i.width = r, i.left = n, t = r, n += r, o.push(a);
        });
        var a = Math.max(this.$track.offsetWidth, S(this.$track.getBoundingClientRect().width)),
            s = getComputedStyle(this.$track);
        a -= parseFloat(s.paddingLeft) + parseFloat(s.paddingRight), this.contentWidth = n, this.viewportWidth = a;
        var r = [],
            l = this.option("slidesPerPage");
        if (Number.isInteger(l) && n > a) for (var c = 0; c < this.slides.length; c += l) r.push({
          indexes: o.slice(c, c + l),
          slides: this.slides.slice(c, c + l)
        });else for (var h = 0, d = 0, u = 0; u < this.slides.length; u += 1) {
          var f = this.slides[u];
          (!r.length || d + f.width > a) && (r.push({
            indexes: [],
            slides: []
          }), h = r.length - 1, d = 0), d += f.width, r[h].indexes.push(u), r[h].slides.push(f);
        }
        var v = this.option("center"),
            p = this.option("fill");
        r.forEach(function (t, i) {
          t.index = i, t.width = t.slides.reduce(function (t, e) {
            return t + e.width;
          }, 0), t.left = t.slides[0].left, v && (t.left += 0.5 * (a - t.width) * -1), p && !e.option("infiniteX", e.option("infinite")) && n > a && (t.left = Math.max(t.left, 0), t.left = Math.min(t.left, n - a));
        });
        var g,
            y = [];
        r.forEach(function (t) {
          var e = i({}, t);
          g && e.left === g.left ? (g.width += e.width, g.slides = [].concat(m(g.slides), m(e.slides)), g.indexes = [].concat(m(g.indexes), m(e.indexes))) : (e.index = y.length, g = e, y.push(e));
        }), this.pages = y;
        var b = this.page;

        if (null === b) {
          var x = this.option("initialSlide");
          b = null !== x ? this.findPageForSlide(x) : parseInt(this.option("initialPage", 0), 10) || 0, y[b] || (b = y.length && b > y.length ? y[y.length - 1].index : 0), this.page = b, this.pageIndex = b;
        }

        this.updatePanzoom(), this.trigger("refresh");
      }
    }, {
      key: "getSlideMetrics",
      value: function (t) {
        if (!t) {
          var e,
              i,
              n = this.slides[0];
          if ((t = document.createElement("div")).dataset.isTestEl = 1, t.style.visibility = "hidden", (e = t.classList).add.apply(e, m((this.option("prefix") + this.option("classNames.slide")).split(" "))), n.customClass) (i = t.classList).add.apply(i, m(n.customClass.split(" ")));
          this.$track.prepend(t);
        }

        var o = Math.max(t.offsetWidth, S(t.getBoundingClientRect().width)),
            a = t.currentStyle || window.getComputedStyle(t);
        return o = o + (parseFloat(a.marginLeft) || 0) + (parseFloat(a.marginRight) || 0), t.dataset.isTestEl && t.remove(), o;
      }
    }, {
      key: "findPageForSlide",
      value: function (t) {
        t = parseInt(t, 10) || 0;
        var e = this.pages.find(function (e) {
          return e.indexes.indexOf(t) > -1;
        });
        return e ? e.index : null;
      }
    }, {
      key: "slideNext",
      value: function () {
        this.slideTo(this.pageIndex + 1);
      }
    }, {
      key: "slidePrev",
      value: function () {
        this.slideTo(this.pageIndex - 1);
      }
    }, {
      key: "slideTo",
      value: function (t) {
        var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {},
            i = e.x,
            n = void 0 === i ? -1 * this.setPage(t, !0) : i,
            o = e.y,
            a = void 0 === o ? 0 : o,
            s = e.friction,
            r = void 0 === s ? this.option("friction") : s;
        this.Panzoom.content.x === n && !this.Panzoom.velocity.x && r || (this.Panzoom.panTo({
          x: n,
          y: a,
          friction: r,
          ignoreBounds: !0
        }), "ready" === this.state && "ready" === this.Panzoom.state && this.trigger("settle"));
      }
    }, {
      key: "initPanzoom",
      value: function () {
        var t = this;
        this.Panzoom && this.Panzoom.destroy();
        var e = k(!0, {}, {
          content: this.$track,
          wrapInner: !1,
          resizeParent: !1,
          zoom: !1,
          click: !1,
          lockAxis: "x",
          x: this.pages.length ? -1 * this.pages[this.page].left : 0,
          centerOnStart: !1,
          textSelection: function () {
            return t.option("textSelection", !1);
          },
          panOnlyZoomed: function () {
            return this.content.width <= this.viewport.width;
          }
        }, this.option("Panzoom"));
        this.Panzoom = new M(this.$container, e), this.Panzoom.on({
          "*": function (e) {
            for (var i = arguments.length, n = new Array(i > 1 ? i - 1 : 0), o = 1; o < i; o++) n[o - 1] = arguments[o];

            return t.trigger.apply(t, ["Panzoom.".concat(e)].concat(n));
          },
          afterUpdate: function () {
            t.updatePage();
          },
          beforeTransform: this.onBeforeTransform.bind(this),
          touchEnd: this.onTouchEnd.bind(this),
          endAnimation: function () {
            t.trigger("settle");
          }
        }), this.updateMetrics(), this.manageSlideVisiblity();
      }
    }, {
      key: "updatePanzoom",
      value: function () {
        this.Panzoom && (this.Panzoom.content = i(i({}, this.Panzoom.content), {}, {
          fitWidth: this.contentWidth,
          origWidth: this.contentWidth,
          width: this.contentWidth
        }), this.pages.length > 1 && this.option("infiniteX", this.option("infinite")) ? this.Panzoom.boundX = null : this.pages.length && (this.Panzoom.boundX = {
          from: -1 * this.pages[this.pages.length - 1].left,
          to: -1 * this.pages[0].left
        }), this.option("infiniteY", this.option("infinite")) ? this.Panzoom.boundY = null : this.Panzoom.boundY = {
          from: 0,
          to: 0
        }, this.Panzoom.handleCursor());
      }
    }, {
      key: "manageSlideVisiblity",
      value: function () {
        var t = this,
            e = this.contentWidth,
            i = this.viewportWidth,
            n = this.Panzoom ? -1 * this.Panzoom.content.x : this.pages.length ? this.pages[this.page].left : 0,
            o = this.option("preload"),
            a = this.option("infiniteX", this.option("infinite")),
            s = parseFloat(getComputedStyle(this.$viewport, null).getPropertyValue("padding-left")),
            r = parseFloat(getComputedStyle(this.$viewport, null).getPropertyValue("padding-right"));
        this.slides.forEach(function (l) {
          var c,
              h,
              d = 0;
          c = n - s, h = n + i + r, c -= o * (i + s + r), h += o * (i + s + r);
          var u = l.left + l.width > c && l.left < h;
          c = n + e - s, h = n + e + i + r, c -= o * (i + s + r);
          var f = a && l.left + l.width > c && l.left < h;
          c = n - e - s, h = n - e + i + r, c -= o * (i + s + r);
          var v = a && l.left + l.width > c && l.left < h;
          f || u || v ? (t.createSlideEl(l), u && (d = 0), f && (d = -1), v && (d = 1), l.left + l.width > n && l.left <= n + i + r && (d = 0)) : t.removeSlideEl(l), l.hasDiff = d;
        });
        var l = 0,
            c = 0;
        this.slides.forEach(function (t, i) {
          var n = 0;
          t.$el ? (i !== l || t.hasDiff ? n = c + t.hasDiff * e : c = 0, t.$el.style.left = Math.abs(n) > 0.1 ? "".concat(c + t.hasDiff * e, "px") : "", l++) : c += t.width;
        }), this.markSelectedSlides();
      }
    }, {
      key: "createSlideEl",
      value: function (t) {
        var e;

        if (t) {
          if (!t.$el) {
            var i,
                n = document.createElement("div");
            if (n.dataset.index = t.index, (e = n.classList).add.apply(e, m((this.option("prefix") + this.option("classNames.slide")).split(" "))), t.customClass) (i = n.classList).add.apply(i, m(t.customClass.split(" ")));
            t.html && (n.innerHTML = t.html);
            var o = [];
            this.slides.forEach(function (t, e) {
              t.$el && o.push(e);
            });
            var a = t.index,
                s = null;

            if (o.length) {
              var r = o.reduce(function (t, e) {
                return Math.abs(e - a) < Math.abs(t - a) ? e : t;
              });
              s = this.slides[r];
            }

            return this.$track.insertBefore(n, s && s.$el ? s.index < t.index ? s.$el.nextSibling : s.$el : null), t.$el = n, this.trigger("createSlide", t, a), t;
          }

          var l,
              c = t.$el.dataset.index;
          c && parseInt(c, 10) === t.index || (t.$el.dataset.index = t.index, t.$el.querySelectorAll("[data-lazy-srcset]").forEach(function (t) {
            t.srcset = t.dataset.lazySrcset;
          }), t.$el.querySelectorAll("[data-lazy-src]").forEach(function (t) {
            var e = t.dataset.lazySrc;
            t instanceof HTMLImageElement ? t.src = e : t.style.backgroundImage = "url('".concat(e, "')");
          }), (l = t.$el.dataset.lazySrc) && (t.$el.style.backgroundImage = "url('".concat(l, "')")), t.state = "ready");
        }
      }
    }, {
      key: "removeSlideEl",
      value: function (t) {
        t.$el && !t.isDom && (this.trigger("removeSlide", t), t.$el.remove(), t.$el = null);
      }
    }, {
      key: "markSelectedSlides",
      value: function () {
        var t = this,
            e = this.option("classNames.slideSelected"),
            i = "aria-hidden";
        this.slides.forEach(function (n, o) {
          var a = n.$el;

          if (a) {
            var s = t.pages[t.page];
            s && s.indexes && s.indexes.indexOf(o) > -1 ? (e && !a.classList.contains(e) && (a.classList.add(e), t.trigger("selectSlide", n)), a.removeAttribute(i)) : (e && a.classList.contains(e) && (a.classList.remove(e), t.trigger("unselectSlide", n)), a.setAttribute(i, !0));
          }
        });
      }
    }, {
      key: "updatePage",
      value: function () {
        this.updateMetrics(), this.slideTo(this.page, {
          friction: 0
        });
      }
    }, {
      key: "onBeforeTransform",
      value: function () {
        this.option("infiniteX", this.option("infinite")) && this.manageInfiniteTrack(), this.manageSlideVisiblity();
      }
    }, {
      key: "manageInfiniteTrack",
      value: function () {
        var t = this.contentWidth,
            e = this.viewportWidth;

        if (!(!this.option("infiniteX", this.option("infinite")) || this.pages.length < 2 || t < e)) {
          var i = this.Panzoom,
              n = !1;
          return i.content.x < -1 * (t - e) && (i.content.x += t, this.pageIndex = this.pageIndex - this.pages.length, n = !0), i.content.x > e && (i.content.x -= t, this.pageIndex = this.pageIndex + this.pages.length, n = !0), n && "pointerdown" === i.state && i.resetDragPosition(), n;
        }
      }
    }, {
      key: "onTouchEnd",
      value: function (t, e) {
        var i = this.option("dragFree");
        if (!i && this.pages.length > 1 && t.dragOffset.time < 350 && Math.abs(t.dragOffset.y) < 1 && Math.abs(t.dragOffset.x) > 5) this[t.dragOffset.x < 0 ? "slideNext" : "slidePrev"]();else if (i) {
          var n = g(this.getPageFromPosition(-1 * t.transform.x), 2)[1];
          this.setPage(n);
        } else this.slideToClosest();
      }
    }, {
      key: "slideToClosest",
      value: function () {
        var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {},
            e = this.getPageFromPosition(-1 * this.Panzoom.content.x),
            i = g(e, 2),
            n = i[1];
        this.slideTo(n, t);
      }
    }, {
      key: "getPageFromPosition",
      value: function (t) {
        var e = this.pages.length;
        this.option("center") && (t += 0.5 * this.viewportWidth);
        var i = Math.floor(t / this.contentWidth);
        t -= i * this.contentWidth;
        var n = this.slides.find(function (e) {
          return e.left <= t && e.left + e.width > t;
        });

        if (n) {
          var o = this.findPageForSlide(n.index);
          return [o, o + i * e];
        }

        return [0, 0];
      }
    }, {
      key: "setPage",
      value: function (t, e) {
        var i = 0,
            n = parseInt(t, 10) || 0,
            o = this.page,
            a = this.pageIndex,
            s = this.pages.length,
            r = this.contentWidth,
            l = this.viewportWidth;

        if (t = (n % s + s) % s, this.option("infiniteX", this.option("infinite")) && r > l) {
          var c = Math.floor(n / s) || 0,
              h = r;

          if (i = this.pages[t].left + c * h, !0 === e && s > 2) {
            var d = -1 * this.Panzoom.content.x,
                u = i - h,
                f = i + h,
                v = Math.abs(d - i),
                p = Math.abs(d - u),
                g = Math.abs(d - f);
            g < v && g <= p ? (i = f, n += s) : p < v && p < g && (i = u, n -= s);
          }
        } else t = n = Math.max(0, Math.min(n, s - 1)), i = this.pages.length ? this.pages[t].left : 0;

        return this.page = t, this.pageIndex = n, null !== o && t !== o && (this.prevPage = o, this.prevPageIndex = a, this.trigger("change", t, o)), i;
      }
    }, {
      key: "destroy",
      value: function () {
        var t = this;
        this.state = "destroy", this.slides.forEach(function (e) {
          t.removeSlideEl(e);
        }), this.slides = [], this.Panzoom.destroy(), this.detachPlugins();
      }
    }]), n;
  }(O);

  H.version = "4.0.27", H.Plugins = D;

  var W = !("undefined" == typeof window || !window.document || !window.document.createElement),
      j = null,
      X = ["a[href]", "area[href]", 'input:not([disabled]):not([type="hidden"]):not([aria-hidden])', "select:not([disabled]):not([aria-hidden])", "textarea:not([disabled]):not([aria-hidden])", "button:not([disabled]):not([aria-hidden])", "iframe", "object", "embed", "video", "audio", "[contenteditable]", '[tabindex]:not([tabindex^="-"]):not([disabled]):not([aria-hidden])'],
      q = function (t) {
    if (t && W) {
      null === j && document.createElement("div").focus({
        get preventScroll() {
          return j = !0, !1;
        }

      });

      try {
        if (t.setActive) t.setActive();else if (j) t.focus({
          preventScroll: !0
        });else {
          var e = window.pageXOffset || document.body.scrollTop,
              i = window.pageYOffset || document.body.scrollLeft;
          t.focus(), document.body.scrollTo({
            top: e,
            left: i,
            behavior: "auto"
          });
        }
      } catch (t) {}
    }
  },
      U = function () {
    function t(e) {
      o(this, t), this.fancybox = e, this.viewport = null, this.pendingUpdate = null;

      for (var i = 0, n = ["onReady", "onResize", "onTouchstart", "onTouchmove"]; i < n.length; i++) {
        var a = n[i];
        this[a] = this[a].bind(this);
      }
    }

    return s(t, [{
      key: "onReady",
      value: function () {
        var t = window.visualViewport;
        t && (this.viewport = t, this.startY = 0, t.addEventListener("resize", this.onResize), this.updateViewport()), window.addEventListener("touchstart", this.onTouchstart, {
          passive: !1
        }), window.addEventListener("touchmove", this.onTouchmove, {
          passive: !1
        }), window.addEventListener("wheel", this.onWheel, {
          passive: !1
        });
      }
    }, {
      key: "onResize",
      value: function () {
        this.updateViewport();
      }
    }, {
      key: "updateViewport",
      value: function () {
        var t = this.fancybox,
            e = this.viewport,
            i = e.scale || 1,
            n = t.$container;

        if (n) {
          var o = "",
              a = "",
              s = "";
          i - 1 > 0.1 && (o = "".concat(e.width * i, "px"), a = "".concat(e.height * i, "px"), s = "translate3d(".concat(e.offsetLeft, "px, ").concat(e.offsetTop, "px, 0) scale(").concat(1 / i, ")")), n.style.width = o, n.style.height = a, n.style.transform = s;
        }
      }
    }, {
      key: "onTouchstart",
      value: function (t) {
        this.startY = t.touches ? t.touches[0].screenY : t.screenY;
      }
    }, {
      key: "onTouchmove",
      value: function (t) {
        var e = this.startY,
            i = window.innerWidth / window.document.documentElement.clientWidth;

        if (t.cancelable && !(t.touches.length > 1 || 1 !== i)) {
          var n = C(t.composedPath()[0]);

          if (n) {
            var o = window.getComputedStyle(n),
                a = parseInt(o.getPropertyValue("height"), 10),
                s = t.touches ? t.touches[0].screenY : t.screenY,
                r = e <= s && 0 === n.scrollTop,
                l = e >= s && n.scrollHeight - n.scrollTop === a;
            (r || l) && t.preventDefault();
          } else t.preventDefault();
        }
      }
    }, {
      key: "onWheel",
      value: function (t) {
        C(t.composedPath()[0]) || t.preventDefault();
      }
    }, {
      key: "cleanup",
      value: function () {
        this.pendingUpdate && (cancelAnimationFrame(this.pendingUpdate), this.pendingUpdate = null);
        var t = this.viewport;
        t && (t.removeEventListener("resize", this.onResize), this.viewport = null), window.removeEventListener("touchstart", this.onTouchstart, !1), window.removeEventListener("touchmove", this.onTouchmove, !1), window.removeEventListener("wheel", this.onWheel, {
          passive: !1
        });
      }
    }, {
      key: "attach",
      value: function () {
        this.fancybox.on("initLayout", this.onReady);
      }
    }, {
      key: "detach",
      value: function () {
        this.fancybox.off("initLayout", this.onReady), this.cleanup();
      }
    }]), t;
  }(),
      Y = function () {
    function t(e) {
      o(this, t), this.fancybox = e, this.$container = null, this.state = "init";

      for (var i = 0, n = ["onPrepare", "onClosing", "onKeydown"]; i < n.length; i++) {
        var a = n[i];
        this[a] = this[a].bind(this);
      }

      this.events = {
        prepare: this.onPrepare,
        closing: this.onClosing,
        keydown: this.onKeydown
      };
    }

    return s(t, [{
      key: "onPrepare",
      value: function () {
        this.getSlides().length < this.fancybox.option("Thumbs.minSlideCount") ? this.state = "disabled" : !0 === this.fancybox.option("Thumbs.autoStart") && this.fancybox.Carousel.Panzoom.content.height >= this.fancybox.option("Thumbs.minScreenHeight") && this.build();
      }
    }, {
      key: "onClosing",
      value: function () {
        this.Carousel && this.Carousel.Panzoom.detachEvents();
      }
    }, {
      key: "onKeydown",
      value: function (t, e) {
        e === t.option("Thumbs.key") && this.toggle();
      }
    }, {
      key: "build",
      value: function () {
        var t = this;

        if (!this.$container) {
          var e = document.createElement("div");
          e.classList.add("fancybox__thumbs"), this.fancybox.$carousel.parentNode.insertBefore(e, this.fancybox.$carousel.nextSibling), this.Carousel = new H(e, k(!0, {
            Dots: !1,
            Navigation: !1,
            Sync: {
              friction: 0
            },
            infinite: !1,
            center: !0,
            fill: !0,
            dragFree: !0,
            slidesPerPage: 1,
            preload: 1
          }, this.fancybox.option("Thumbs.Carousel"), {
            Sync: {
              target: this.fancybox.Carousel
            },
            slides: this.getSlides()
          })), this.Carousel.Panzoom.on("wheel", function (e, i) {
            i.preventDefault(), t.fancybox[i.deltaY < 0 ? "prev" : "next"]();
          }), this.$container = e, this.state = "visible";
        }
      }
    }, {
      key: "getSlides",
      value: function () {
        var t,
            e = [],
            i = x(this.fancybox.items);

        try {
          for (i.s(); !(t = i.n()).done;) {
            var n = t.value,
                o = n.thumb;
            o && e.push({
              html: '<div class="fancybox__thumb" style="background-image:url(\''.concat(o, "')\"></div>"),
              customClass: "has-thumb has-".concat(n.type || "image")
            });
          }
        } catch (t) {
          i.e(t);
        } finally {
          i.f();
        }

        return e;
      }
    }, {
      key: "toggle",
      value: function () {
        "visible" === this.state ? this.hide() : "hidden" === this.state ? this.show() : this.build();
      }
    }, {
      key: "show",
      value: function () {
        "hidden" === this.state && (this.$container.style.display = "", this.Carousel.Panzoom.attachEvents(), this.state = "visible");
      }
    }, {
      key: "hide",
      value: function () {
        "visible" === this.state && (this.Carousel.Panzoom.detachEvents(), this.$container.style.display = "none", this.state = "hidden");
      }
    }, {
      key: "cleanup",
      value: function () {
        this.Carousel && (this.Carousel.destroy(), this.Carousel = null), this.$container && (this.$container.remove(), this.$container = null), this.state = "init";
      }
    }, {
      key: "attach",
      value: function () {
        this.fancybox.on(this.events);
      }
    }, {
      key: "detach",
      value: function () {
        this.fancybox.off(this.events), this.cleanup();
      }
    }]), t;
  }();

  Y.defaults = {
    minSlideCount: 2,
    minScreenHeight: 500,
    autoStart: !0,
    key: "t",
    Carousel: {}
  };

  var V = function (t, e) {
    for (var i = new URL(t), n = new URLSearchParams(i.search), o = new URLSearchParams(), a = 0, s = [].concat(m(n), m(Object.entries(e))); a < s.length; a++) {
      var r = g(s[a], 2),
          l = r[0],
          c = r[1];
      "t" === l ? o.set("start", parseInt(c)) : o.set(l, c);
    }

    o = o.toString();
    var h = t.match(/#t=((.*)?\d+s)/);
    return h && (o += "#t=".concat(h[1])), o;
  },
      Z = {
    video: {
      autoplay: !0,
      ratio: 16 / 9
    },
    youtube: {
      autohide: 1,
      fs: 1,
      rel: 0,
      hd: 1,
      wmode: "transparent",
      enablejsapi: 1,
      html5: 1
    },
    vimeo: {
      hd: 1,
      show_title: 1,
      show_byline: 1,
      show_portrait: 0,
      fullscreen: 1
    },
    html5video: {
      tpl: '<video class="fancybox__html5video" playsinline controls controlsList="nodownload" poster="{{poster}}">\n  <source src="{{src}}" type="{{format}}" />Sorry, your browser doesn\'t support embedded videos.</video>',
      format: ""
    }
  },
      G = function () {
    function t(e) {
      o(this, t), this.fancybox = e;

      for (var i = 0, n = ["onInit", "onReady", "onCreateSlide", "onRemoveSlide", "onSelectSlide", "onUnselectSlide", "onRefresh", "onMessage"]; i < n.length; i++) {
        var a = n[i];
        this[a] = this[a].bind(this);
      }

      this.events = {
        init: this.onInit,
        ready: this.onReady,
        "Carousel.createSlide": this.onCreateSlide,
        "Carousel.removeSlide": this.onRemoveSlide,
        "Carousel.selectSlide": this.onSelectSlide,
        "Carousel.unselectSlide": this.onUnselectSlide,
        "Carousel.refresh": this.onRefresh
      };
    }

    return s(t, [{
      key: "onInit",
      value: function () {
        var t,
            e = x(this.fancybox.items);

        try {
          for (e.s(); !(t = e.n()).done;) {
            var i = t.value;
            this.processType(i);
          }
        } catch (t) {
          e.e(t);
        } finally {
          e.f();
        }
      }
    }, {
      key: "processType",
      value: function (t) {
        if (t.html) return t.src = t.html, t.type = "html", void delete t.html;
        var e = t.src || "",
            i = t.type || this.fancybox.options.type,
            n = null;

        if (!e || "string" == typeof e) {
          if (n = e.match(/(?:youtube\.com|youtu\.be|youtube\-nocookie\.com)\/(?:watch\?(?:.*&)?v=|v\/|u\/|embed\/?)?(videoseries\?list=(?:.*)|[\w-]{11}|\?listType=(?:.*)&list=(?:.*))(?:.*)/i)) {
            var o = V(e, this.fancybox.option("Html.youtube")),
                a = encodeURIComponent(n[1]);
            t.videoId = a, t.src = "https://www.youtube-nocookie.com/embed/".concat(a, "?").concat(o), t.thumb = t.thumb || "https://i.ytimg.com/vi/".concat(a, "/mqdefault.jpg"), t.vendor = "youtube", i = "video";
          } else if (n = e.match(/^.+vimeo.com\/(?:\/)?([\d]+)(.*)?/)) {
            var s = V(e, this.fancybox.option("Html.vimeo")),
                r = encodeURIComponent(n[1]);
            t.videoId = r, t.src = "https://player.vimeo.com/video/".concat(r, "?").concat(s), t.vendor = "vimeo", i = "video";
          } else (n = e.match(/(?:maps\.)?google\.([a-z]{2,3}(?:\.[a-z]{2})?)\/(?:(?:(?:maps\/(?:place\/(?:.*)\/)?\@(.*),(\d+.?\d+?)z))|(?:\?ll=))(.*)?/i)) ? (t.src = "//maps.google.".concat(n[1], "/?ll=").concat((n[2] ? n[2] + "&z=" + Math.floor(n[3]) + (n[4] ? n[4].replace(/^\//, "&") : "") : n[4] + "").replace(/\?/, "&"), "&output=").concat(n[4] && n[4].indexOf("layer=c") > 0 ? "svembed" : "embed"), i = "map") : (n = e.match(/(?:maps\.)?google\.([a-z]{2,3}(?:\.[a-z]{2})?)\/(?:maps\/search\/)(.*)/i)) && (t.src = "//maps.google.".concat(n[1], "/maps?q=").concat(n[2].replace("query=", "q=").replace("api=1", ""), "&output=embed"), i = "map");

          i || ("#" === e.charAt(0) ? i = "inline" : (n = e.match(/\.(mp4|mov|ogv|webm)((\?|#).*)?$/i)) ? (i = "html5video", t.format = t.format || "video/" + ("ogv" === n[1] ? "ogg" : n[1])) : e.match(/(^data:image\/[a-z0-9+\/=]*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg|ico)((\?|#).*)?$)/i) ? i = "image" : e.match(/\.(pdf)((\?|#).*)?$/i) && (i = "pdf")), t.type = i || this.fancybox.option("defaultType", "image"), "html5video" !== i && "video" !== i || (t.video = k({}, this.fancybox.option("Html.video"), t.video), t._width && t._height ? t.ratio = parseFloat(t._width) / parseFloat(t._height) : t.ratio = t.ratio || t.video.ratio || Z.video.ratio);
        }
      }
    }, {
      key: "onReady",
      value: function () {
        var t = this;
        this.fancybox.Carousel.slides.forEach(function (e) {
          e.$el && (t.setContent(e), e.index === t.fancybox.getSlide().index && t.playVideo(e));
        });
      }
    }, {
      key: "onCreateSlide",
      value: function (t, e, i) {
        "ready" === this.fancybox.state && this.setContent(i);
      }
    }, {
      key: "loadInlineContent",
      value: function (t) {
        var e;
        if (t.src instanceof HTMLElement) e = t.src;else if ("string" == typeof t.src) {
          var i = t.src.split("#", 2),
              n = 2 === i.length && "" === i[0] ? i[1] : i[0];
          e = document.getElementById(n);
        }

        if (e) {
          if ("clone" === t.type || e.$placeHolder) {
            var o = (e = e.cloneNode(!0)).getAttribute("id");
            o = o ? "".concat(o, "--clone") : "clone-".concat(this.fancybox.id, "-").concat(t.index), e.setAttribute("id", o);
          } else {
            var a = document.createElement("div");
            a.classList.add("fancybox-placeholder"), e.parentNode.insertBefore(a, e), e.$placeHolder = a;
          }

          this.fancybox.setContent(t, e);
        } else this.fancybox.setError(t, "{{ELEMENT_NOT_FOUND}}");
      }
    }, {
      key: "loadAjaxContent",
      value: function (t) {
        var e = this.fancybox,
            i = new XMLHttpRequest();
        e.showLoading(t), i.onreadystatechange = function () {
          i.readyState === XMLHttpRequest.DONE && "ready" === e.state && (e.hideLoading(t), 200 === i.status ? e.setContent(t, i.responseText) : e.setError(t, 404 === i.status ? "{{AJAX_NOT_FOUND}}" : "{{AJAX_FORBIDDEN}}"));
        };
        var n = t.ajax || null;
        i.open(n ? "POST" : "GET", t.src), i.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), i.setRequestHeader("X-Requested-With", "XMLHttpRequest"), i.send(n), t.xhr = i;
      }
    }, {
      key: "loadIframeContent",
      value: function (t) {
        var e = this,
            i = this.fancybox,
            n = document.createElement("iframe");
        if (n.className = "fancybox__iframe", n.setAttribute("id", "fancybox__iframe_".concat(i.id, "_").concat(t.index)), n.setAttribute("allow", "autoplay; fullscreen"), n.setAttribute("scrolling", "auto"), t.$iframe = n, "iframe" !== t.type || !1 === t.preload) return n.setAttribute("src", t.src), this.fancybox.setContent(t, n), void this.resizeIframe(t);
        i.showLoading(t);
        var o = document.createElement("div");
        o.style.visibility = "hidden", this.fancybox.setContent(t, o), o.appendChild(n), n.onerror = function () {
          i.setError(t, "{{IFRAME_ERROR}}");
        }, n.onload = function () {
          i.hideLoading(t);
          var o = !1;
          n.isReady || (n.isReady = !0, o = !0), n.src.length && (n.parentNode.style.visibility = "", e.resizeIframe(t), o && i.revealContent(t));
        }, n.setAttribute("src", t.src);
      }
    }, {
      key: "setAspectRatio",
      value: function (t) {
        var e = t.$content,
            i = t.ratio;

        if (e) {
          var n = t._width,
              o = t._height;

          if (i || n && o) {
            Object.assign(e.style, {
              width: n && o ? "100%" : "",
              height: n && o ? "100%" : "",
              maxWidth: "",
              maxHeight: ""
            });
            var a = e.offsetWidth,
                s = e.offsetHeight;

            if (o = o || s, (n = n || a) > a || o > s) {
              var r = Math.min(a / n, s / o);
              n *= r, o *= r;
            }

            Math.abs(n / o - i) > 0.01 && (i < n / o ? n = o * i : o = n / i), Object.assign(e.style, {
              width: "".concat(n, "px"),
              height: "".concat(o, "px")
            });
          }
        }
      }
    }, {
      key: "resizeIframe",
      value: function (t) {
        var e = t.$iframe;

        if (e) {
          var i = t._width || 0,
              n = t._height || 0;
          i && n && (t.autoSize = !1);
          var o = e.parentNode,
              a = o && o.style;
          if (!1 !== t.preload && !1 !== t.autoSize && a) try {
            var s = window.getComputedStyle(o),
                r = parseFloat(s.paddingLeft) + parseFloat(s.paddingRight),
                l = parseFloat(s.paddingTop) + parseFloat(s.paddingBottom),
                c = e.contentWindow.document,
                h = c.getElementsByTagName("html")[0],
                d = c.body;
            a.width = "", d.style.overflow = "hidden", i = i || h.scrollWidth + r, a.width = "".concat(i, "px"), d.style.overflow = "", a.flex = "0 0 auto", a.height = "".concat(d.scrollHeight, "px"), n = h.scrollHeight + l;
          } catch (t) {}

          if (i || n) {
            var u = {
              flex: "0 1 auto"
            };
            i && (u.width = "".concat(i, "px")), n && (u.height = "".concat(n, "px")), Object.assign(a, u);
          }
        }
      }
    }, {
      key: "onRefresh",
      value: function (t, e) {
        var i = this;
        e.slides.forEach(function (t) {
          t.$el && (t.$iframe && i.resizeIframe(t), t.ratio && i.setAspectRatio(t));
        });
      }
    }, {
      key: "setContent",
      value: function (t) {
        if (t && !t.isDom) {
          switch (t.type) {
            case "html":
              this.fancybox.setContent(t, t.src);
              break;

            case "html5video":
              this.fancybox.setContent(t, this.fancybox.option("Html.html5video.tpl").replace(/\{\{src\}\}/gi, t.src).replace("{{format}}", t.format || t.html5video && t.html5video.format || "").replace("{{poster}}", t.poster || t.thumb || ""));
              break;

            case "inline":
            case "clone":
              this.loadInlineContent(t);
              break;

            case "ajax":
              this.loadAjaxContent(t);
              break;

            case "pdf":
            case "video":
            case "map":
              t.preload = !1;

            case "iframe":
              this.loadIframeContent(t);
          }

          t.ratio && this.setAspectRatio(t);
        }
      }
    }, {
      key: "onSelectSlide",
      value: function (t, e, i) {
        "ready" === t.state && this.playVideo(i);
      }
    }, {
      key: "playVideo",
      value: function (t) {
        if ("html5video" === t.type && t.video.autoplay) try {
          var e = t.$el.querySelector("video");

          if (e) {
            var i = e.play();
            void 0 !== i && i.then(function () {}).catch(function (t) {
              e.muted = !0, e.play();
            });
          }
        } catch (t) {}

        if ("video" === t.type && t.$iframe && t.$iframe.contentWindow) {
          !function e() {
            if ("done" === t.state && t.$iframe && t.$iframe.contentWindow) {
              var i;
              if (t.$iframe.isReady) return t.video && t.video.autoplay && (i = "youtube" == t.vendor ? {
                event: "command",
                func: "playVideo"
              } : {
                method: "play",
                value: "true"
              }), void (i && t.$iframe.contentWindow.postMessage(JSON.stringify(i), "*"));
              "youtube" === t.vendor && (i = {
                event: "listening",
                id: t.$iframe.getAttribute("id")
              }, t.$iframe.contentWindow.postMessage(JSON.stringify(i), "*"));
            }

            t.poller = setTimeout(e, 250);
          }();
        }
      }
    }, {
      key: "onUnselectSlide",
      value: function (t, e, i) {
        if ("html5video" !== i.type) {
          var n = !1;
          "vimeo" == i.vendor ? n = {
            method: "pause",
            value: "true"
          } : "youtube" === i.vendor && (n = {
            event: "command",
            func: "pauseVideo"
          }), n && i.$iframe && i.$iframe.contentWindow && i.$iframe.contentWindow.postMessage(JSON.stringify(n), "*"), clearTimeout(i.poller);
        } else try {
          i.$el.querySelector("video").pause();
        } catch (t) {}
      }
    }, {
      key: "onRemoveSlide",
      value: function (t, e, i) {
        i.xhr && (i.xhr.abort(), i.xhr = null), i.$iframe && (i.$iframe.onload = i.$iframe.onerror = null, i.$iframe.src = "//about:blank", i.$iframe = null);
        var n = i.$content;
        "inline" === i.type && n && (n.classList.remove("fancybox__content"), "none" !== n.style.display && (n.style.display = "none")), i.$closeButton && (i.$closeButton.remove(), i.$closeButton = null);
        var o = n && n.$placeHolder;
        o && (o.parentNode.insertBefore(n, o), o.remove(), n.$placeHolder = null);
      }
    }, {
      key: "onMessage",
      value: function (t) {
        try {
          var e = JSON.parse(t.data);

          if ("https://player.vimeo.com" === t.origin) {
            if ("ready" === e.event) {
              var i,
                  n = x(document.getElementsByClassName("fancybox__iframe"));

              try {
                for (n.s(); !(i = n.n()).done;) {
                  var o = i.value;
                  o.contentWindow === t.source && (o.isReady = 1);
                }
              } catch (t) {
                n.e(t);
              } finally {
                n.f();
              }
            }
          } else "https://www.youtube-nocookie.com" === t.origin && "onReady" === e.event && (document.getElementById(e.id).isReady = 1);
        } catch (t) {}
      }
    }, {
      key: "attach",
      value: function () {
        this.fancybox.on(this.events), window.addEventListener("message", this.onMessage, !1);
      }
    }, {
      key: "detach",
      value: function () {
        this.fancybox.off(this.events), window.removeEventListener("message", this.onMessage, !1);
      }
    }]), t;
  }();

  G.defaults = Z;

  var K = function () {
    function t(e) {
      o(this, t), this.fancybox = e;

      for (var i = 0, n = ["onReady", "onClosing", "onDone", "onPageChange", "onCreateSlide", "onRemoveSlide", "onImageStatusChange"]; i < n.length; i++) {
        var a = n[i];
        this[a] = this[a].bind(this);
      }

      this.events = {
        ready: this.onReady,
        closing: this.onClosing,
        done: this.onDone,
        "Carousel.change": this.onPageChange,
        "Carousel.createSlide": this.onCreateSlide,
        "Carousel.removeSlide": this.onRemoveSlide
      };
    }

    return s(t, [{
      key: "onReady",
      value: function () {
        var t = this;
        this.fancybox.Carousel.slides.forEach(function (e) {
          e.$el && t.setContent(e);
        });
      }
    }, {
      key: "onDone",
      value: function (t, e) {
        this.handleCursor(e);
      }
    }, {
      key: "onClosing",
      value: function (t) {
        clearTimeout(this.clickTimer), this.clickTimer = null, t.Carousel.slides.forEach(function (t) {
          t.$image && (t.state = "destroy"), t.Panzoom && t.Panzoom.detachEvents();
        }), "closing" === this.fancybox.state && this.canZoom(t.getSlide()) && this.zoomOut();
      }
    }, {
      key: "onCreateSlide",
      value: function (t, e, i) {
        "ready" === this.fancybox.state && this.setContent(i);
      }
    }, {
      key: "onRemoveSlide",
      value: function (t, e, i) {
        i.$image && (i.$el.classList.remove(t.option("Image.canZoomInClass")), i.$image.remove(), i.$image = null), i.Panzoom && (i.Panzoom.destroy(), i.Panzoom = null), i.$el && i.$el.dataset && delete i.$el.dataset.imageFit;
      }
    }, {
      key: "setContent",
      value: function (t) {
        var e = this;

        if (!(t.isDom || t.html || t.type && "image" !== t.type || t.$image)) {
          t.type = "image", t.state = "loading";
          var i = document.createElement("div");
          i.style.visibility = "hidden";
          var n = document.createElement("img");
          n.addEventListener("load", function (i) {
            i.stopImmediatePropagation(), e.onImageStatusChange(t);
          }), n.addEventListener("error", function () {
            e.onImageStatusChange(t);
          }), n.src = t.src, n.alt = "", n.draggable = !1, n.classList.add("fancybox__image"), t.srcset && n.setAttribute("srcset", t.srcset), t.sizes && n.setAttribute("sizes", t.sizes), t.$image = n;
          var o = this.fancybox.option("Image.wrap");

          if (o) {
            var a = document.createElement("div");
            a.classList.add("string" == typeof o ? o : "fancybox__image-wrap"), a.appendChild(n), i.appendChild(a), t.$wrap = a;
          } else i.appendChild(n);

          t.$el.dataset.imageFit = this.fancybox.option("Image.fit"), this.fancybox.setContent(t, i), n.complete || n.error ? this.onImageStatusChange(t) : this.fancybox.showLoading(t);
        }
      }
    }, {
      key: "onImageStatusChange",
      value: function (t) {
        var e = this,
            i = t.$image;
        i && "loading" === t.state && (i.complete && i.naturalWidth && i.naturalHeight ? (this.fancybox.hideLoading(t), "contain" === this.fancybox.option("Image.fit") && this.initSlidePanzoom(t), t.$el.addEventListener("wheel", function (i) {
          return e.onWheel(t, i);
        }, {
          passive: !1
        }), t.$content.addEventListener("click", function (i) {
          return e.onClick(t, i);
        }, {
          passive: !1
        }), this.revealContent(t)) : this.fancybox.setError(t, "{{IMAGE_ERROR}}"));
      }
    }, {
      key: "initSlidePanzoom",
      value: function (t) {
        var e = this;
        t.Panzoom || (t.Panzoom = new M(t.$el, k(!0, this.fancybox.option("Image.Panzoom", {}), {
          viewport: t.$wrap,
          content: t.$image,
          width: t._width,
          height: t._height,
          wrapInner: !1,
          textSelection: !0,
          touch: this.fancybox.option("Image.touch"),
          panOnlyZoomed: !0,
          click: !1,
          wheel: !1
        })), t.Panzoom.on("startAnimation", function () {
          e.fancybox.trigger("Image.startAnimation", t);
        }), t.Panzoom.on("endAnimation", function () {
          "zoomIn" === t.state && e.fancybox.done(t), e.handleCursor(t), e.fancybox.trigger("Image.endAnimation", t);
        }), t.Panzoom.on("afterUpdate", function () {
          e.handleCursor(t), e.fancybox.trigger("Image.afterUpdate", t);
        }));
      }
    }, {
      key: "revealContent",
      value: function (t) {
        null === this.fancybox.Carousel.prevPage && t.index === this.fancybox.options.startIndex && this.canZoom(t) ? this.zoomIn() : this.fancybox.revealContent(t);
      }
    }, {
      key: "getZoomInfo",
      value: function (t) {
        var e = t.$thumb.getBoundingClientRect(),
            i = e.width,
            n = e.height,
            o = t.$content.getBoundingClientRect(),
            a = o.width,
            s = o.height,
            r = o.top - e.top,
            l = o.left - e.left,
            c = this.fancybox.option("Image.zoomOpacity");
        return "auto" === c && (c = Math.abs(i / n - a / s) > 0.1), {
          top: r,
          left: l,
          scale: a && i ? i / a : 1,
          opacity: c
        };
      }
    }, {
      key: "canZoom",
      value: function (t) {
        var e = this.fancybox,
            i = e.$container;
        if (window.visualViewport && 1 !== window.visualViewport.scale) return !1;
        if (t.Panzoom && !t.Panzoom.content.width) return !1;
        if (!e.option("Image.zoom") || "contain" !== e.option("Image.fit")) return !1;
        var n = t.$thumb;
        if (!n || "loading" === t.state) return !1;
        i.classList.add("fancybox__no-click");
        var o,
            a = n.getBoundingClientRect();

        if (this.fancybox.option("Image.ignoreCoveredThumbnail")) {
          var s = document.elementFromPoint(a.left + 1, a.top + 1) === n,
              r = document.elementFromPoint(a.right - 1, a.bottom - 1) === n;
          o = s && r;
        } else o = document.elementFromPoint(a.left + 0.5 * a.width, a.top + 0.5 * a.height) === n;

        return i.classList.remove("fancybox__no-click"), o;
      }
    }, {
      key: "zoomIn",
      value: function () {
        var t = this.fancybox,
            e = t.getSlide(),
            i = e.Panzoom,
            n = this.getZoomInfo(e),
            o = n.top,
            a = n.left,
            s = n.scale,
            r = n.opacity;
        t.trigger("reveal", e), i.panTo({
          x: -1 * a,
          y: -1 * o,
          scale: s,
          friction: 0,
          ignoreBounds: !0
        }), e.$content.style.visibility = "", e.state = "zoomIn", !0 === r && i.on("afterTransform", function (t) {
          "zoomIn" !== e.state && "zoomOut" !== e.state || (t.$content.style.opacity = Math.min(1, 1 - (1 - t.content.scale) / (1 - s)));
        }), i.panTo({
          x: 0,
          y: 0,
          scale: 1,
          friction: this.fancybox.option("Image.zoomFriction")
        });
      }
    }, {
      key: "zoomOut",
      value: function () {
        var t = this,
            e = this.fancybox,
            i = e.getSlide(),
            n = i.Panzoom;

        if (n) {
          i.state = "zoomOut", e.state = "customClosing", i.$caption && (i.$caption.style.visibility = "hidden");

          var o = this.fancybox.option("Image.zoomFriction"),
              a = function (e) {
            var a = t.getZoomInfo(i),
                s = a.top,
                r = a.left,
                l = a.scale,
                c = a.opacity;
            e || c || (o *= 0.82), n.panTo({
              x: -1 * r,
              y: -1 * s,
              scale: l,
              friction: o,
              ignoreBounds: !0
            }), o *= 0.98;
          };

          window.addEventListener("scroll", a), n.once("endAnimation", function () {
            window.removeEventListener("scroll", a), e.destroy();
          }), a();
        }
      }
    }, {
      key: "handleCursor",
      value: function (t) {
        if ("image" === t.type && t.$el) {
          var e = t.Panzoom,
              i = this.fancybox.option("Image.click", !1, t),
              n = this.fancybox.option("Image.touch"),
              o = t.$el.classList,
              a = this.fancybox.option("Image.canZoomInClass"),
              s = this.fancybox.option("Image.canZoomOutClass");
          if (o.remove(s), o.remove(a), e && "toggleZoom" === i) e && 1 === e.content.scale && e.option("maxScale") - e.content.scale > 0.01 ? o.add(a) : e.content.scale > 1 && !n && o.add(s);else "close" === i && o.add(s);
        }
      }
    }, {
      key: "onWheel",
      value: function (t, e) {
        if ("ready" === this.fancybox.state && !1 !== this.fancybox.trigger("Image.wheel", e)) switch (this.fancybox.option("Image.wheel")) {
          case "zoom":
            "done" === t.state && t.Panzoom && t.Panzoom.zoomWithWheel(e);
            break;

          case "close":
            this.fancybox.close();
            break;

          case "slide":
            this.fancybox[e.deltaY < 0 ? "prev" : "next"]();
        }
      }
    }, {
      key: "onClick",
      value: function (t, e) {
        var i = this;

        if ("ready" === this.fancybox.state) {
          var n = t.Panzoom;

          if (!n || !n.dragPosition.midPoint && 0 === n.dragOffset.x && 0 === n.dragOffset.y && 1 === n.dragOffset.scale) {
            if (this.fancybox.Carousel.Panzoom.lockAxis) return !1;

            var o = function (n) {
              switch (n) {
                case "toggleZoom":
                  e.stopPropagation(), t.Panzoom && t.Panzoom.zoomWithClick(e);
                  break;

                case "close":
                  i.fancybox.close();
                  break;

                case "next":
                  e.stopPropagation(), i.fancybox.next();
              }
            },
                a = this.fancybox.option("Image.click"),
                s = this.fancybox.option("Image.doubleClick");

            s ? this.clickTimer ? (clearTimeout(this.clickTimer), this.clickTimer = null, o(s)) : this.clickTimer = setTimeout(function () {
              i.clickTimer = null, o(a);
            }, 300) : o(a);
          }
        }
      }
    }, {
      key: "onPageChange",
      value: function (t, e) {
        var i = t.getSlide();
        e.slides.forEach(function (t) {
          t.Panzoom && "done" === t.state && t.index !== i.index && t.Panzoom.panTo({
            x: 0,
            y: 0,
            scale: 1,
            friction: 0.8
          });
        });
      }
    }, {
      key: "attach",
      value: function () {
        this.fancybox.on(this.events);
      }
    }, {
      key: "detach",
      value: function () {
        this.fancybox.off(this.events);
      }
    }]), t;
  }();

  K.defaults = {
    canZoomInClass: "can-zoom_in",
    canZoomOutClass: "can-zoom_out",
    zoom: !0,
    zoomOpacity: "auto",
    zoomFriction: 0.82,
    ignoreCoveredThumbnail: !1,
    touch: !0,
    click: "toggleZoom",
    doubleClick: null,
    wheel: "zoom",
    fit: "contain",
    wrap: !1,
    Panzoom: {
      ratio: 1
    }
  };

  var J = function () {
    function t(e) {
      o(this, t), this.fancybox = e;

      for (var i = 0, n = ["onChange", "onClosing"]; i < n.length; i++) {
        var a = n[i];
        this[a] = this[a].bind(this);
      }

      this.events = {
        initCarousel: this.onChange,
        "Carousel.change": this.onChange,
        closing: this.onClosing
      }, this.hasCreatedHistory = !1, this.origHash = "", this.timer = null;
    }

    return s(t, [{
      key: "onChange",
      value: function (t) {
        var e = this,
            i = t.Carousel;
        this.timer && clearTimeout(this.timer);
        var n = null === i.prevPage,
            o = t.getSlide(),
            a = new URL(document.URL).hash,
            s = !1;
        if (o.slug) s = "#" + o.slug;else {
          var r = o.$trigger && o.$trigger.dataset,
              l = t.option("slug") || r && r.fancybox;
          l && l.length && "true" !== l && (s = "#" + l + (i.slides.length > 1 ? "-" + (o.index + 1) : ""));
        }
        n && (this.origHash = a !== s ? a : ""), s && a !== s && (this.timer = setTimeout(function () {
          try {
            window.history[n ? "pushState" : "replaceState"]({}, document.title, window.location.pathname + window.location.search + s), n && (e.hasCreatedHistory = !0);
          } catch (t) {}
        }, 300));
      }
    }, {
      key: "onClosing",
      value: function () {
        if (this.timer && clearTimeout(this.timer), !0 !== this.hasSilentClose) try {
          return void window.history.replaceState({}, document.title, window.location.pathname + window.location.search + (this.origHash || ""));
        } catch (t) {}
      }
    }, {
      key: "attach",
      value: function (t) {
        t.on(this.events);
      }
    }, {
      key: "detach",
      value: function (t) {
        t.off(this.events);
      }
    }], [{
      key: "startFromUrl",
      value: function () {
        var e = t.Fancybox;

        if (e && !e.getInstance() && !1 !== e.defaults.Hash) {
          var i = t.getParsedURL(),
              n = i.hash,
              o = i.slug,
              a = i.index;

          if (o) {
            var s = document.querySelector('[data-slug="'.concat(n, '"]'));

            if (s && s.dispatchEvent(new CustomEvent("click", {
              bubbles: !0,
              cancelable: !0
            })), !e.getInstance()) {
              var r = document.querySelectorAll('[data-fancybox="'.concat(o, '"]'));
              r.length && (null === a && 1 === r.length ? s = r[0] : a && (s = r[a - 1]), s && s.dispatchEvent(new CustomEvent("click", {
                bubbles: !0,
                cancelable: !0
              })));
            }
          }
        }
      }
    }, {
      key: "onHashChange",
      value: function () {
        var e = t.getParsedURL(),
            i = e.slug,
            n = e.index,
            o = t.Fancybox,
            a = o && o.getInstance();

        if (a && a.plugins.Hash) {
          if (i) {
            var s = a.Carousel;
            if (i === a.option("slug")) return s.slideTo(n - 1);
            var r,
                l = x(s.slides);

            try {
              for (l.s(); !(r = l.n()).done;) {
                var c = r.value;
                if (c.slug && c.slug === i) return s.slideTo(c.index);
              }
            } catch (t) {
              l.e(t);
            } finally {
              l.f();
            }

            var h = a.getSlide(),
                d = h.$trigger && h.$trigger.dataset;
            if (d && d.fancybox === i) return s.slideTo(n - 1);
          }

          a.plugins.Hash.hasSilentClose = !0, a.close();
        }

        t.startFromUrl();
      }
    }, {
      key: "create",
      value: function (e) {
        function i() {
          window.addEventListener("hashchange", t.onHashChange, !1), t.startFromUrl();
        }

        t.Fancybox = e, W && window.requestAnimationFrame(function () {
          /complete|interactive|loaded/.test(document.readyState) ? i() : document.addEventListener("DOMContentLoaded", i);
        });
      }
    }, {
      key: "destroy",
      value: function () {
        window.removeEventListener("hashchange", t.onHashChange, !1);
      }
    }, {
      key: "getParsedURL",
      value: function () {
        var t = window.location.hash.substr(1),
            e = t.split("-"),
            i = e.length > 1 && /^\+?\d+$/.test(e[e.length - 1]) && parseInt(e.pop(-1), 10) || null;
        return {
          hash: t,
          slug: e.join("-"),
          index: i
        };
      }
    }]), t;
  }(),
      Q = {
    pageXOffset: 0,
    pageYOffset: 0,
    element: function () {
      return document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement;
    },
    activate: function (t) {
      Q.pageXOffset = window.pageXOffset, Q.pageYOffset = window.pageYOffset, t.requestFullscreen ? t.requestFullscreen() : t.mozRequestFullScreen ? t.mozRequestFullScreen() : t.webkitRequestFullscreen ? t.webkitRequestFullscreen() : t.msRequestFullscreen && t.msRequestFullscreen();
    },
    deactivate: function () {
      document.exitFullscreen ? document.exitFullscreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitExitFullscreen && document.webkitExitFullscreen();
    }
  },
      tt = function () {
    function t(e) {
      o(this, t), this.fancybox = e, this.active = !1, this.handleVisibilityChange = this.handleVisibilityChange.bind(this);
    }

    return s(t, [{
      key: "isActive",
      value: function () {
        return this.active;
      }
    }, {
      key: "setTimer",
      value: function () {
        var t = this;

        if (this.active && !this.timer) {
          var e = this.fancybox.option("slideshow.delay", 3e3);
          this.timer = setTimeout(function () {
            t.timer = null, t.fancybox.option("infinite") || t.fancybox.getSlide().index !== t.fancybox.Carousel.slides.length - 1 ? t.fancybox.next() : t.fancybox.jumpTo(0, {
              friction: 0
            });
          }, e);
          var i = this.$progress;
          i || ((i = document.createElement("div")).classList.add("fancybox__progress"), this.fancybox.$carousel.parentNode.insertBefore(i, this.fancybox.$carousel), this.$progress = i, i.offsetHeight), i.style.transitionDuration = "".concat(e, "ms"), i.style.transform = "scaleX(1)";
        }
      }
    }, {
      key: "clearTimer",
      value: function () {
        clearTimeout(this.timer), this.timer = null, this.$progress && (this.$progress.style.transitionDuration = "", this.$progress.style.transform = "", this.$progress.offsetHeight);
      }
    }, {
      key: "activate",
      value: function () {
        this.active || (this.active = !0, this.fancybox.$container.classList.add("has-slideshow"), "done" === this.fancybox.getSlide().state && this.setTimer(), document.addEventListener("visibilitychange", this.handleVisibilityChange, !1));
      }
    }, {
      key: "handleVisibilityChange",
      value: function () {
        this.deactivate();
      }
    }, {
      key: "deactivate",
      value: function () {
        this.active = !1, this.clearTimer(), this.fancybox.$container.classList.remove("has-slideshow"), document.removeEventListener("visibilitychange", this.handleVisibilityChange, !1);
      }
    }, {
      key: "toggle",
      value: function () {
        this.active ? this.deactivate() : this.fancybox.Carousel.slides.length > 1 && this.activate();
      }
    }]), t;
  }(),
      et = {
    display: ["counter", "zoom", "slideshow", "fullscreen", "thumbs", "close"],
    autoEnable: !0,
    items: {
      counter: {
        position: "left",
        type: "div",
        class: "fancybox__counter",
        html: '<span data-fancybox-index=""></span>&nbsp;/&nbsp;<span data-fancybox-count=""></span>',
        attr: {
          tabindex: -1
        }
      },
      prev: {
        type: "button",
        class: "fancybox__button--prev",
        label: "PREV",
        html: '<svg viewBox="0 0 24 24"><path d="M15 4l-8 8 8 8"/></svg>',
        attr: {
          "data-fancybox-prev": ""
        }
      },
      next: {
        type: "button",
        class: "fancybox__button--next",
        label: "NEXT",
        html: '<svg viewBox="0 0 24 24"><path d="M8 4l8 8-8 8"/></svg>',
        attr: {
          "data-fancybox-next": ""
        }
      },
      fullscreen: {
        type: "button",
        class: "fancybox__button--fullscreen",
        label: "TOGGLE_FULLSCREEN",
        html: '<svg viewBox="0 0 24 24">\n                <g><path d="M3 8 V3h5"></path><path d="M21 8V3h-5"></path><path d="M8 21H3v-5"></path><path d="M16 21h5v-5"></path></g>\n                <g><path d="M7 2v5H2M17 2v5h5M2 17h5v5M22 17h-5v5"/></g>\n            </svg>',
        click: function (t) {
          t.preventDefault(), Q.element() ? Q.deactivate() : Q.activate(this.fancybox.$container);
        }
      },
      slideshow: {
        type: "button",
        class: "fancybox__button--slideshow",
        label: "TOGGLE_SLIDESHOW",
        html: '<svg viewBox="0 0 24 24">\n                <g><path d="M6 4v16"/><path d="M20 12L6 20"/><path d="M20 12L6 4"/></g>\n                <g><path d="M7 4v15M17 4v15"/></g>\n            </svg>',
        click: function (t) {
          t.preventDefault(), this.Slideshow.toggle();
        }
      },
      zoom: {
        type: "button",
        class: "fancybox__button--zoom",
        label: "TOGGLE_ZOOM",
        html: '<svg viewBox="0 0 24 24"><circle cx="10" cy="10" r="7"></circle><path d="M16 16 L21 21"></svg>',
        click: function (t) {
          t.preventDefault();
          var e = this.fancybox.getSlide().Panzoom;
          e && e.toggleZoom();
        }
      },
      download: {
        type: "link",
        label: "DOWNLOAD",
        class: "fancybox__button--download",
        html: '<svg viewBox="0 0 24 24"><path d="M12 15V3m0 12l-4-4m4 4l4-4M2 17l.62 2.48A2 2 0 004.56 21h14.88a2 2 0 001.94-1.51L22 17"/></svg>',
        click: function (t) {
          t.stopPropagation();
        }
      },
      thumbs: {
        type: "button",
        label: "TOGGLE_THUMBS",
        class: "fancybox__button--thumbs",
        html: '<svg viewBox="0 0 24 24"><circle cx="4" cy="4" r="1" /><circle cx="12" cy="4" r="1" transform="rotate(90 12 4)"/><circle cx="20" cy="4" r="1" transform="rotate(90 20 4)"/><circle cx="4" cy="12" r="1" transform="rotate(90 4 12)"/><circle cx="12" cy="12" r="1" transform="rotate(90 12 12)"/><circle cx="20" cy="12" r="1" transform="rotate(90 20 12)"/><circle cx="4" cy="20" r="1" transform="rotate(90 4 20)"/><circle cx="12" cy="20" r="1" transform="rotate(90 12 20)"/><circle cx="20" cy="20" r="1" transform="rotate(90 20 20)"/></svg>',
        click: function (t) {
          t.stopPropagation();
          var e = this.fancybox.plugins.Thumbs;
          e && e.toggle();
        }
      },
      close: {
        type: "button",
        label: "CLOSE",
        class: "fancybox__button--close",
        html: '<svg viewBox="0 0 24 24"><path d="M20 20L4 4m16 0L4 20"></path></svg>',
        attr: {
          "data-fancybox-close": "",
          tabindex: 0
        }
      }
    }
  },
      it = function () {
    function t(e) {
      var i = this;
      o(this, t), this.fancybox = e, this.$container = null, this.state = "init";

      for (var n = 0, a = ["onInit", "onPrepare", "onDone", "onKeydown", "onClosing", "onChange", "onSettle", "onRefresh"]; n < a.length; n++) {
        var s = a[n];
        this[s] = this[s].bind(this);
      }

      this.events = {
        init: this.onInit,
        prepare: this.onPrepare,
        done: this.onDone,
        keydown: this.onKeydown,
        closing: this.onClosing,
        "Carousel.change": this.onChange,
        "Carousel.settle": this.onSettle,
        "Carousel.Panzoom.touchStart": function () {
          return i.onRefresh();
        },
        "Image.startAnimation": function (t, e) {
          return i.onRefresh(e);
        },
        "Image.afterUpdate": function (t, e) {
          return i.onRefresh(e);
        }
      };
    }

    return s(t, [{
      key: "onInit",
      value: function () {
        if (this.fancybox.option("Toolbar.autoEnable")) {
          var t,
              e = !1,
              i = x(this.fancybox.items);

          try {
            for (i.s(); !(t = i.n()).done;) {
              if ("image" === t.value.type) {
                e = !0;
                break;
              }
            }
          } catch (t) {
            i.e(t);
          } finally {
            i.f();
          }

          if (!e) return void (this.state = "disabled");
        }

        var n,
            o = x(this.fancybox.option("Toolbar.display"));

        try {
          for (o.s(); !(n = o.n()).done;) {
            var a = n.value;

            if ("close" === (w(a) ? a.id : a)) {
              this.fancybox.options.closeButton = !1;
              break;
            }
          }
        } catch (t) {
          o.e(t);
        } finally {
          o.f();
        }
      }
    }, {
      key: "onPrepare",
      value: function () {
        var t = this.fancybox;
        if ("init" === this.state && (this.build(), this.update(), this.Slideshow = new tt(t), !t.Carousel.prevPage && (t.option("slideshow.autoStart") && this.Slideshow.activate(), t.option("fullscreen.autoStart") && !Q.element()))) try {
          Q.activate(t.$container);
        } catch (t) {}
      }
    }, {
      key: "onFsChange",
      value: function () {
        window.scrollTo(Q.pageXOffset, Q.pageYOffset);
      }
    }, {
      key: "onSettle",
      value: function () {
        var t = this.fancybox,
            e = this.Slideshow;
        e && e.isActive() && (t.getSlide().index !== t.Carousel.slides.length - 1 || t.option("infinite") ? "done" === t.getSlide().state && e.setTimer() : e.deactivate());
      }
    }, {
      key: "onChange",
      value: function () {
        this.update(), this.Slideshow && this.Slideshow.isActive() && this.Slideshow.clearTimer();
      }
    }, {
      key: "onDone",
      value: function (t, e) {
        var i = this.Slideshow;
        e.index === t.getSlide().index && (this.update(), i && i.isActive() && (t.option("infinite") || e.index !== t.Carousel.slides.length - 1 ? i.setTimer() : i.deactivate()));
      }
    }, {
      key: "onRefresh",
      value: function (t) {
        t && t.index !== this.fancybox.getSlide().index || (this.update(), !this.Slideshow || !this.Slideshow.isActive() || t && "done" !== t.state || this.Slideshow.deactivate());
      }
    }, {
      key: "onKeydown",
      value: function (t, e, i) {
        " " === e && this.Slideshow && (this.Slideshow.toggle(), i.preventDefault());
      }
    }, {
      key: "onClosing",
      value: function () {
        this.Slideshow && this.Slideshow.deactivate(), document.removeEventListener("fullscreenchange", this.onFsChange);
      }
    }, {
      key: "createElement",
      value: function (t) {
        var e, i;
        ("div" === t.type ? e = document.createElement("div") : (e = document.createElement("link" === t.type ? "a" : "button")).classList.add("carousel__button"), e.innerHTML = t.html, e.setAttribute("tabindex", t.tabindex || 0), t.class) && (i = e.classList).add.apply(i, m(t.class.split(" ")));

        for (var n in t.attr) e.setAttribute(n, t.attr[n]);

        t.label && e.setAttribute("title", this.fancybox.localize("{{".concat(t.label, "}}"))), t.click && e.addEventListener("click", t.click.bind(this)), "prev" === t.id && e.setAttribute("data-fancybox-prev", ""), "next" === t.id && e.setAttribute("data-fancybox-next", "");
        var o = e.querySelector("svg");
        return o && (o.setAttribute("role", "img"), o.setAttribute("tabindex", "-1"), o.setAttribute("xmlns", "http://www.w3.org/2000/svg")), e;
      }
    }, {
      key: "build",
      value: function () {
        var t = this;
        this.cleanup();
        var e,
            i = this.fancybox.option("Toolbar.items"),
            n = [{
          position: "left",
          items: []
        }, {
          position: "center",
          items: []
        }, {
          position: "right",
          items: []
        }],
            o = this.fancybox.plugins.Thumbs,
            a = x(this.fancybox.option("Toolbar.display"));

        try {
          var s = function () {
            var a = e.value,
                s = void 0,
                r = void 0;
            if (w(a) ? (s = a.id, r = k({}, i[s], a)) : r = i[s = a], ["counter", "next", "prev", "slideshow"].includes(s) && t.fancybox.items.length < 2) return "continue";

            if ("fullscreen" === s) {
              if (!document.fullscreenEnabled || window.fullScreen) return "continue";
              document.addEventListener("fullscreenchange", t.onFsChange);
            }

            if ("thumbs" === s && (!o || "disabled" === o.state)) return "continue";
            if (!r) return "continue";
            var l = r.position || "right",
                c = n.find(function (t) {
              return t.position === l;
            });
            c && c.items.push(r);
          };

          for (a.s(); !(e = a.n()).done;) s();
        } catch (t) {
          a.e(t);
        } finally {
          a.f();
        }

        var r = document.createElement("div");
        r.classList.add("fancybox__toolbar");

        for (var l = 0, c = n; l < c.length; l++) {
          var h = c[l];

          if (h.items.length) {
            var d = document.createElement("div");
            d.classList.add("fancybox__toolbar__items"), d.classList.add("fancybox__toolbar__items--".concat(h.position));
            var u,
                f = x(h.items);

            try {
              for (f.s(); !(u = f.n()).done;) {
                var v = u.value;
                d.appendChild(this.createElement(v));
              }
            } catch (t) {
              f.e(t);
            } finally {
              f.f();
            }

            r.appendChild(d);
          }
        }

        this.fancybox.$carousel.parentNode.insertBefore(r, this.fancybox.$carousel), this.$container = r;
      }
    }, {
      key: "update",
      value: function () {
        var t,
            e = this.fancybox.getSlide(),
            i = e.index,
            n = this.fancybox.items.length,
            o = e.downloadSrc || ("image" !== e.type || e.error ? null : e.src),
            a = x(this.fancybox.$container.querySelectorAll("a.fancybox__button--download"));

        try {
          for (a.s(); !(t = a.n()).done;) {
            var s = t.value;
            o ? (s.removeAttribute("disabled"), s.removeAttribute("tabindex"), s.setAttribute("href", o), s.setAttribute("download", o), s.setAttribute("target", "_blank")) : (s.setAttribute("disabled", ""), s.setAttribute("tabindex", -1), s.removeAttribute("href"), s.removeAttribute("download"));
          }
        } catch (t) {
          a.e(t);
        } finally {
          a.f();
        }

        var r,
            l = e.Panzoom,
            c = l && l.option("maxScale") > l.option("baseScale"),
            h = x(this.fancybox.$container.querySelectorAll(".fancybox__button--zoom"));

        try {
          for (h.s(); !(r = h.n()).done;) {
            var d = r.value;
            c ? d.removeAttribute("disabled") : d.setAttribute("disabled", "");
          }
        } catch (t) {
          h.e(t);
        } finally {
          h.f();
        }

        var u,
            f = x(this.fancybox.$container.querySelectorAll("[data-fancybox-index]"));

        try {
          for (f.s(); !(u = f.n()).done;) {
            u.value.innerHTML = e.index + 1;
          }
        } catch (t) {
          f.e(t);
        } finally {
          f.f();
        }

        var v,
            p = x(this.fancybox.$container.querySelectorAll("[data-fancybox-count]"));

        try {
          for (p.s(); !(v = p.n()).done;) {
            v.value.innerHTML = n;
          }
        } catch (t) {
          p.e(t);
        } finally {
          p.f();
        }

        if (!this.fancybox.option("infinite")) {
          var g,
              m = x(this.fancybox.$container.querySelectorAll("[data-fancybox-prev]"));

          try {
            for (m.s(); !(g = m.n()).done;) {
              var y = g.value;
              0 === i ? y.setAttribute("disabled", "") : y.removeAttribute("disabled");
            }
          } catch (t) {
            m.e(t);
          } finally {
            m.f();
          }

          var b,
              w = x(this.fancybox.$container.querySelectorAll("[data-fancybox-next]"));

          try {
            for (w.s(); !(b = w.n()).done;) {
              var k = b.value;
              i === n - 1 ? k.setAttribute("disabled", "") : k.removeAttribute("disabled");
            }
          } catch (t) {
            w.e(t);
          } finally {
            w.f();
          }
        }
      }
    }, {
      key: "cleanup",
      value: function () {
        this.Slideshow && this.Slideshow.isActive() && this.Slideshow.clearTimer(), this.$container && this.$container.remove(), this.$container = null;
      }
    }, {
      key: "attach",
      value: function () {
        this.fancybox.on(this.events);
      }
    }, {
      key: "detach",
      value: function () {
        this.fancybox.off(this.events), this.cleanup();
      }
    }]), t;
  }();

  it.defaults = et;

  var nt = {
    ScrollLock: U,
    Thumbs: Y,
    Html: G,
    Toolbar: it,
    Image: K,
    Hash: J
  },
      ot = {
    startIndex: 0,
    preload: 1,
    infinite: !0,
    showClass: "fancybox-zoomInUp",
    hideClass: "fancybox-fadeOut",
    animated: !0,
    hideScrollbar: !0,
    parentEl: null,
    mainClass: null,
    autoFocus: !0,
    trapFocus: !0,
    placeFocusBack: !0,
    click: "close",
    closeButton: "inside",
    dragToClose: !0,
    keyboard: {
      Escape: "close",
      Delete: "close",
      Backspace: "close",
      PageUp: "next",
      PageDown: "prev",
      ArrowUp: "next",
      ArrowDown: "prev",
      ArrowRight: "next",
      ArrowLeft: "prev"
    },
    template: {
      closeButton: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M20 20L4 4m16 0L4 20"/></svg>',
      spinner: '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="25 25 50 50" tabindex="-1"><circle cx="50" cy="50" r="20"/></svg>',
      main: null
    },
    l10n: {
      CLOSE: "Close",
      NEXT: "Next",
      PREV: "Previous",
      MODAL: "You can close this modal content with the ESC key",
      ERROR: "Something Went Wrong, Please Try Again Later",
      IMAGE_ERROR: "Image Not Found",
      ELEMENT_NOT_FOUND: "HTML Element Not Found",
      AJAX_NOT_FOUND: "Error Loading AJAX : Not Found",
      AJAX_FORBIDDEN: "Error Loading AJAX : Forbidden",
      IFRAME_ERROR: "Error Loading Page",
      TOGGLE_ZOOM: "Toggle zoom level",
      TOGGLE_THUMBS: "Toggle thumbnails",
      TOGGLE_SLIDESHOW: "Toggle slideshow",
      TOGGLE_FULLSCREEN: "Toggle full-screen mode",
      DOWNLOAD: "Download"
    }
  },
      at = new Map(),
      st = 0,
      rt = function (t) {
    l(i, t);
    var e = f(i);

    function i(t) {
      var n,
          a = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
      return o(this, i), t = t.map(function (t) {
        return t.width && (t._width = t.width), t.height && (t._height = t.height), t;
      }), (n = e.call(this, k(!0, {}, ot, a))).bindHandlers(), n.state = "init", n.setItems(t), n.attachPlugins(i.Plugins), n.trigger("init"), !0 === n.option("hideScrollbar") && n.hideScrollbar(), n.initLayout(), n.initCarousel(), n.attachEvents(), at.set(n.id, d(n)), n.trigger("prepare"), n.state = "ready", n.trigger("ready"), n.$container.setAttribute("aria-hidden", "false"), n.option("trapFocus") && n.focus(), n;
    }

    return s(i, [{
      key: "option",
      value: function (t) {
        for (var e, n = this.getSlide(), o = n ? n[t] : void 0, a = arguments.length, s = new Array(a > 1 ? a - 1 : 0), r = 1; r < a; r++) s[r - 1] = arguments[r];

        if (void 0 !== o) {
          var l;
          if ("function" == typeof o) o = (l = o).call.apply(l, [this, this].concat(s));
          return o;
        }

        return (e = p(c(i.prototype), "option", this)).call.apply(e, [this, t].concat(s));
      }
    }, {
      key: "bindHandlers",
      value: function () {
        for (var t = 0, e = ["onMousedown", "onKeydown", "onClick", "onFocus", "onCreateSlide", "onSettle", "onTouchMove", "onTouchEnd", "onTransform"]; t < e.length; t++) {
          var i = e[t];
          this[i] = this[i].bind(this);
        }
      }
    }, {
      key: "attachEvents",
      value: function () {
        document.addEventListener("mousedown", this.onMousedown), document.addEventListener("keydown", this.onKeydown, !0), this.option("trapFocus") && document.addEventListener("focus", this.onFocus, !0), this.$container.addEventListener("click", this.onClick);
      }
    }, {
      key: "detachEvents",
      value: function () {
        document.removeEventListener("mousedown", this.onMousedown), document.removeEventListener("keydown", this.onKeydown, !0), document.removeEventListener("focus", this.onFocus, !0), this.$container.removeEventListener("click", this.onClick);
      }
    }, {
      key: "initLayout",
      value: function () {
        var t = this;
        this.$root = this.option("parentEl") || document.body;
        var e = this.option("template.main");
        e && (this.$root.insertAdjacentHTML("beforeend", this.localize(e)), this.$container = this.$root.querySelector(".fancybox__container")), this.$container || (this.$container = document.createElement("div"), this.$root.appendChild(this.$container)), this.$container.onscroll = function () {
          return t.$container.scrollLeft = 0, !1;
        }, Object.entries({
          class: "fancybox__container",
          role: "dialog",
          tabIndex: "-1",
          "aria-modal": "true",
          "aria-hidden": "true",
          "aria-label": this.localize("{{MODAL}}")
        }).forEach(function (e) {
          var i;
          return (i = t.$container).setAttribute.apply(i, m(e));
        }), this.option("animated") && this.$container.classList.add("is-animated"), this.$backdrop = this.$container.querySelector(".fancybox__backdrop"), this.$backdrop || (this.$backdrop = document.createElement("div"), this.$backdrop.classList.add("fancybox__backdrop"), this.$container.appendChild(this.$backdrop)), this.$carousel = this.$container.querySelector(".fancybox__carousel"), this.$carousel || (this.$carousel = document.createElement("div"), this.$carousel.classList.add("fancybox__carousel"), this.$container.appendChild(this.$carousel)), this.$container.Fancybox = this, this.id = this.$container.getAttribute("id"), this.id || (this.id = this.options.id || ++st, this.$container.setAttribute("id", "fancybox-" + this.id));
        var i,
            n = this.option("mainClass");
        n && (i = this.$container.classList).add.apply(i, m(n.split(" ")));
        return document.documentElement.classList.add("with-fancybox"), this.trigger("initLayout"), this;
      }
    }, {
      key: "setItems",
      value: function (t) {
        var e,
            i = [],
            n = x(t);

        try {
          for (n.s(); !(e = n.n()).done;) {
            var o = e.value,
                a = o.$trigger;

            if (a) {
              var s = a.dataset || {};
              o.src = s.src || a.getAttribute("href") || o.src, o.type = s.type || o.type, !o.src && a instanceof HTMLImageElement && (o.src = a.currentSrc || o.$trigger.src);
            }

            var r = o.$thumb;

            if (!r) {
              var l = o.$trigger && o.$trigger.origTarget;
              l && (r = l instanceof HTMLImageElement ? l : l.querySelector("img:not([aria-hidden])")), !r && o.$trigger && (r = o.$trigger instanceof HTMLImageElement ? o.$trigger : o.$trigger.querySelector("img:not([aria-hidden])"));
            }

            o.$thumb = r || null;
            var c = o.thumb;
            !c && r && !(c = r.currentSrc || r.src) && r.dataset && (c = r.dataset.lazySrc || r.dataset.src), c || "image" !== o.type || (c = o.src), o.thumb = c || null, o.caption = o.caption || "", i.push(o);
          }
        } catch (t) {
          n.e(t);
        } finally {
          n.f();
        }

        this.items = i;
      }
    }, {
      key: "initCarousel",
      value: function () {
        var t = this;
        return this.Carousel = new H(this.$carousel, k(!0, {}, {
          prefix: "",
          classNames: {
            viewport: "fancybox__viewport",
            track: "fancybox__track",
            slide: "fancybox__slide"
          },
          textSelection: !0,
          preload: this.option("preload"),
          friction: 0.88,
          slides: this.items,
          initialPage: this.options.startIndex,
          slidesPerPage: 1,
          infiniteX: this.option("infinite"),
          infiniteY: !0,
          l10n: this.option("l10n"),
          Dots: !1,
          Navigation: {
            classNames: {
              main: "fancybox__nav",
              button: "carousel__button",
              next: "is-next",
              prev: "is-prev"
            }
          },
          Panzoom: {
            textSelection: !0,
            panOnlyZoomed: function () {
              return t.Carousel && t.Carousel.pages && t.Carousel.pages.length < 2 && !t.option("dragToClose");
            },
            lockAxis: function () {
              if (t.Carousel) {
                var e = "x";
                return t.option("dragToClose") && (e += "y"), e;
              }
            }
          },
          on: {
            "*": function (e) {
              for (var i = arguments.length, n = new Array(i > 1 ? i - 1 : 0), o = 1; o < i; o++) n[o - 1] = arguments[o];

              return t.trigger.apply(t, ["Carousel.".concat(e)].concat(n));
            },
            init: function (e) {
              return t.Carousel = e;
            },
            createSlide: this.onCreateSlide,
            settle: this.onSettle
          }
        }, this.option("Carousel"))), this.option("dragToClose") && this.Carousel.Panzoom.on({
          touchMove: this.onTouchMove,
          afterTransform: this.onTransform,
          touchEnd: this.onTouchEnd
        }), this.trigger("initCarousel"), this;
      }
    }, {
      key: "onCreateSlide",
      value: function (t, e) {
        var i = e.caption || "";

        if ("function" == typeof this.options.caption && (i = this.options.caption.call(this, this, this.Carousel, e)), "string" == typeof i && i.length) {
          var n = document.createElement("div"),
              o = "fancybox__caption_".concat(this.id, "_").concat(e.index);
          n.className = "fancybox__caption", n.innerHTML = i, n.setAttribute("id", o), e.$caption = e.$el.appendChild(n), e.$el.classList.add("has-caption"), e.$el.setAttribute("aria-labelledby", o);
        }
      }
    }, {
      key: "onSettle",
      value: function () {
        this.option("autoFocus") && this.focus();
      }
    }, {
      key: "onFocus",
      value: function (t) {
        this.focus(t);
      }
    }, {
      key: "onClick",
      value: function (t) {
        if (!t.defaultPrevented) {
          var e = t.composedPath()[0];
          if (e.matches("[data-fancybox-close]")) return t.preventDefault(), void i.close(!1, t);
          if (e.matches("[data-fancybox-next]")) return t.preventDefault(), void i.next();
          if (e.matches("[data-fancybox-prev]")) return t.preventDefault(), void i.prev();
          if (e.matches(X) || document.activeElement.blur(), !e.closest(".fancybox__content")) if (!getSelection().toString().length) if (!1 !== this.trigger("click", t)) switch (this.option("click")) {
            case "close":
              this.close();
              break;

            case "next":
              this.next();
          }
        }
      }
    }, {
      key: "onTouchMove",
      value: function () {
        var t = this.getSlide().Panzoom;
        return !t || 1 === t.content.scale;
      }
    }, {
      key: "onTouchEnd",
      value: function (t) {
        var e = t.dragOffset.y;
        Math.abs(e) >= 150 || Math.abs(e) >= 35 && t.dragOffset.time < 350 ? (this.option("hideClass") && (this.getSlide().hideClass = "fancybox-throwOut".concat(t.content.y < 0 ? "Up" : "Down")), this.close()) : "y" === t.lockAxis && t.panTo({
          y: 0
        });
      }
    }, {
      key: "onTransform",
      value: function (t) {
        if (this.$backdrop) {
          var e = Math.abs(t.content.y),
              i = e < 1 ? "" : Math.max(0.33, Math.min(1, 1 - e / t.content.fitHeight * 1.5));
          this.$container.style.setProperty("--fancybox-ts", i ? "0s" : ""), this.$container.style.setProperty("--fancybox-opacity", i);
        }
      }
    }, {
      key: "onMousedown",
      value: function () {
        "ready" === this.state && document.body.classList.add("is-using-mouse");
      }
    }, {
      key: "onKeydown",
      value: function (t) {
        if (i.getInstance().id === this.id) {
          document.body.classList.remove("is-using-mouse");
          var e = t.key,
              n = this.option("keyboard");

          if (n && !t.ctrlKey && !t.altKey && !t.shiftKey) {
            var o = t.composedPath()[0],
                a = document.activeElement && document.activeElement.classList,
                s = a && a.contains("carousel__button");
            if ("Escape" !== e && !s) if (t.target.isContentEditable || -1 !== ["BUTTON", "TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].indexOf(o.nodeName)) return;

            if (!1 !== this.trigger("keydown", e, t)) {
              var r = n[e];
              "function" == typeof this[r] && this[r]();
            }
          }
        }
      }
    }, {
      key: "getSlide",
      value: function () {
        var t = this.Carousel;
        if (!t) return null;
        var e = null === t.page ? t.option("initialPage") : t.page,
            i = t.pages || [];
        return i.length && i[e] ? i[e].slides[0] : null;
      }
    }, {
      key: "focus",
      value: function (t) {
        if (!(i.ignoreFocusChange || ["init", "closing", "customClosing", "destroy"].indexOf(this.state) > -1)) {
          var e = this.$container,
              n = this.getSlide(),
              o = "done" === n.state ? n.$el : null;

          if (!o || !o.contains(document.activeElement)) {
            t && t.preventDefault(), i.ignoreFocusChange = !0;

            for (var a, s = [], r = 0, l = Array.from(e.querySelectorAll(X)); r < l.length; r++) {
              var c = l[r],
                  h = c.offsetParent,
                  d = o && o.contains(c),
                  u = !this.Carousel.$viewport.contains(c);
              h && (d || u) ? (s.push(c), void 0 !== c.dataset.origTabindex && (c.tabIndex = c.dataset.origTabindex, c.removeAttribute("data-orig-tabindex")), (c.hasAttribute("autoFocus") || !a && d && !c.classList.contains("carousel__button")) && (a = c)) : (c.dataset.origTabindex = void 0 === c.dataset.origTabindex ? c.getAttribute("tabindex") : c.dataset.origTabindex, c.tabIndex = -1);
            }

            t ? s.indexOf(t.target) > -1 ? this.lastFocus = t.target : this.lastFocus === e ? q(s[s.length - 1]) : q(e) : this.option("autoFocus") && a ? q(a) : s.indexOf(document.activeElement) < 0 && q(e), this.lastFocus = document.activeElement, i.ignoreFocusChange = !1;
          }
        }
      }
    }, {
      key: "hideScrollbar",
      value: function () {
        if (W) {
          var t = window.innerWidth - document.documentElement.getBoundingClientRect().width,
              e = "fancybox-style-noscroll",
              i = document.getElementById(e);
          i || t > 0 && ((i = document.createElement("style")).id = e, i.type = "text/css", i.innerHTML = ".compensate-for-scrollbar {padding-right: ".concat(t, "px;}"), document.getElementsByTagName("head")[0].appendChild(i), document.body.classList.add("compensate-for-scrollbar"));
        }
      }
    }, {
      key: "revealScrollbar",
      value: function () {
        document.body.classList.remove("compensate-for-scrollbar");
        var t = document.getElementById("fancybox-style-noscroll");
        t && t.remove();
      }
    }, {
      key: "clearContent",
      value: function (t) {
        this.Carousel.trigger("removeSlide", t), t.$content && (t.$content.remove(), t.$content = null), t.$closeButton && (t.$closeButton.remove(), t.$closeButton = null), t._className && t.$el.classList.remove(t._className);
      }
    }, {
      key: "setContent",
      value: function (t, e) {
        var i,
            n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {},
            o = t.$el;
        if (e instanceof HTMLElement) ["img", "iframe", "video", "audio"].indexOf(e.nodeName.toLowerCase()) > -1 ? (i = document.createElement("div")).appendChild(e) : i = e;else {
          var a = document.createRange().createContextualFragment(e);
          (i = document.createElement("div")).appendChild(a);
        }
        if (t.filter && !t.error && (i = i.querySelector(t.filter)), i instanceof Element) return t._className = "has-".concat(n.suffix || t.type || "unknown"), o.classList.add(t._className), i.classList.add("fancybox__content"), "none" !== i.style.display && "none" !== getComputedStyle(i).getPropertyValue("display") || (i.style.display = t.display || this.option("defaultDisplay") || "flex"), t.id && i.setAttribute("id", t.id), t.$content = i, o.prepend(i), this.manageCloseButton(t), "loading" !== t.state && this.revealContent(t), i;
        this.setError(t, "{{ELEMENT_NOT_FOUND}}");
      }
    }, {
      key: "manageCloseButton",
      value: function (t) {
        var e = this,
            i = void 0 === t.closeButton ? this.option("closeButton") : t.closeButton;

        if (i && ("top" !== i || !this.$closeButton)) {
          var n = document.createElement("button");
          n.classList.add("carousel__button", "is-close"), n.setAttribute("title", this.options.l10n.CLOSE), n.innerHTML = this.option("template.closeButton"), n.addEventListener("click", function (t) {
            return e.close(t);
          }), "inside" === i ? (t.$closeButton && t.$closeButton.remove(), t.$closeButton = t.$content.appendChild(n)) : this.$closeButton = this.$container.insertBefore(n, this.$container.firstChild);
        }
      }
    }, {
      key: "revealContent",
      value: function (t) {
        var e = this;
        this.trigger("reveal", t), t.$content.style.visibility = "";
        var i = !1;
        t.error || "loading" === t.state || null !== this.Carousel.prevPage || t.index !== this.options.startIndex || (i = void 0 === t.showClass ? this.option("showClass") : t.showClass), i ? (t.state = "animating", this.animateCSS(t.$content, i, function () {
          e.done(t);
        })) : this.done(t);
      }
    }, {
      key: "animateCSS",
      value: function (t, e, i) {
        if (t && t.dispatchEvent(new CustomEvent("animationend", {
          bubbles: !0,
          cancelable: !0
        })), t && e) {
          t.addEventListener("animationend", function n(o) {
            o.currentTarget === this && (t.removeEventListener("animationend", n), i && i(), t.classList.remove(e));
          }), t.classList.add(e);
        } else "function" == typeof i && i();
      }
    }, {
      key: "done",
      value: function (t) {
        t.state = "done", this.trigger("done", t);
        var e = this.getSlide();
        e && t.index === e.index && this.option("autoFocus") && this.focus();
      }
    }, {
      key: "setError",
      value: function (t, e) {
        t.error = e, this.hideLoading(t), this.clearContent(t);
        var i = document.createElement("div");
        i.classList.add("fancybox-error"), i.innerHTML = this.localize(e || "<p>{{ERROR}}</p>"), this.setContent(t, i, {
          suffix: "error"
        });
      }
    }, {
      key: "showLoading",
      value: function (t) {
        var e = this;
        t.state = "loading", t.$el.classList.add("is-loading");
        var i = t.$el.querySelector(".fancybox__spinner");
        i || ((i = document.createElement("div")).classList.add("fancybox__spinner"), i.innerHTML = this.option("template.spinner"), i.addEventListener("click", function () {
          e.Carousel.Panzoom.velocity || e.close();
        }), t.$el.prepend(i));
      }
    }, {
      key: "hideLoading",
      value: function (t) {
        var e = t.$el && t.$el.querySelector(".fancybox__spinner");
        e && (e.remove(), t.$el.classList.remove("is-loading")), "loading" === t.state && (this.trigger("load", t), t.state = "ready");
      }
    }, {
      key: "next",
      value: function () {
        var t = this.Carousel;
        t && t.pages.length > 1 && t.slideNext();
      }
    }, {
      key: "prev",
      value: function () {
        var t = this.Carousel;
        t && t.pages.length > 1 && t.slidePrev();
      }
    }, {
      key: "jumpTo",
      value: function () {
        var t;
        this.Carousel && (t = this.Carousel).slideTo.apply(t, arguments);
      }
    }, {
      key: "close",
      value: function (t) {
        var e = this;

        if (t && t.preventDefault(), !["closing", "customClosing", "destroy"].includes(this.state) && !1 !== this.trigger("shouldClose", t) && (this.state = "closing", this.Carousel.Panzoom.destroy(), this.detachEvents(), this.trigger("closing", t), "destroy" !== this.state)) {
          this.$container.setAttribute("aria-hidden", "true"), this.$container.classList.add("is-closing");
          var i = this.getSlide();

          if (this.Carousel.slides.forEach(function (t) {
            t.$content && t.index !== i.index && e.Carousel.trigger("removeSlide", t);
          }), "closing" === this.state) {
            var n = void 0 === i.hideClass ? this.option("hideClass") : i.hideClass;
            this.animateCSS(i.$content, n, function () {
              e.destroy();
            }, !0);
          }
        }
      }
    }, {
      key: "destroy",
      value: function () {
        if ("destroy" !== this.state) {
          this.state = "destroy", this.trigger("destroy");
          var t = this.option("placeFocusBack") ? this.getSlide().$trigger : null;
          this.Carousel.destroy(), this.detachPlugins(), this.Carousel = null, this.options = {}, this.events = {}, this.$container.remove(), this.$container = this.$backdrop = this.$carousel = null, t && q(t), at.delete(this.id);
          var e = i.getInstance();
          e ? e.focus() : (document.documentElement.classList.remove("with-fancybox"), document.body.classList.remove("is-using-mouse"), this.revealScrollbar());
        }
      }
    }], [{
      key: "show",
      value: function (t) {
        var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
        return new i(t, e);
      }
    }, {
      key: "fromEvent",
      value: function (t) {
        var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};

        if (!t.defaultPrevented && !(t.button && 0 !== t.button || t.ctrlKey || t.metaKey || t.shiftKey)) {
          var n,
              o,
              a,
              s = t.composedPath()[0],
              r = s;

          if ((r.matches("[data-fancybox-trigger]") || (r = r.closest("[data-fancybox-trigger]"))) && (n = r && r.dataset && r.dataset.fancyboxTrigger), n) {
            var l = document.querySelectorAll('[data-fancybox="'.concat(n, '"]')),
                c = parseInt(r.dataset.fancyboxIndex, 10) || 0;
            r = l.length ? l[c] : r;
          }

          r || (r = s), Array.from(i.openers.keys()).reverse().some(function (e) {
            a = r;
            var i = !1;

            try {
              a instanceof Element && ("string" == typeof e || e instanceof String) && (i = a.matches(e) || (a = a.closest(e)));
            } catch (t) {}

            return !!i && (t.preventDefault(), o = e, !0);
          });
          var h = !1;

          if (o) {
            e.event = t, e.target = a, a.origTarget = s, h = i.fromOpener(o, e);
            var d = i.getInstance();
            d && "ready" === d.state && t.detail && document.body.classList.add("is-using-mouse");
          }

          return h;
        }
      }
    }, {
      key: "fromOpener",
      value: function (t) {
        var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {},
            n = function (t) {
          for (var e = ["false", "0", "no", "null", "undefined"], i = ["true", "1", "yes"], n = Object.assign({}, t.dataset), o = {}, a = 0, s = Object.entries(n); a < s.length; a++) {
            var r = g(s[a], 2),
                l = r[0],
                c = r[1];
            if ("fancybox" !== l) if ("width" === l || "height" === l) o["_".concat(l)] = c;else if ("string" == typeof c || c instanceof String) {
              if (e.indexOf(c) > -1) o[l] = !1;else if (i.indexOf(o[l]) > -1) o[l] = !0;else try {
                o[l] = JSON.parse(c);
              } catch (t) {
                o[l] = c;
              }
            } else o[l] = c;
          }

          return t instanceof Element && (o.$trigger = t), o;
        },
            o = [],
            a = e.startIndex || 0,
            s = e.target || null,
            r = void 0 !== (e = k({}, e, i.openers.get(t))).groupAll && e.groupAll,
            l = void 0 === e.groupAttr ? "data-fancybox" : e.groupAttr,
            c = l && s ? s.getAttribute("".concat(l)) : "";

        if (!s || c || r) {
          var h = e.root || (s ? s.getRootNode() : document.body);
          o = [].slice.call(h.querySelectorAll(t));
        }

        if (s && !r && (o = c ? o.filter(function (t) {
          return t.getAttribute("".concat(l)) === c;
        }) : [s]), !o.length) return !1;
        var d = i.getInstance();
        return !(d && o.indexOf(d.options.$trigger) > -1) && (a = s ? o.indexOf(s) : a, new i(o = o.map(n), k({}, e, {
          startIndex: a,
          $trigger: s
        })));
      }
    }, {
      key: "bind",
      value: function (t) {
        var e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};

        function n() {
          document.body.addEventListener("click", i.fromEvent, !1);
        }

        W && (i.openers.size || (/complete|interactive|loaded/.test(document.readyState) ? n() : document.addEventListener("DOMContentLoaded", n)), i.openers.set(t, e));
      }
    }, {
      key: "unbind",
      value: function (t) {
        i.openers.delete(t), i.openers.size || i.destroy();
      }
    }, {
      key: "destroy",
      value: function () {
        for (var t; t = i.getInstance();) t.destroy();

        i.openers = new Map(), document.body.removeEventListener("click", i.fromEvent, !1);
      }
    }, {
      key: "getInstance",
      value: function (t) {
        return t ? at.get(t) : Array.from(at.values()).reverse().find(function (t) {
          return !["closing", "customClosing", "destroy"].includes(t.state) && t;
        }) || null;
      }
    }, {
      key: "close",
      value: function () {
        var t = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0],
            e = arguments.length > 1 ? arguments[1] : void 0;

        if (t) {
          var n,
              o = x(at.values());

          try {
            for (o.s(); !(n = o.n()).done;) {
              var a = n.value;
              a.close(e);
            }
          } catch (t) {
            o.e(t);
          } finally {
            o.f();
          }
        } else {
          var s = i.getInstance();
          s && s.close(e);
        }
      }
    }, {
      key: "next",
      value: function () {
        var t = i.getInstance();
        t && t.next();
      }
    }, {
      key: "prev",
      value: function () {
        var t = i.getInstance();
        t && t.prev();
      }
    }]), i;
  }(O);

  rt.version = "4.0.27", rt.defaults = ot, rt.openers = new Map(), rt.Plugins = nt, rt.bind("[data-fancybox]");

  for (var lt = 0, ct = Object.entries(rt.Plugins || {}); lt < ct.length; lt++) {
    var ht = g(ct[lt], 2);
    ht[0];
    var dt = ht[1];
    "function" == typeof dt.create && dt.create(rt);
  }

  t.Carousel = H, t.Fancybox = rt, t.Panzoom = M;
});

/***/ }),

/***/ "./src/main/functions.js":
/*!*******************************!*\
  !*** ./src/main/functions.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "emailIsValid": () => (/* binding */ emailIsValid),
/* harmony export */   "hideModal": () => (/* binding */ hideModal),
/* harmony export */   "loadModalContent": () => (/* binding */ loadModalContent),
/* harmony export */   "showModal": () => (/* binding */ showModal),
/* harmony export */   "showModalForm": () => (/* binding */ showModalForm)
/* harmony export */ });
/**
 * Shows modal form
 */
const showModalForm = (title, formtype, metadata, callback) => {
  showModal(title);
  let data = {
    action: "get_form_modal_input",
    post_id: gb.postId,
    formtype: formtype,
    metadata: metadata
  };
  jQuery.get(gb.ajaxUrl, data, function (html) {
    loadModalContent(html, false, function (modalElement) {
      if (callback) callback(modalElement);
    });
  });
};
/**
 * Shows modal
 */

const showModal = function (title) {
  let size = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "small";
  jQuery(".js-modal-title").html(title); // Remove modal size classes

  jQuery(".js-modal").removeClass(function (index, className) {
    return (className.match(/(^|\s)modal-\S+/g) || []).join(" ");
  });
  jQuery(".js-modal-loader").show();
  jQuery(".js-modal-inner").hide();
  jQuery(".js-modal").addClass("show modal-" + size);
};
/**
 * Hides modal
 */

const hideModal = () => {
  const modal = jQuery(".js-modal");

  if (modal !== null) {
    modal.removeClass("show");
    jQuery(".js-modal-body").html("");
  }
};
/**
 * Loads modal content
 */

const loadModalContent = function (html) {
  let title = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "";
  let callback = arguments.length > 2 ? arguments[2] : undefined;
  jQuery(".js-modal-body").html(html);

  if (title) {
    jQuery(".js-modal-title").html(title);
  }

  jQuery(".js-modal-loader").hide();
  jQuery(".js-modal-inner").fadeIn(300);
  if (callback) callback(jQuery(".js-modal"));
};
/**
 * Checks whether an email is valid
 */

const emailIsValid = email => {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
};

/***/ }),

/***/ "./src/main/index.js":
/*!***************************!*\
  !*** ./src/main/index.js ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _functions__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./functions */ "./src/main/functions.js");
/* harmony import */ var _components_LeadForm__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/LeadForm */ "./src/main/components/LeadForm.js");


const {
  render
} = wp.element;


if (document.getElementById("react_lead_form")) {
  render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_LeadForm__WEBPACK_IMPORTED_MODULE_2__["default"], null), document.getElementById("react_lead_form"));
}
/**
 * jQuery plugin: Checks whether element in viewport
 */


jQuery.fn.isInViewport = function () {
  var elementTop = jQuery(this).offset().top;
  var elementBottom = elementTop + jQuery(this).outerHeight();
  var viewportTop = jQuery(window).scrollTop();
  var viewportBottom = viewportTop + jQuery(window).height();
  return elementBottom > viewportTop && elementTop < viewportBottom;
};
/**
 * jQuery plugin: Scrolls to given element
 */


jQuery.fn.scrollTo = function (offset) {
  offset = typeof offset !== "undefined" ? offset : -30;
  jQuery("html, body").animate({
    scrollTop: jQuery(this).offset().top + offset
  }, 500);
};

(function ($) {
  /**
   * Closest polyfil
   */
  if (!Element.prototype.matches) {
    Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
  }

  if (!Element.prototype.closest) {
    Element.prototype.closest = function (s) {
      var el = this;

      do {
        if (el.matches(s)) return el;
        el = el.parentElement || el.parentNode;
      } while (el !== null && el.nodeType === 1);

      return null;
    };
  }
  /**
   * Foreach polyfil
   */


  if (!Array.prototype.forEach) {
    Array.prototype.forEach = function (fn, scope) {
      for (var i = 0, len = this.length; i < len; ++i) {
        fn.call(scope, this[i], i, this);
      }
    };
  }
  /**
   * Toggle side nav
   */


  $(".js-side-nav-list-toggler").on("click", function () {
    let targetElement = $(this).parent().find(".js-side-nav-list");
    targetElement.toggleClass("d-none");
  });
  /**
   * Masonry
   */

  $(".js-bricks").each(function () {
    const $bricks = $(this);

    const update = function () {
      $bricks.masonry({
        itemSelector: ".js-brick"
      });
    };

    $bricks.masonry({
      itemSelector: ".js-brick"
    });
    this.addEventListener("load", update, true);
  }); // Hide element when in viewport on scroll

  $(window).on("scroll", function () {
    $(".js-hide-when").each(function (index, element) {
      const target = $(element).data("hide-when");

      if ($(target).isInViewport()) {
        $(element).hide();
      } else {
        $(element).show();
      }
    });
  }); // Scroll to specific element

  $(".js-scroll-to").click(function () {
    const target = $(this).data("scroll-to");
    $(target).scrollTo(-10);
  }); // Cart edit item

  $(".js-cart-item-edit").on("click", function (e) {
    e.preventDefault();
    let itemKey = $(this).data("cart-item-key");
    $.post(gb.ajaxUrl, {
      action: "edit_cart_item",
      cart_item_key: itemKey
    }, function (response) {
      if (response.redirect_url) window.location.href = response.redirect_url;
    }, "json");
  });
  /**
   * Rotator
   */

  (function () {
    const rotators = document.querySelectorAll(".js-rotator");

    if (rotators !== null) {
      rotators.forEach(rotator => {
        let items = rotator.querySelectorAll(".js-rotator-item");
        let isPaused = false;
        let index = 0;
        rotate();
        setInterval(rotate, 4000);
        rotator.addEventListener("mouseenter", () => {
          isPaused = true;
        });
        rotator.addEventListener("mouseleave", () => {
          isPaused = false;
        });

        function rotate() {
          if (!isPaused) {
            items[index].classList.add("visible");
            items.forEach(item => {
              if (item !== items[index]) {
                item.classList.remove("visible");
              }
            });
            index++;
            if (index == items.length) index = 0;
          }
        }
      });
    }
  })();
  /**
   * Main navigation
   */


  (function () {
    const parentSelector = ".js-nav-item-parent";

    function showSublevel(element) {
      $(element).addClass("open");
    }

    function hideSublevel(element) {
      $(element).removeClass("open");
    }

    function toggleSublevel(element) {
      $(element).toggleClass("open");
      $(parentSelector).not(element).removeClass("open");
    } // Stops bubbling up in the DOM by click a menu subitem link


    $(document).on("click", parentSelector + ", .js-nav-subitem-link", function (e) {
      e.stopPropagation();
    }) // Closes sublevels by click outside
    .on("click", "body", function () {
      $(parentSelector).removeClass("open");
    }) // Opens sublevel and closes siblings
    .on("mouseenter", parentSelector, function (e) {
      if ($(window).width() > 768) {
        e.preventDefault();
        showSublevel(this);
      }
    }).on("mouseleave", parentSelector, function (e) {
      if ($(window).width() > 768) {
        e.preventDefault();
        hideSublevel(this);
      }
    }).on("click", parentSelector, function (e) {
      if ($(window).width() <= 768) {
        e.preventDefault();
        toggleSublevel(this);
      }
    }) // Toggles nav menu on mobile menu
    .on("click", ".js-nav-toggler", function () {
      $(this).toggleClass("open");
      $(".js-nav-items").toggleClass("open");
    });
  })();
  /**
   * Image slider
   */


  (function () {
    const container = $(".js-image-slider");
    const main = $(".js-main", container);
    const totalSlides = $(".js-thumb img", container).length;
    let currentIndex = 1;
    container.on("click", ".js-thumb img", function () {
      const index = $(this).data("index");
      change(index);
    }).on("click", ".js-next", next).on("click", ".js-prev", previous);

    function change(index) {
      // Change current index
      if (index > totalSlides) {
        currentIndex = 1;
      } else if (index < 1) {
        currentIndex = totalSlides;
      } else {
        currentIndex = index;
      } // Get current element


      const current = $('[data-index="' + currentIndex + '"]', container);
      const url = current.data("image");
      const title = current.attr("title"); // Change main image url

      if (main.is("picture")) {
        main.find("source").attr("srcset", url);
        main.find("img").attr("src", url);
        main.parent("a").attr("href", url);
      } else {
        main.attr("src", url).parent("a").attr("href", url);
      } // Change main image title


      main.parent("a").attr("title", title);
      main.parent("a").attr("data-caption", title); // Change current index class

      const currentClass = "current";
      current.parent().addClass(currentClass).siblings().removeClass(currentClass);
    }

    function next() {
      change(currentIndex + 1);
    }

    function previous() {
      change(currentIndex - 1);
    }
  })();
  /**
   * Delegate click events
   */


  document.addEventListener("click", e => {
    if (e.target) {
      /**
       * Collapse box
       */
      if (e.target.closest(".js-collapse-box")) {
        e.target.closest(".js-collapse-box").classList.toggle("open");
        return;
      }
      /**
       * Close modal by css class handlers
       */


      if (e.target.closest(".js-close-modal") || e.target.matches(".js-modal")) {
        (0,_functions__WEBPACK_IMPORTED_MODULE_1__.hideModal)();
        return;
      }
      /**
       * Hide target
       */


      if (e.target.closest(".js-hide-target-trigger")) {
        let target = e.target.dataset.hideTarget;
        let element = document.querySelector(target);
        element.classList.add("d-none");
        element.classList.remove("d-block");
        return;
      }
      /**
       * Show target
       */


      if (e.target.closest(".js-show-target-trigger")) {
        let hideAfter = e.target.dataset.hideAfter || false;
        let target = e.target.dataset.showTarget;
        let element = document.querySelector(target);
        element.classList.add("d-block");
        element.classList.remove("d-none");
        if (hideAfter) $(e.target).hide();
        return;
      }
      /**
       * Toggle target
       */


      if (e.target.closest(".js-toggle-target-trigger")) {
        let target = e.target.dataset.toggleTarget;
        let element = document.querySelector(target);
        element.classList.toggle("d-block");
        element.classList.toggle("d-none");
        return;
      }
    }
  });
  /**
   * Empty dropdown and submit form
   */

  $(".js-empty-dropdown").click(function () {
    let dropdownGroup = $(this).parents(".js-dropdown-group");
    let dropdown = dropdownGroup.find(".js-dropdown");
    dropdown.val("");
    let submitAfter = $(this).data("submit");
    if (submitAfter) dropdown.parents("form").submit();
  });
  /**
   * Sticky bar
   */

  $(document).on("scroll", function () {
    let $stickyBar = $(".js-sticky-bar");
    let triggerData = $stickyBar.data("trigger");
    let viewportTop = $(window).scrollTop();
    let viewPortWidth = $(window).width();
    let show = false;
    if (!triggerData) return;
    triggerData.forEach(function (data) {
      if (!data.screen || !data.element) return;
      let elementTop = $(data.element).offset().top;

      if (viewportTop > elementTop) {
        if (data.screen == "mobile" && viewPortWidth < 768) {
          show = true;
        } else if (data.screen == "desktop" && viewPortWidth >= 768) {
          show = true;
        }
      }
    });
    if (show) $stickyBar.fadeIn(100);else $stickyBar.fadeOut(100);
  });
  /**
   * Delegate change events
   */

  document.addEventListener("change", e => {
    if (e.target) {
      /**
       * Dropdown that loads url on change
       */
      if (e.target.matches(".js-url-dropdown")) {
        const selectedIndex = e.target.selectedIndex;
        const url = e.target.options[selectedIndex].value;

        if (url) {
          window.location = url;
        }

        return;
      }
      /**
       * On change file input field
       *
       * Changes text to show how many files are selected
       */


      if (e.target.closest(".js-file-input-field")) {
        const filesCount = e.target.files.length;
        e.target.parentNode.querySelector(".js-file-input-trigger-text").innerHTML = filesCount + " " + gb.msg.filesSelected;
        return;
      }
    }
  });
  /**
   * Full form validation on submit
   */

  $(document).on("submit", ".js-form-validation", function (e) {
    e.preventDefault();
    const form = this;
    validateForm(form, function (form) {
      //Create formdata object
      const formData = new FormData(form);
      const action = form.querySelector(".js-form-action").value;
      const submitButton = jQuery('button[type="submit"]', form);
      const submitButtonText = submitButton.text();

      if (action !== undefined) {
        // Append action, nonce and request uri
        formData.append("action", action);
        formData.append("nonce", gb.ajaxNonce);
        formData.append("request_uri", gb.requestURI); // Handle files

        let fileField = form.querySelector(".js-file-input-field");

        if (fileField !== null) {
          let files = fileField.files;

          if (files.length > 0) {
            let combinedFilesize = 0;

            for (let i = 0; i < files.length; i++) {
              let file = files[i];
              combinedFilesize += file.size;
              formData.append("attachment[]", file);
            } // Check combined file size does not exceed max file size


            const maxCombinedFileSize = 8000000;

            if (combinedFilesize > maxCombinedFileSize) {
              showErrorAlert(gb.msg.fileUploadLimit.replace("{0}", maxCombinedFileSize / 1000000), form);
              return;
            }
          }
        }

        $.ajax({
          url: gb.ajaxUrl,
          data: formData,
          method: "POST",
          processData: false,
          contentType: false,
          beforeSend: function () {
            // Disable submit button
            submitButton.attr("disabled", true).text(gb.msg.pleaseWait);
          },
          success: function (response) {
            if (response) {
              submitButton.attr("disabled", false).text(gb.msg.sent);
              let parsed = JSON.parse(response);

              if (parsed.error) {
                showErrorAlert(parsed.error, form);
              } else {
                hideErrorAlert(form);

                if (parsed.redirect) {
                  window.location.href = parsed.redirect;
                }
              }
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
          }
        });
      }
    });
  });
  /**
   * Form validation per input on blur
   */

  $(document).on("blur", ".js-form-validation .js-form-validate", function () {
    validateInput(this);
  });
  /**
   * Popup form
   */

  $(document).on("click", ".js-popup-form", function () {
    let title = $(this).data("popup-title");
    let formtype = $(this).data("formtype");
    let metadata = $(this).data("meta");

    if (formtype === "lead") {
      title = "Contactformulier";
      (0,_functions__WEBPACK_IMPORTED_MODULE_1__.showModal)(title);
      (0,_functions__WEBPACK_IMPORTED_MODULE_1__.loadModalContent)();
      render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_LeadForm__WEBPACK_IMPORTED_MODULE_2__["default"], null), document.getElementById("modal_body"));
    } else {
      (0,_functions__WEBPACK_IMPORTED_MODULE_1__.showModalForm)(title, formtype, metadata); // Later convert to full react approach
    }
  });
  /**
   * Popup pin
   */

  $(document).on("click", ".js-popup-pin", function () {
    (0,_functions__WEBPACK_IMPORTED_MODULE_1__.showModal)(gb.msg.inspiration, "large");
    let data = {
      action: "get_single_popup_html",
      post_id: $(this).data("pin-id")
    };
    $.get(gb.ajaxUrl, data, function (html) {
      (0,_functions__WEBPACK_IMPORTED_MODULE_1__.loadModalContent)(html);
    });
  });
  /**
   * Popup explanation
   */

  $(document).on("click", ".js-popup-explanation", function () {
    (0,_functions__WEBPACK_IMPORTED_MODULE_1__.showModal)("", "medium");
    let data = {
      action: "get_explanation_content",
      post_id: $(this).data("explanation-id")
    };
    $.get(gb.ajaxUrl, data, function (response) {
      (0,_functions__WEBPACK_IMPORTED_MODULE_1__.loadModalContent)(response.html, response.title);
    });
  });
})(jQuery);
/**
 * Validates a form
 */


function validateForm(form, callback) {
  let valid = true;
  let invalidInputs = [];
  const formElements = form.querySelectorAll(".js-form-validate");

  if (formElements !== null) {
    formElements.forEach(element => {
      if (!validateInput(element)) {
        valid = false;
        invalidInputs.push(element);
      }
    });
  }

  if (valid) {
    callback(form);
  } else {
    // Scroll to first invalid field
    const firstInput = jQuery(invalidInputs[0]);
    if (!firstInput.isInViewport()) firstInput.scrollTo(-50);
  }
}
/**
 * Validates a form input
 */


function validateInput(element) {
  clearValidate(element);
  let valid = true;
  let showFeedback = true;
  let type = element.type;
  let value = element.value;
  let req = element.dataset.required;
  let msg = gb.msg.enterField;

  if (!value) {
    if (req !== undefined) {
      valid = false;
    } else {
      showFeedback = false;
    }
  } else {
    if (type == "email") {
      if (!(0,_functions__WEBPACK_IMPORTED_MODULE_1__.emailIsValid)(value)) {
        valid = false;
        msg = gb.msg.enterValidEmail;
      }
    }
  }

  if (showFeedback) {
    if (valid) {
      isValid(element);
    } else {
      isInvalid(element, msg);
    }
  }

  return valid;
}
/**
 * Clears form input styles and invalid feedback
 */


function clearValidate(element) {
  const parent = jQuery(element).parents(".js-form-group");
  const feedback = parent.find(".js-invalid-feedback");
  jQuery(element).removeClass("valid invalid");
  feedback.text("");
}
/**
 * Adds valid input styles and removes invalid feedback
 */


function isValid(element) {
  const parent = jQuery(element).parents(".js-form-group");
  const feedback = parent.find(".js-invalid-feedback");
  jQuery(element).removeClass("invalid");
  jQuery(element).addClass("valid");
  feedback.hide().text("");
}
/**
 * Adds invalid input styles and shows invalid feedback
 */


function isInvalid(element, msg) {
  const parent = jQuery(element).parents(".js-form-group");
  const feedback = parent.find(".js-invalid-feedback");
  jQuery(element).removeClass("valid");
  jQuery(element).addClass("invalid");
  feedback.show().text(msg);
}
/**
 * Shows error alert
 */


function showErrorAlert(error, parent) {
  let alert = document.querySelector(".js-error-alert");

  if (parent) {
    alert = parent.querySelector(".js-error-alert");
  }

  if (alert !== null) {
    alert.innerHTML = error;
    alert.style.display = "block";
  }
}
/**
 * Hides error alert
 */


function hideErrorAlert(parent) {
  let alert = document.querySelector(".js-error-alert");

  if (parent) {
    alert = parent.querySelector(".js-error-alert");
  }

  if (alert !== null) {
    alert.innerHTML = "";
    alert.style.display = "none";
  }
}

/***/ }),

/***/ "./src/main/matchHeight.js":
/*!*********************************!*\
  !*** ./src/main/matchHeight.js ***!
  \*********************************/
/***/ ((module, exports, __webpack_require__) => {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;!function (t) {
  "use strict";

   true ? !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(/*! jquery */ "jquery")], __WEBPACK_AMD_DEFINE_FACTORY__ = (t),
		__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
		(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : 0;
}(function (t) {
  var e = -1,
      o = -1,
      n = function (t) {
    return parseFloat(t) || 0;
  },
      a = function (e) {
    var o = 1,
        a = t(e),
        i = null,
        r = [];
    return a.each(function () {
      var e = t(this),
          a = e.offset().top - n(e.css("margin-top")),
          s = r.length > 0 ? r[r.length - 1] : null;
      null === s ? r.push(e) : Math.floor(Math.abs(i - a)) <= o ? r[r.length - 1] = s.add(e) : r.push(e), i = a;
    }), r;
  },
      i = function (e) {
    var o = {
      byRow: !0,
      property: "height",
      target: null,
      remove: !1
    };
    return "object" == typeof e ? t.extend(o, e) : ("boolean" == typeof e ? o.byRow = e : "remove" === e && (o.remove = !0), o);
  },
      r = t.fn.matchHeight = function (e) {
    var o = i(e);

    if (o.remove) {
      var n = this;
      return this.css(o.property, ""), t.each(r._groups, function (t, e) {
        e.elements = e.elements.not(n);
      }), this;
    }

    return this.length <= 1 && !o.target ? this : (r._groups.push({
      elements: this,
      options: o
    }), r._apply(this, o), this);
  };

  r.version = "0.7.2", r._groups = [], r._throttle = 80, r._maintainScroll = !1, r._beforeUpdate = null, r._afterUpdate = null, r._rows = a, r._parse = n, r._parseOptions = i, r._apply = function (e, o) {
    var s = i(o),
        h = t(e),
        l = [h],
        c = t(window).scrollTop(),
        p = t("html").outerHeight(!0),
        u = h.parents().filter(":hidden");
    return u.each(function () {
      var e = t(this);
      e.data("style-cache", e.attr("style"));
    }), u.css("display", "block"), s.byRow && !s.target && (h.each(function () {
      var e = t(this),
          o = e.css("display");
      "inline-block" !== o && "flex" !== o && "inline-flex" !== o && (o = "block"), e.data("style-cache", e.attr("style")), e.css({
        display: o,
        "padding-top": "0",
        "padding-bottom": "0",
        "margin-top": "0",
        "margin-bottom": "0",
        "border-top-width": "0",
        "border-bottom-width": "0",
        height: "100px",
        overflow: "hidden"
      });
    }), l = a(h), h.each(function () {
      var e = t(this);
      e.attr("style", e.data("style-cache") || "");
    })), t.each(l, function (e, o) {
      var a = t(o),
          i = 0;
      if (s.target) i = s.target.outerHeight(!1);else {
        if (s.byRow && a.length <= 1) return void a.css(s.property, "");
        a.each(function () {
          var e = t(this),
              o = e.attr("style"),
              n = e.css("display");
          "inline-block" !== n && "flex" !== n && "inline-flex" !== n && (n = "block");
          var a = {
            display: n
          };
          a[s.property] = "", e.css(a), e.outerHeight(!1) > i && (i = e.outerHeight(!1)), o ? e.attr("style", o) : e.css("display", "");
        });
      }
      a.each(function () {
        var e = t(this),
            o = 0;
        s.target && e.is(s.target) || ("border-box" !== e.css("box-sizing") && (o += n(e.css("border-top-width")) + n(e.css("border-bottom-width")), o += n(e.css("padding-top")) + n(e.css("padding-bottom"))), e.css(s.property, i - o + "px"));
      });
    }), u.each(function () {
      var e = t(this);
      e.attr("style", e.data("style-cache") || null);
    }), r._maintainScroll && t(window).scrollTop(c / p * t("html").outerHeight(!0)), this;
  }, r._applyDataApi = function () {
    var e = {};
    t("[data-match-height], [data-mh]").each(function () {
      var o = t(this),
          n = o.attr("data-mh") || o.attr("data-match-height");
      n in e ? e[n] = e[n].add(o) : e[n] = o;
    }), t.each(e, function () {
      this.matchHeight(!0);
    });
  };

  var s = function (e) {
    r._beforeUpdate && r._beforeUpdate(e, r._groups), t.each(r._groups, function () {
      r._apply(this.elements, this.options);
    }), r._afterUpdate && r._afterUpdate(e, r._groups);
  };

  r._update = function (n, a) {
    if (a && "resize" === a.type) {
      var i = t(window).width();
      if (i === e) return;
      e = i;
    }

    n ? o === -1 && (o = setTimeout(function () {
      s(a), o = -1;
    }, r._throttle)) : s(a);
  }, t(r._applyDataApi);
  var h = t.fn.on ? "on" : "bind";
  t(window)[h]("load", function (t) {
    r._update(!1, t);
  }), t(window)[h]("resize orientationchange", function (t) {
    r._update(!0, t);
  });
});

/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

"use strict";
module.exports = window["jQuery"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

"use strict";
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
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
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
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	__webpack_require__("./src/main/index.js");
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	__webpack_require__("./src/main/fancybox.js");
/******/ 	var __webpack_exports__ = __webpack_require__("./src/main/matchHeight.js");
/******/ 	
/******/ })()
;
//# sourceMappingURL=main.js.map