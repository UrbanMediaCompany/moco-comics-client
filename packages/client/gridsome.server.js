const fetch = require('node-fetch');

module.exports = (api) => {
  api.loadSource(async ({ addCollection, store }) => {
    const posts = addCollection({ typeName: 'StrapiPosts', dateField: 'created_at' });
    const comments = addCollection({ typeName: 'StrapiComments', dateField: 'created_at' });
    const products = addCollection({ typeName: 'StrapiProducts', dateField: 'created_at' });

    await fetch(`${process.env.STRAPI_URL}/posts?_limit=1000`)
      .then((res) => res.json())
      .then((docs) => docs.forEach((doc) => posts.addNode(doc)));

    await fetch(`${process.env.STRAPI_URL}/comments?_limit=1000`)
      .then((res) => res.json())
      .then((docs) =>
        docs.forEach((doc) => {
          const node = {
            ...doc,
            post: store.createReference('StrapiPosts', doc.post.id),
          };

          if (doc.replies_to) node.replies_to = store.createReference('StrapiComments', doc.replies_to.id);

          comments.addNode(node);
        }),
      );

    await fetch(`${process.env.STRAPI_URL}/products?_limit=1000`)
      .then((res) => res.json())
      .then((docs) => docs.forEach((doc) => products.addNode(doc)));
  });

  api.createPages(async ({ graphql, createPage }) => {
    const postsPerPage = Number(process.env.GRIDSOME_POSTS_PER_PAGE) || 5;
    const {
      data: {
        allStrapiPosts: { totalCount },
      },
    } = await graphql(`
      query {
        allStrapiPosts {
          totalCount
        }
      }
    `);

    const totalPages = totalCount / postsPerPage;

    Array.from({ length: totalPages }).forEach((_, index) => {
      const page = index + 1;
      const isFirstPage = page === 1;
      const isLastPage = page === totalCount;

      createPage({
        path: isFirstPage ? '/' : `/pagina/${page}`,
        component: './src/templates/Blog.vue',
        context: {
          postsPerPage,
          currentPage: page,
          totalPages,
          nextPage: isLastPage ? null : `/pagina/${page + 1}`,
          // eslint-disable-next-line no-nested-ternary
          previousPage: isFirstPage ? null : page === 2 ? `/` : `/pagina/${page - 1}`,
        },
      });
    });
  });
};
