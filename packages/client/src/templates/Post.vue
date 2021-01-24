<template>
  <SiteLayout>
    <header
      class="hero relative w-full min-h-40 bg-mc-yellow pt-28 pb-32 px-constrained text-left overflow-hidden md:pt-44"
    >
      <div class="flex flex-col flex-nowrap items-start relative mb-12 max-w-7xl mx-auto">
        <h1 class="title font-display opacity-95 text-white text-2xl leading-none mb-8">
          {{ post.title }}
        </h1>

        <time :datetime="post.publishedDate" class="font-cartoon opacity-90 text-white text-lg">{{
          capitalize(post.formattedPublishedDate)
        }}</time>

        <div class="flex flex-nowrap items-center">
          <div
            class="hidden flex-col flex-nowrap items-center pt-6 md:flex mr-4"
            v-for="character in post.characters"
            :key="character.name"
          >
            <div class="w-32 rounded-full border-4 border-white overflow-hidden mb-4">
              <g-image :src="character.image.url" immediate />
            </div>
          </div>
        </div>
      </div>
    </header>

    <main class="relative px-constrained -mt-28 pb-28 md:pb-64">
      <section v-for="image in post.media" :key="image.id" class="px-6 mb-8">
        <g-image :src="image.url" class="w-full max-w-5xl border-4 mx-auto border-black" />
      </section>

      <div class="w-full bg-white border-t-10 border-grey-300 rounded-lg shadow-sm overflow-hidden mb-16">
        <section v-html="toHTML(post.content)" class="rich-text text-gray-800 p-8"></section>

        <ShareButtons :slug="post.slug" :characters="post.characters" />

        <CommentsList
          :post="{ id: post.id, title: post.title, media: post.media[0] }"
          :comments="post.comments.edges"
        />
      </div>
    </main>

    <CommentModal slot="modal" v-if="commentModal.isOpen" />
  </SiteLayout>
</template>

<page-query>
query($id: ID!) {
  strapiPosts(id: $id) {
    title
    publishedDate: published_at
    formattedPublishedDate: published_at(format: "MMMM D, YYYY", locale: "es-MX")
    content
    characters {
      name
      image {
        url
      }
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
</page-query>

<script>
import capitalize from '~/utils/capitalize';
import toHTML from '~/utils/toHTML';
import ShareButtons from '~/components/ShareButtons';
import CommentsList from '~/components/CommentsList';
import CommentModal from '~/components/CommentModal';

export default {
  name: 'PostDetail',
  components: {
    ShareButtons,
    CommentsList,
    CommentModal,
  },
  computed: {
    post() {
      return this.$page.strapiPosts;
    },
    commentModal() {
      return this.$store.state.commentModal;
    },
  },
  methods: {
    capitalize,
    toHTML,
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

.rich-text a {
  text-decoration: underline;
  text-decoration-style: double;
  text-decoration-thickness: 2px;
  text-decoration-color: var(--mc-color-yellow);
  transition: all 0.3s;
}

.rich-text p {
  margin-bottom: 1.6rem;
}

@media (min-width: 768px) {
  main {
    display: grid;
    grid-template-columns: 460px 1fr;
    gap: 2rem;
  }
}

@media (min-width: 1024px) {
  main {
    grid-template-columns: minmax(520px, 800px) minmax(420px, 460px);
    align-items: flex-start;
    gap: 5rem;
  }
}

@media (min-width: 1280px) {
  .hero::before {
    left: 40%;
  }
}
</style>
