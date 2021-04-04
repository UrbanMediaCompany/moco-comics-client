const encodeFormData = (formData) => {
  return Object.keys(formData)
    .map((key) => `${encodeURIComponent(key)}=${encodeURIComponent(formData[key])}`)
    .join('&');
};

export default encodeFormData;
