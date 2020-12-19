<template>
  <Layout>
    <header class="hero relative w-full bg-mc-yellow pt-28 pb-32 px-constrained text-center overflow-hidden md:pt-44">
      <div class="flex flex-nowrap justify-evenly items-center relative mb-12 max-w-7xl mx-auto">
        <div class="hidden flex-col flex-nowrap items-center pt-6 md:flex">
          <div class="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
            <g-image src="~/assets/images/chocolomo.png" />
          </div>
          <p class="font-cartoon text-white">Chocolomo</p>
        </div>

        <div class="flex flex-col flex-nowrap items-center pt-6">
          <div class="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
            <g-image src="~/assets/images/patote.png" />
          </div>
          <p class="font-cartoon text-white">Patote</p>
        </div>

        <div class="w-60 rounded-full border-6 border-white mx-3 overflow-hidden">
          <g-image src="~/assets/images/juanele-cartoon.png" />
        </div>

        <div class="flex flex-col flex-nowrap items-center pt-6">
          <div class="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
            <g-image src="~/assets/images/cuco.png" />
          </div>
          <p class="font-cartoon text-white">Cuco</p>
        </div>

        <div class="hidden flex-col flex-nowrap items-center pt-6 md:flex">
          <div class="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
            <g-image src="~/assets/images/abuela.png" />
          </div>
          <p class="font-cartoon text-white">Abuela</p>
        </div>
      </div>

      <h1 class="title font-display opacity-95 uppercase text-white text-4xl leading-none mb-12">Moco-Comics</h1>
      <p class="font-cartoon opacity-90 text-white text-lg">Monitos de Juanele</p>
    </header>

    <main
      class="px-constrained pb-48 -mt-20 relative grid grid-cols-1 gap-36 md:grid-cols-blog justify-items-center justify-evenly"
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
.hero::before {
  content: '';
  display: block;
  position: absolute;
  top: 0;
  left: 32%;
  width: max(50rem, 80vw);
  height: max(80rem, 80vh);
  background-color: #ff695b;
  transform: translateX(-50%) rotate(20deg);
  border-top-right-radius: 4rem;
  z-index: 0;
}

.title {
  text-shadow: 5px 5px #00000042;
}

@media (min-width: 1280px) {
  .hero::before {
    left: 40%;
  }
}
</style>
