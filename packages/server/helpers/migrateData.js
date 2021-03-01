const characters = require('../../../db-migration/db/migration/characters.json');
const products = require('../../../db-migration/db/migration/products.json');
const posts = require('../../../db-migration/db/migration/posts.json');
const comments = require('../../../db-migration/db/migration/comments.json');
const replies = require('../../../db-migration/db/migration/replies.json');

const migrateData = async () => {
  // 1. Are all assets up?
  console.log('IMAGES ARE READY');

  // 2. Upload characters and products
  console.log('UPLOADING CHARACTERS');
  const charactersUpload = characters.map((character) => strapi.services.character.create(character));
  await Promise.all(charactersUpload);
  console.log('DONE');
  console.log('UPLOADING PRODUCTS');
  const productsUpload = products.map((product) => strapi.services.product.create(product));
  await Promise.all(productsUpload);
  console.log('DONE');

  // 3. Upload posts
  console.log('UPLOADING POSTS');
  const postsUpload = posts.map((post) => strapi.services.post.create(post));
  await Promise.all(postsUpload);
  console.log('DONE');

  // 4. Upload comments
  console.log('UPLOADING COMMENTS');
  const commentsUpload = comments.map((comment) => strapi.services.comment.create(comment));
  await Promise.all(commentsUpload);
  console.log('DONE');

  // 5. Associate replies
  console.log('UPDATING COMMENTS WITH REPLIES');
  // eslint-disable-next-line camelcase
  const repliesUpdate = replies.map(({ id, replies_to }) => strapi.services.comment.update({ id }, { replies_to }));
  await Promise.all(repliesUpdate);
  console.log('DONE');
};

module.exports = migrateData;
