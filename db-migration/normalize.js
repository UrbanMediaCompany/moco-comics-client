const fs = require('fs');
const TurndownService = require('turndown');

const originalCategories = require('./db/original/categories.json');
const originalProducts = require('./db/original/products.json');
const originalComments = require('./db/original/comments.json');
const originalPosts = require('./db/original/posts.json');

const characterSchemaTransform = (category) => ({
  id: category.ID,
  name: category.Name,
  image: category.Image || null, // Reference to upload
});

const productSchemaTransform = (product) => ({
  id: product.ID,
  name: product.Name,
  price: product.Price,
  media: product.Image || null, // Reference to upload
  files: product.File || null, // Reference to upload
});

const turndownService = new TurndownService();
const postSchemaTransform = (post) => ({
  id: post.ID,
  title: post.Title,
  status: post.Status, // ['Published', 'Deleted', 'Not Indexed']
  published_at: post.Date,
  content: turndownService.turndown(post.Content),
  slug: post.Url,
  media: post.Image || null, // Reference to upload
  characters: post.CategoryID, // Reference to category
});

const commentSchemaTransform = (comment) => ({
  id: comment.ID,
  post: comment.PostID, // Reference to post
  parent: comment.Parent, // Reverse aggregate this [parent -> replies]
  author: comment.Name,
  email: comment.Mail,
  website: comment.Web,
  content: comment.Content,
  published_at: comment.Date,
  gravatar: comment.Gravatar,
  status: comment.Status, // ['Approved', 'Unapproved', 'NotIndexed']
});

const normalize = () => {
  const characters = originalCategories.map(characterSchemaTransform);
  const products = originalProducts
    .map(productSchemaTransform)
    // Update asset path
    .map((product) => ({ ...product, media: product.media.split('/').reverse()[0] }));

  const posts = originalPosts
    .map(postSchemaTransform)
    // Update asset path
    .map((post) => ({ ...post, media: post.media?.split('/').reverse()[0] }))
    // We've got one less category, fix offset
    .map((post) => ({ ...post, characters: post.characters === 1 ? null : post.characters - 1 }))
    // Update slug format
    .map((post) => ({ ...post, slug: post.slug.split('/').reverse()[0] }))
    // Update embedded images and same-domain links
    .map((post) => ({
      ...post,
      content: post.content
        .replace('(img/Posts/', '(assets/image/')
        .replace('http://www.moco-comics.com/comic/', 'https://moco-comics.com/'),
    }))
    // We don't want faulty data
    .filter((post) => !['Deleted', 'Not Indexed'].includes(post.status));

  const comments = originalComments
    .map(commentSchemaTransform)
    // Root comments are assigned to a non-existing comment with ID 4
    .map((comment) => ({ ...comment, parent: comment.parent === 4 ? null : comment.parent }))
    // Update statuses
    .map((comment) => ({ ...comment, status: comment.status === 'Approved' ? 'approved' : 'not_approved' }))
    // We don't want comments that no longer have an associated post
    .filter((comment) => posts.find((post) => post.id === comment.post) !== undefined);

  console.log('[CHARACTERS]', originalCategories.length, characters.length);
  console.log('[PRODUCTS]', originalProducts.length, products.length);
  console.log('[POSTS]', originalPosts.length, posts.length);
  console.log('[COMMENTS]', originalComments.length, comments.length);

  fs.writeFile('db/normalized/characters.json', JSON.stringify(characters), (error) => console.log);
  fs.writeFile('db/normalized/products.json', JSON.stringify(products), (error) => console.log);
  fs.writeFile('db/normalized/posts.json', JSON.stringify(posts), (error) => console.log);
  fs.writeFile('db/normalized/comments.json', JSON.stringify(comments), (error) => console.log);
};

normalize();
