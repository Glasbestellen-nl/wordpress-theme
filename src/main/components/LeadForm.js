const { useState, useEffect } = wp.element;
import FileUploader from "./FileUploader";

const LeadForm = () => {
  const [errors, setErrors] = useState([]);
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    place: "",
    phone: "",
    files: [],
  });
  const { files } = formData;

  const addFilesHandler = (files) => {
    setFormData((prevData) => {
      return { ...prevData, files: [...prevData.files, ...files] };
    });
  };

  const removeFileHandler = (index) => {
    setFormData((prevData) => {
      return { ...prevData, files: files.filter((file, i) => i !== index) };
    });
  };

  return (
    <form className="p-6 md:p-8">
      {errors && errors.length > 0 && (
        <p className="js-error-alert alert alert--danger"></p>
      )}
      <div>
        <div className="mb-4">
          <label className="form-label">
            Beschrijf uw wensen en uw situatie <span className="req">*</span>
          </label>
          <textarea
            className="form-control"
            rows="6"
            placeholder="Beschrijf uw wensen en uw situatie"
          ></textarea>
        </div>
        <div className="mb-4 grid md:grid-cols-2 gap-5">
          <div className="">
            <label className="form-label">
              Naam: <span className="req">*</span>
            </label>
            <input type="text" className="form-control" placeholder="Naam" />
            <div className="invalid-feedback js-invalid-feedback"></div>
          </div>

          <div className="">
            <label className="form-label">
              E-mail: <span className="req">*</span>
            </label>
            <input type="email" className="form-control" placeholder="E-mail" />
            <div className="invalid-feedback js-invalid-feedback"></div>
          </div>

          <div className="">
            <label className="form-label">
              Woonplaats: <span className="req">*</span>
            </label>
            <input
              type="text"
              className="form-control"
              placeholder="Woonplaats"
            />
            <div className="invalid-feedback js-invalid-feedback"></div>
          </div>

          <div className="">
            <label className="form-label">Telefoonnummer:</label>
            <input
              type="phone"
              className="form-control"
              placeholder="Telefoonnummer"
            />
          </div>
        </div>

        <div className="mb-6">
          <label className="form-label">Voeg foto's of tekeningen toe.</label>
          <FileUploader
            files={files}
            addFilesHandler={addFilesHandler}
            removeFileHandler={removeFileHandler}
          />
        </div>

        <div className="flex justify-end">
          <button
            className="btn btn--primary btn--next w-full block md:inline md:w-auto"
            type="submit"
          >
            Verstuur
          </button>
        </div>
      </div>
    </form>
  );
};

export default LeadForm;
