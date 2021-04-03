const path = require('path');

exports.createPages = async ({ actions, graphql }) => {
  const {
    data: {
      allStrapiPost: { totalCount, edges: posts },
    },
  } = await graphql(`
    query {
      allStrapiPost(sort: { fields: published_at, order: DESC }) {
        totalCount

        edges {
          node {
            id: strapiId
          }
        }
      }
    }
  `);

  const postsPerPage = Number(process.env.GATSBY_POSTS_PER_PAGE) || 5;
  const totalPages = Math.ceil(totalCount / postsPerPage);

  Array.from({ length: totalPages }).forEach((_, index) => {
    const page = index + 1;
    const isFirstPage = page === 1;
    const isLastPage = page === totalCount;
    const skip = index * postsPerPage;

    // Get the post's IDs so that we can easily retrieve all the comments that
    // will appear on the current page
    const postsInPage = posts.slice(skip, skip + postsPerPage).map(({ node: { id } }) => id);

    actions.createPage({
      path: isFirstPage ? '/' : `/pagina/${page}`,
      component: path.resolve('src/templates/PaginatedBlog.jsx'),
      context: {
        postsPerPage,
        skip,
        currentPage: page,
        totalPages,
        nextPage: isLastPage ? null : `/pagina/${page + 1}`,
        previousPage: isFirstPage ? null : page === 2 ? `/` : `/pagina/${page - 1}`,
        postsInPage,
      },
    });
  });
};
