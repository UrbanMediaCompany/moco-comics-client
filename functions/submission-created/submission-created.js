/* eslint-disable camelcase */
const fetch = require('node-fetch');
const md5 = require('crypto-js/md5');

const asyncFetch = (promise) =>
  promise
    .then(async (response) => {
      const data = await response.json();

      return response.ok ? [null, data] : [data];
    })
    .catch((error) => [error]);

exports.handler = async ({ body }) => {
  // 1. Authenticate service
  const [error, { jwt }] = await asyncFetch(
    fetch(`${process.env.STRAPI_URL}/auth/local`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ identifier: process.env.STRAPI_IDENTIFIER, password: process.env.STRAPI_PASSWORD }),
    }),
  );

  if (error || !jwt)
    return {
      statusCode: 502,
      body: JSON.stringify({ error: 502, message: 'Unable to authenticate with comments provider.' }),
    };

  // 2. Generate Gravatar URL
  const {
    payload: {
      data: { name: author, email, website, comment: content, post, replies_to = null },
    },
  } = JSON.parse(body);
  const hash = md5(email.trim().toLowerCase()).toString();
  const gravatar = `https://www.gravatar.com/avatar/${hash}`;

  // 3. Submit comment to Strapi
  const comment = { author, email, website, gravatar, content, post, replies_to };

  const [err, response] = await asyncFetch(
    fetch(`${process.env.STRAPI_URL}/comments`, {
      method: 'POST',
      headers: { Authorization: `Bearer ${jwt}`, 'Content-Type': 'application/json' },
      body: JSON.stringify(comment),
    }),
  );

  if (err) {
    const code = err.statusCode || 500;
    const message = err.message || 'Something went wrong.';
    const data = err.data || null;

    return {
      statusCode: code,
      body: JSON.stringify({ error: code, message, data }),
    };
  }

  return {
    statusCode: 200,
    body: JSON.stringify({ comment: response }),
  };
};
