/* eslint-disable no-plusplus */
/* eslint-disable no-await-in-loop */
const characters = require('../../../db-migration/db/migration/characters.json');
const products = require('../../../db-migration/db/migration/products.json');
const posts = require('../../../db-migration/db/migration/posts.json');
const comments = require('../../../db-migration/db/migration/comments.json');
const replies = require('../../../db-migration/db/migration/replies.json');

const uploadCollection = async (name, collection) => {
  for (let index = 0; index < collection.length; index++) {
    const item = collection[index];
    await strapi.services[name].create(item);
  }
};

const updateReplies = async () => {
  for (let index = 0; index < replies.length; index++) {
    const { id, replies_to } = replies[index];
    await strapi.services.comment.update({ id }, { replies_to });
  }
};

const migrateData = async () => {
  // 1. Are all assets up?
  // console.log('IMAGES ARE READY');
  // 2. Upload characters and products
  // console.log('UPLOADING CHARACTERS');
  // await uploadCollection('character', characters);
  // console.log('DONE');
  // console.log('UPLOADING PRODUCTS');
  // await uploadCollection('product', products);
  // console.log('DONE');
  // 3. Upload posts
  // console.log('UPLOADING POSTS');
  // await uploadCollection('post', posts);
  // console.log('DONE');
  // // 4. Upload comments
  // console.log('UPLOADING COMMENTS');
  // await uploadCollection('comment', comments);
  // console.log('DONE');
  // // 5. Associate replies
  // console.log('UPDATING COMMENTS WITH REPLIES');
  // await updateReplies();
  // console.log('DONE');
};

module.exports = migrateData;
