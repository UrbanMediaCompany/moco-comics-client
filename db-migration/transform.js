const fs = require('fs');
const { Client } = require('pg');

const normalizedCharacters = require('./db/normalized/characters.json');
const normalizedProducts = require('./db/normalized/products.json');
const normalizedPosts = require('./db/normalized/posts.json');
const normalizedComments = require('./db/normalized/comments.json');

const queryOne = (...params) =>
  client
    .query(...params)
    .then((res) => [null, res.rows[0]])
    .catch((err) => [err]);

const transformCharacters = async () => {
  const transformations = normalizedCharacters.map(async (character) => {
    if (!character.image) return character;

    const transformation = { ...character };

    const [error, match] = await queryOne(`SELECT * FROM "upload_file" WHERE "name" = '${character.image}';`);

    if (error || !match || !match.id) {
      console.log('[IMAGE NOT FOUND]', character.name);
      transformation.image = null;
    } else {
      transformation.image = match.id;
    }

    return transformation;
  });

  return Promise.all(transformations);
};

const transformProducts = async () => {
  const transformations = normalizedProducts.map(async (product) => {
    if (!product.media && !product.files) return product;

    const transformation = { ...product };

    if (product.media) {
      const [error, match] = await queryOne(`SELECT * FROM "upload_file" WHERE "name" = '${product.media}';`);

      if (error || !match || !match.id) {
        console.log('[IMAGE NOT FOUND]', product.name);
        transformation.media = null;
      } else {
        transformation.media = [match.id];
      }
    }

    if (product.files) {
      const [error, match] = await queryOne(`SELECT * FROM "upload_file" WHERE "name" = '${product.files}';`);

      if (error || !match || !match.id) {
        console.log('[FILE NOT FOUND]', product.name);
        transformation.files = null;
      } else {
        transformation.files = [match.id];
      }
    }

    return transformation;
  });

  return Promise.all(transformations);
};

const transformPosts = async () => {
  const transformations = normalizedPosts.map(async (post) => {
    const transformation = { ...post };

    if (post.media) {
      const [error, match] = await queryOne(`SELECT * FROM "upload_file" WHERE "name" = '${post.media}'`);

      if (error || !match || !match.id) {
        console.log('[IMAGE NOT FOUND]', post.title);
        transformation.media = null;
      } else {
        transformation.media = [match.id];
      }
    }

    if (post.characters) {
      const normalizedCharacter = normalizedCharacters.find((character) => character.id === post.characters);

      const [error, match] = await queryOne(`SELECT * FROM "character" WHERE "name" = '${normalizedCharacter.name}'`);

      if (error || !match || !match.id) {
        console.log('[CHARACTER NOT FOUND]', post.title);
        transformation.characters = null;
      } else {
        transformation.characters = [match.id];
      }
    }

    return transformation;
  });

  return Promise.all(transformations);
};

const transformComments = async () => {
  const transformations = normalizedComments.map(async (comment) => {
    const transformation = { ...comment };

    if (comment.post) {
      const normalizedPost = normalizedPosts.find((post) => post.id === comment.post);

      const [error, match] = await queryOne(`SELECT * FROM "post" WHERE "title" = '${normalizedPost.title}'`);

      if (error || !match || !match.id) {
        console.log('[POST NOT FOUND]', normalizedPost.title, comment.post, comment.parent);
        transformation.post = null;
      } else {
        transformation.post = match.id;
      }
    }

    // Fix corrupted data
    if (comment.email === 'bonito@comic') {
      transformation.email = '';
    }

    if (comment.parent) {
      transformation.parent = null;
    }

    return transformation;
  });

  return Promise.all(transformations);
};

const client = new Client({
  user: 'fsvdr',
  host: 'localhost',
  database: 'moco_comics',
  password: '',
  port: 5432,
});

client.connect();

(async () => {
  // IMPORTANT: FOLLOW THIS STEPS IN ORDER
  // 1. Upload assets

  // 2. Transform & upload these

  // const characters = await transformCharacters();
  // fs.writeFile('db/migration/characters.json', JSON.stringify(characters), (error) => console.log);

  // const products = await transformProducts();
  // fs.writeFile('db/migration/products.json', JSON.stringify(products), (error) => console.log);

  // 3. Transform & upload this

  // const posts = await transformPosts();
  // fs.writeFile('db/migration/posts.json', JSON.stringify(posts), (error) => console.log);

  // 4. Transform & upload this

  // const comments = await transformComments();
  // fs.writeFile('db/migration/comments.json', JSON.stringify(comments), (error) => console.log);

  client.end();
})();
