<template>
  <SiteLayout>
    <header class="hero relative w-full bg-mc-yellow pt-28 pb-32 px-constrained text-center overflow-hidden md:pt-44">
      <div class="flex flex-nowrap justify-evenly items-center relative mb-12 max-w-7xl mx-auto">
        <div class="hidden flex-col flex-nowrap items-center pt-6 md:flex">
          <div class="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
            <g-image src="~/assets/images/chocolomo.png" immediate />
          </div>
          <p class="font-cartoon text-white">Chocolomo</p>
        </div>

        <div class="flex flex-col flex-nowrap items-center pt-6">
          <div class="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
            <g-image src="~/assets/images/patote.png" immediate />
          </div>
          <p class="font-cartoon text-white">Patote</p>
        </div>

        <div class="w-60 rounded-full border-6 border-white mx-3 overflow-hidden">
          <g-image src="~/assets/images/juanele-cartoon.png" immediate />
        </div>

        <div class="flex flex-col flex-nowrap items-center pt-6">
          <div class="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
            <g-image src="~/assets/images/cuco.png" immediate />
          </div>
          <p class="font-cartoon text-white">Cuco</p>
        </div>

        <div class="hidden flex-col flex-nowrap items-center pt-6 md:flex">
          <div class="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
            <g-image src="~/assets/images/abuela.png" immediate />
          </div>
          <p class="font-cartoon text-white">Abuela</p>
        </div>
      </div>

      <h1 class="title font-display opacity-95 uppercase text-white text-4xl leading-none mb-12">Moco-Comics</h1>
      <p class="font-cartoon opacity-90 text-white text-lg">Monitos de Juanele</p>
    </header>

    <main class="px-constrained -mt-20 md:pb-64">
      <section class="grid grid-cols-1 gap-36 pb-20 relative">
        <Post
          v-for="post in $page.allStrapiPosts.posts"
          :key="post.node.id"
          :observer="observer"
          v-bind="post.node"
          class="md:col-start-1"
        />
      </section>

      <aside class="pb-48 md:sticky md:-top-4 md:h-min">
        <nav class="mb-10">
          <div class="flex flex-row flex-nowrap items-center justify-center md:flex-col">
            <p
              class="flex justify-center items-center rounded-full bg-mc-red text-white font-cartoon text-center border-b-10 border-mc-red-500 uppercase text-lg p-12 md:p-16"
            >
              Página <br />
              {{ $context.currentPage }} de {{ $context.totalPages }}
            </p>

            <ul
              class="flex flex-col flex-nowrap max-w-min -ml-4 md:flex-row md:ml-0 md:-mt-16 md:max-w-none md:w-full md:justify-center"
            >
              <li class="mb-4 md:mb-0 md:mr-12">
                <g-link
                  v-if="$context.previousPage"
                  :to="$context.previousPage"
                  class="inline-block bg-mc-yellow text-white p-2 border-b-4 border-r-4 border-mc-yellow-500 transform rotate-6 scale-125 hover:-rotate-6 duration-300"
                >
                  <ChevronLeft />
                </g-link>

                <span
                  v-else
                  class="inline-block bg-mc-yellow text-mc-yellow-500 p-2 border-b-4 border-r-4 border-mc-yellow-500 transform rotate-6 scale-125 duration-300 cursor-not-allowed"
                >
                  <ChevronLeft />
                </span>
              </li>
              <li>
                <g-link
                  v-if="$context.nextPage"
                  :to="$context.nextPage"
                  class="inline-block bg-mc-yellow text-white p-2 border-b-4 border-l-4 border-mc-yellow-500 transform -rotate-6 scale-125 hover:-rotate-12 duration-300"
                  ><ChevronRight
                /></g-link>

                <span
                  v-else
                  class="inline-block bg-mc-yellow text-mc-yellow-500 p-2 border-b-4 border-r-4 border-mc-yellow-500 transform rotate-6 scale-125 duration-300 cursor-not-allowed"
                >
                  <ChevronRight />
                </span>
              </li>
            </ul>
          </div>

          <ul class="min-w-120 px-8 py-3 bg-white rounded-xl mt-4 shadow-sm">
            <li
              class="font-display text-grey-400 hover:text-black transition-colors py-3 duration-300 border-b-2 border-dotted last:border-0"
              v-for="post in $page.allStrapiPosts.posts"
              :key="post.node.id"
            >
              <a
                :href="'#' + post.node.slug"
                class="group flex flex-nowrap items-center"
                :class="{ 'is-active': post.node.id === observedPost }"
              >
                <g-image
                  :src="post.node.media[0].url"
                  alt=""
                  class="inline-block rounded-md w-16 h-16 object-cover mr-8 border-2 group-hover:border-mc-yellow"
                  :class="post.node.id === observedPost ? 'border-mc-yellow' : 'border-grey-400'"
                />

                <span>
                  {{ post.node.title }}
                </span>
              </a>
            </li>
          </ul>
        </nav>

        <SocialsNav />
      </aside>
    </main>

    <CommentModal slot="modal" v-if="commentModal.isOpen" />
  </SiteLayout>
