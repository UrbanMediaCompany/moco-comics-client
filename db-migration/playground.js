const characters = require('./db/migration/characters.json');
const products = require('./db/migration/products.json');
const posts = require('./db/migration/posts.json');
const comments = require('./db/migration/comments.json');
const normalizedComments = require('./db/normalized/comments.json');

console.log(
  '[Comments that reply to a comment]',
  normalizedComments.length,
  normalizedComments.filter((comment) => comment.parent !== null).length
);

const anomalies = normalizedComments.filter((comment) => comment.parent > comment.id);

console.log('[Comments with an younger parent]', anomalies.length);

console.log(
  '[Transformed ids]',
  normalizedComments
    .map((comment, index) => {
      if (comment.parent < comment.id) return null;
      const parentIndex = normalizedComments.findIndex((c) => c.id === comment.parent);

      return [index, parentIndex];
    })
    .filter(Boolean)
);
