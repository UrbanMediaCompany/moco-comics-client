module.exports = (api) => {
  api.loadSource(() => {
    // Use the Data Store API here: https://gridsome.org/docs/data-store-api/
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