</template>

<page-query>
  query ($currentPage: Int!, $postsPerPage: Int!) {
    allStrapiPosts (sortBy: "published_at", perPage: $postsPerPage, page: $currentPage) {
      posts: edges {
        node {
          id
          slug
          title
          publishedDate: published_at
          formattedPublishedDate: published_at(format: "MMMM D, YYYY", locale: "es-MX")
          content
          characters {
            name
          }
          media {
            id
            url
          }
          comments: belongsTo {
            edges {
              node {
                ... on StrapiComments {
                  id
                  author
                  gravatar
                  content
                  publishedDate: published_at
                  formattedPublishedDate: published_at(format: "MMMM D, YYYY", locale: "es-MX")
                  parent: replies_to {
                    id
                  }
                  replies: belongsTo {
                    edges {
                      node {
                        ... on StrapiComments {
                          id
                          author
                          gravatar
                          content
                          publishedDate: published_at
                          formattedPublishedDate: published_at(format: "MMMM D, YYYY", locale: "es-MX")
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }

    }
  }
</page-query>

<script>
import Post from '~/components/Post';
import CommentModal from '~/components/CommentModal';
import ChevronLeft from '~/assets/icons/chevron-left.svg';
import ChevronRight from '~/assets/icons/chevron-right.svg';
import SocialsNav from '~/components/SocialsNav';

export default {
  metaInfo: {
    title: 'Moco-Comics | Monitos de Juanele',
  },
  components: {
    Post,
    CommentModal,
    ChevronLeft,
    ChevronRight,
    SocialsNav,
  },
  data() {
    return {
      observer: null,
      observedPost: null,
    };
  },
  computed: {
    commentModal() {
      return this.$store.state.commentModal;
    },
  },
  created() {
    if (!window.matchMedia) return;

    const { matches: isMediumViewport } = window.matchMedia('(min-width: 768px)');

    if (!isMediumViewport) return;

    this.observer = new IntersectionObserver(this.onElementObserved, { root: this.$el, threshold: 0.5 });
  },
  beforeDestroy() {
    this.observer.disconnect();
  },
  methods: {
    onElementObserved(entries) {
      entries.forEach(({ isIntersecting, target }) => {
        if (!isIntersecting) return;

        this.observedPost = target.getAttribute('data-uuid');
      });
    },
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
  text-shadow: 5px 5px var(--mc-color-red-500);
}

a.is-active {
  color: #000;
}

main {
  display: grid;
  gap: 5rem;
  justify-content: space-evenly;
}

@media (min-width: 768px) {
  main {
    grid-template-columns: minmax(384px, 640px) 300px;
    column-gap: 2rem;
  }
}

@media (min-width: 1024px) {
  main {
    grid-template-columns: minmax(460px, 680px) 320px;
  }
}

@media (min-width: 1280px) {
  .hero::before {
    left: 40%;
  }
}
</style>
