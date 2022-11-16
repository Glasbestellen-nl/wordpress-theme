const { useRef, useState } = wp.element;

const FileUploader = ({ files, addFilesHandler, removeFileHandler }) => {
  const fileFieldRef = useRef();
  const [error, setError] = useState(false);

  const headClassNames = [
    "p-2 flex border border-gray-300 bg-[#fcfcfc] rounded-tl rounded-tr",
  ];
  if (files.length === 0) {
    headClassNames.push("rounded-bl rounded-br");
  }

  const handleSelectButtonClick = (e) => {
    e.preventDefault();
    fileFieldRef.current.click();
  };

  const handleChange = (e) => {
    setError(false);
    const newFiles = e.target.files;
    if (!newFiles) return;

    const maxCombinedFileSize = 8000000;
    const allowedFileTypes = window.gb.allowedFileTypes;
    let combinedFileSize = 0;
    let notAllowedFileType = false;

    // File size and type check
    [...files, ...newFiles].forEach((file) => {
      if (!Object.values(allowedFileTypes).includes(file.type))
        notAllowedFileType = file.type;
      combinedFileSize += file.size;
    });

    if (combinedFileSize > maxCombinedFileSize) {
      setError(
        gb.msg.fileUploadLimit.replace("{0}", maxCombinedFileSize / 1000000)
      );
    } else if (notAllowedFileType) {
      setError(gb.msg.fileTypeNotAllowed.replace("{0}", notAllowedFileType));
    } else {
      addFilesHandler([...newFiles]);
    }
  };

  const handleFileDeleteButtonClick = (index) => {
    setError(false);
    removeFileHandler(index);
  };

  const formatBytes = (bytes, decimals = 2) => {
    if (!+bytes) return "0 Bytes";
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
  };

  return (
    <div>
      {error && <p className="alert alert--danger mb-2">{error}</p>}
      <div className="shadow-sm">
        <div className={headClassNames.join(" ")}>
          <button
            className="px-3 py-2 border border-gray-300 rounded text-sm shadow-sm bg-white"
            onClick={handleSelectButtonClick}
          >
            Selecteer bijlage(s)
          </button>
          <input
            type="file"
            className="hidden"
            ref={fileFieldRef}
            onChange={handleChange}
            multiple
          />
        </div>
        {files && files.length > 0 && (
          <div className="border border-t-0 border-gray-300 rounded-bl rounded-br">
            <ul>
              {files.map((file, index) => {
                const fileName =
                  file.name.length > 30
                    ? file.name.slice(0, 30) + "..."
                    : file.name;
                const fileSize = formatBytes(file.size);
                const classNames = ["py-3 px-4 flex justify-between"];
                if (index + 1 != files.length) {
                  classNames.push("border-b border-gray-300");
                }
                return (
                  <li className={classNames.join(" ")} key={index}>
                    <div>
                      <span className="text-sm">{`${fileName} (${fileSize})`}</span>
                    </div>
                    <div
                      className="flex items-center"
                      onClick={() => handleFileDeleteButtonClick(index)}
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                        className="w-5 fill-[#eb4240] cursor-pointer"
                      >
                        <path d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />{" "}
                      </svg>
                    </div>
                  </li>
                );
              })}
            </ul>
          </div>
        )}
      </div>
    </div>
  );
};

export default FileUploader;
