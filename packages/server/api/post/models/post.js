'use strict';

const slug = require('slug');

module.exports = {
  lifecycles: {
    beforeCreate: async (data) => {
      if (data.title) {
        // eslint-disable-next-line no-param-reassign
        data.slug = slug(data.title);
      }
    },
    beforeUpdate: async (params, data) => {
      if (data.title) {
        // eslint-disable-next-line no-param-reassign
        data.slug = slug(data.title);
      }
    },
  },
};
