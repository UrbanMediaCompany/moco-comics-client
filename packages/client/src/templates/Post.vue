<template>
  <SiteLayout>
    <header
      class="hero relative w-full min-h-40 bg-mc-yellow pt-28 pb-32 px-constrained text-left overflow-hidden md:pt-44"
    >
      <div class="flex flex-col flex-nowrap items-center relative mb-12 max-w-7xl mx-auto">
        <h1 class="title font-display opacity-95 text-white text-4xl leading-none mb-8">
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
        <section v-html="content" class="rich-text text-gray-800 p-8"></section>

        <ShareButtons :slug="post.slug" :characters="post.characters" />

        <CommentsList :post="{ id: post.id, title: post.title, media: post.media[0] }" :comments="post.comments" />
      </div>
    </main>
  </SiteLayout>
</template>

<page-query>
query($id: ID!) {
  metadata {
    siteName
    siteUrl
    siteDescription
    author
  }

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

export default {
  name: 'PostDetail',
  metaInfo() {
    const { siteName, siteUrl, author } = this.$page.metadata;
    const { title, publishedDate, content, characters = [] } = this.$page.strapiPosts;

    const canonicalUrl = `${siteUrl}${this.$route.path}`;
    const description = content.length < 140 ? content : `${content.slice(0, 137)}...`;

    return {
      title,
      meta: [
        { name: 'description', content: description },
        { property: 'og:type', content: 'article' },
        { property: 'og:site_name', content: siteName },
        { property: 'og:title', content: title },
        { property: 'og:description', content: description },
        { property: 'og:image', content: '' },
        { property: 'og:image:type', content: 'image/png' },
        { property: 'og:image:width', content: '1200' },
        { property: 'og:image:height', content: '630' },
        { property: 'og:image:alt', content: '' },
        { property: 'og:url', content: canonicalUrl },
        { property: 'og:locale', content: 'es_MX' },
        { property: 'article:published_time', content: publishedDate },
        { property: 'article:author', content: author },
        { property: 'article:section', content: 'Comics' },
        { property: 'article:tag', content: characters.join(', ') },
        { name: 'twitter:card', content: 'summary_large_image' },
        { name: 'twitter:site:id', content: author },
        { name: 'twitter:creator', content: author },
        { name: 'twitter:title', content: title },
        { name: 'twitter:description', content: description },
        { name: 'twitter:image', content: '' },
        { name: 'twitter:image_alt', content: '' },
        { name: 'twitter:url', content: canonicalUrl },
      ],
      link: [{ rel: 'canonical', href: canonicalUrl }],
    };
  },
  components: {
    ShareButtons,
    CommentsList,
  },
  computed: {
    post() {
      return this.$page.strapiPosts;
    },
    content() {
      return toHTML(this.post.content);
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
