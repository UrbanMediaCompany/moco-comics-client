const fetch = require('node-fetch');

const asyncFetch = (...args) => {
  return fetch(...args)
    .then(async (response) => {
      const data = await response.json();
      return response.ok ? [null, data] : [data];
    })
    .catch((error) => [error]);
};

module.exports = asyncFetch;
