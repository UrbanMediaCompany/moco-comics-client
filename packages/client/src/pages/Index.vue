<template>
  <Layout>
    <header class="hero w-full bg-mc-yellow pt-20 pb-20 text-center md:pt-32">
      <div class="flex flex-nowrap justify-evenly items-center relative mb-8 max-w-4xl mx-auto">
        <div class="hidden flex-col flex-nowrap items-center pt-2 md:flex">
          <div class="w-20 rounded-full border-6 border-white overflow-hidden mb-2">
            <g-image src="~/assets/images/chocolomo.png" />
          </div>
          <p class="font-cartoon text-white">Chocolomo</p>
        </div>

        <div class="flex flex-col flex-nowrap items-center pt-2">
          <div class="w-20 rounded-full border-6 border-white overflow-hidden mb-2">
            <g-image src="~/assets/images/patote.png" />
          </div>
          <p class="font-cartoon text-white">Patote</p>
        </div>

        <div class="w-28 rounded-full border-6 border-white overflow-hidden">
          <g-image src="~/assets/images/juanele-cartoon.png" />
        </div>

        <div class="flex flex-col flex-nowrap items-center pt-2">
          <div class="w-20 rounded-full border-6 border-white overflow-hidden mb-2">
            <g-image src="~/assets/images/cuco.png" />
          </div>
          <p class="font-cartoon text-white">Cuco</p>
        </div>

        <div class="hidden flex-col flex-nowrap items-center pt-2 md:flex">
          <div class="w-20 rounded-full border-6 border-white overflow-hidden mb-2">
            <g-image src="~/assets/images/abuela.png" />
          </div>
          <p class="font-cartoon text-white">Abuela</p>
        </div>
      </div>

      <h1 class="title font-display opacity-95 uppercase text-white text-7xl mb-6">Moco-Comics</h1>
      <p class="font-cartoon opacity-90 text-white text-xl">Monitos de Juanele</p>
    </header>

    <main
      class="px-constrained pb-20 -mt-6 relative grid grid-cols-1 gap-20 md:grid-cols-blog justify-items-center justify-evenly"
    >
      <Post v-for="post in $page.allStrapiPosts.posts" :key="post.node.id" v-bind="post.node" class="md:col-start-1" />
    </main>
  </Layout>
</template>

<page-query>
  query {
    allStrapiPosts (sortBy: "published_at", order: DESC, perPage: 10) {
      totalCount
      posts: edges {
        node {
          id
          title
          publishedDate: published_at
          formattedPublishedDate: published_at(format: "MMMM D, YYYY", locale: "es-MX")
          content
          media {
            id
            url
          }
        }
      }

    }
  }
</page-query>

<script>
import Post from '~/components/Post';

export default {
  metaInfo: {
    title: 'Moco-Comics | Monitos de Juanele',
  },
  components: {
    Post,
  },
};
</script>

<style>
.hero {
  --horizontal-inset: 0.8rem;
  --constrained-inset: calc((100vw - 1280px) / 2 + var(--horizontal-inset));

  position: relative;
  padding-left: max(var(--horizontal-inset), var(--constrained-inset));
  padding-right: max(var(--horizontal-inset), var(--constrained-inset));
  overflow: hidden;
}

.hero::before {
  content: '';
  display: block;
  position: absolute;
  top: 0;
  left: 50%;
  width: 50rem;
  height: 50rem;
  background-color: #ff695b;
  transform: translateX(-60%) rotate(20deg);
  border-top-right-radius: 4rem;
  z-index: 0;
}

.title {
  text-shadow: 5px 5px #00000024;
}
</style>
