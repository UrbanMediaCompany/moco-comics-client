const characters = require('./db/output/characters.json');
const products = require('./db/output/products.json');
const posts = require('./db/output/posts.json');
const comments = require('./db/output/comments.json');
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
