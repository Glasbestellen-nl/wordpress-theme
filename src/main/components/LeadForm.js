const { useReducer, useState } = wp.element;
import axios from "axios";
import { emailIsValid } from "../functions";
import FileUploader from "./FileUploader";

const initialState = {
  errors: {},
  valid: {},
  fields: {
    content: "",
    name: "",
    email: "",
    residence: "",
    phone: "",
  },
  files: [],
  submitting: false,
};

const reducer = (state, action) => {
  const { type, payload } = action;
  switch (type) {
    case "set_submitting":
      return { ...state, submitting: payload.submitting };
    case "add_files":
      return { ...state, files: [...state.files, ...payload.files] };
    case "remove_file":
      return {
        ...state,
        files: state.files.filter((file, i) => i !== payload.index),
      };
    case "set_field":
      console.log(type, payload);
      return {
        ...state,
        fields: { ...state.fields, [payload.name]: payload.value },
      };
    case "set_field_error":
      return {
        ...state,
        errors: { ...state.errors, [payload.name]: payload.message },
        valid: { ...state.valid, [payload.name]: false },
      };
    case "set_field_valid":
      return {
        ...state,
        valid: { ...state.valid, [payload.name]: true },
        errors: { ...state.errors, [payload.name]: false },
      };
    default:
      return state;
  }
};

const LeadForm = () => {
  const [state, dispatch] = useReducer(reducer, initialState);

  const addFilesHandler = (files) => {
    dispatch({ type: "add_files", payload: { files } });
  };

  const removeFileHandler = (index) => {
    dispatch({ type: "remove_file", payload: { index } });
  };

  const handleChange = (e) => {
    const name = e.target.name;
    const value = e.target.value;
    dispatch({ type: "set_field", payload: { name, value } });
    validate(name, value);
  };

  const validate = (name, value) => {
    let valid = true;
    let errorMessage = "";

    switch (name) {
      case "email":
        if (value.length === 0 || !emailIsValid(value)) {
          valid = false;
          errorMessage = gb.msg.enterValidEmail;
        }
        break;
      case "phone":
        valid = true;
        break;
      case "gclid":
        valid = true;
        break;
      default:
        if (value.length === 0) {
          valid = false;
          errorMessage = gb.msg.enterField;
        }
    }
    if (valid && value.length > 0) {
      dispatch({ type: "set_field_valid", payload: { name } });
    } else {
      dispatch({
        type: "set_field_error",
        payload: { name, message: errorMessage },
      });
    }
    return valid;
  };

  const handleSubmitButtonClick = async (e) => {
    try {
      e.preventDefault();
      let valid = true;
      const fieldNames = Object.keys(state.fields);
      fieldNames.forEach((name) => {
        const value = state.fields[name];
        if (!validate(name, value)) {
          valid = false;
        }
      });
      if (valid) {
        dispatch({ type: "set_submitting", payload: { submitting: true } });
        const formData = new FormData();
        formData.append("action", "handle_lead_form_submit");
        formData.append("nonce", gb.ajaxNonce);
        formData.append("request_uri", gb.requestURI);

        // Append fields
        Object.keys(state.fields).forEach((name) => {
          formData.append(`lead[${name}]`, state.fields[name]);
        });

        // Append files
        if (state.files.length > 0) {
          state.files.forEach((file) => formData.append("attachment[]", file));
        }

        // Append Google Analytics client id
        const gclientId =
          (window.dataLayer &&
            window.dataLayer.find((obj) => obj.clientId)?.clientId) ||
          null;
        if (gclientId) formData.append("client[gclid]", gclientId);

        // Append Google Adwords click id
        console.log(window.dataLayer);
        const gclid =
          (window.dataLayer &&
            window.dataLayer.find((obj) => obj.gclid)?.gclid) ||
          null;
        console.log(gclid);
        if (gclid) formData.append("client[ads_gclid]", gclid);

        const response = await axios.post(gb.ajaxUrl, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        if (response.data && !response.data.error && response.data.redirect) {
          window.location.href = response.data.redirect;
        } else {
          dispatch({ type: "set_submitting", payload: { submitting: false } });
        }
      }
    } catch (err) {
      dispatch({ type: "set_submitting", payload: { submitting: false } });
    }
  };

  const getFieldClassName = (name) => {
    const classNames = [];
    if (state.errors[name]) {
      classNames.push("invalid");
    } else if (state.valid[name]) {
      classNames.push("valid");
    }
    return classNames.join(" ");
  };

  return (
    <form className="p-6 md:p-8">
      <div>
        <div className="mb-4">
          <label className="form-label">
            Beschrijf uw wensen en uw situatie <span className="req">*</span>
          </label>
          <textarea
            name="content"
            className={`form-control ${getFieldClassName("content")}`}
            rows="6"
            placeholder="Beschrijf uw wensen en uw situatie"
            onChange={handleChange}
            value={state.fields.content}
          ></textarea>
          {state.errors.content && (
            <div className="invalid-feedback">{state.errors.content}</div>
          )}
        </div>
        <div className="mb-4 grid md:grid-cols-2 gap-5">
          <div className="">
            <label className="form-label">
              Naam: <span className="req">*</span>
            </label>
            <input
              name="name"
              type="text"
              className={`form-control ${getFieldClassName("name")}`}
              placeholder="Naam"
              onChange={handleChange}
              value={state.fields.name}
            />
            {state.errors.name && (
              <div className="invalid-feedback">{state.errors.name}</div>
            )}
          </div>

          <div className="">
            <label className="form-label">
              E-mail: <span className="req">*</span>
            </label>
            <input
              name="email"
              type="email"
              className={`form-control ${getFieldClassName("email")}`}
              placeholder="E-mail"
              onChange={handleChange}
              value={state.fields.email}
            />
            {state.errors.email && (
              <div className="invalid-feedback">{state.errors.email}</div>
            )}
          </div>

          <div className="">
            <label className="form-label">
              Woonplaats: <span className="req">*</span>
            </label>
            <input
              name="residence"
              type="text"
              className={`form-control ${getFieldClassName("residence")}`}
              placeholder="Woonplaats"
              onChange={handleChange}
              value={state.fields.residence}
            />
            {state.errors.place && (
              <div className="invalid-feedback">{state.errors.residence}</div>
            )}
          </div>

          <div className="">
            <label className="form-label">Telefoonnummer:</label>
            <input
              name="phone"
              type="phone"
              className={`form-control ${getFieldClassName("phone")}`}
              placeholder="Telefoonnummer"
              onChange={handleChange}
              value={state.phone}
            />
          </div>
        </div>

        <div className="mb-6">
          <label className="form-label">
            Voeg foto's of tekeningen toe ter verduidelijking.
          </label>
          <FileUploader
            files={state.files}
            addFilesHandler={addFilesHandler}
            removeFileHandler={removeFileHandler}
          />
        </div>

        <div className="flex justify-end">
          <button
            className="btn btn--primary btn--next w-full block md:inline md:w-auto"
            type="submit"
            onClick={handleSubmitButtonClick}
            disabled={state.submitting}
          >
            {state.submitting ? "Aan het versturen..." : "Verstuur"}
          </button>
        </div>
      </div>
    </form>
  );
};

export default LeadForm;
