<template>
  <article class="flex flex-nowrap flex-col items-center" :data-uuid="id" :id="slug">
    <div v-for="image in media" :key="image.id" class="px-6 mb-8">
      <g-image :src="image.url" class="w-full max-w-5xl border-4 mx-auto border-black" />
    </div>

    <div class="w-full bg-white border-t-10 border-grey-300 rounded-lg shadow-sm overflow-hidden">
      <header class="px-8 pt-8 mb-8">
        <h2 class="font-display text-lg">{{ title }}</h2>
        <time :datetime="publishedDate" class="font-display text-grey-400">{{
          capitalize(formattedPublishedDate)
        }}</time>
      </header>

      <section v-html="toHTML(content)" class="rich-text text-gray-800 px-8 pb-8"></section>

      <ShareButtons :slug="slug" :characters="characters" />

      <CommentsList :post="{ id: id, title: title, media: media[0] }" :comments="comments.edges" />
    </div>
  </article>
</template>

<script>
import capitalize from '~/utils/capitalize';
import toHTML from '~/utils/toHTML';
import ShareButtons from '~/components/ShareButtons';
import CommentsList from './CommentsList';

export default {
  name: 'Post',
  components: {
    ShareButtons,
    CommentsList,
  },
  props: {
    observer: IntersectionObserver,
    id: String,
    slug: String,
    title: String,
    publishedDate: String,
    formattedPublishedDate: String,
    content: String,
    characters: Array,
    media: Array,
    comments: Object,
  },
  mounted() {
    if (this.observer) this.observer.observe(this.$el);
  },
  methods: {
    capitalize,
    toHTML,
  },
};
</script>

<style>
article {
  scroll-margin-top: 20px;
  scroll-snap-margin-top: 20px;
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
</style>
