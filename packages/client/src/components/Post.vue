<template>
  <article class="flex flex-col flex-nowrap items-center" :data-uuid="id" :id="slug">
    <div v-for="image in media" :key="image.id" class="px-6 mb-8">
      <g-image :src="image.url" class="w-full max-w-5xl border-4 border-black" />
    </div>

    <div class="w-full bg-white border-t-10 border-grey-300 rounded-lg shadow-sm">
      <header class="px-8 pt-8 mb-8">
        <h2 class="font-display text-lg">{{ title }}</h2>
        <time :datetime="publishedDate" class="font-display text-grey-400">{{
          capitalize(formattedPublishedDate)
        }}</time>
      </header>

      <section v-html="toHTML(content)" class="text-gray-800 px-8 pb-8"></section>

      <section class="flex flex-npwrap justify-evenly items-center px-8 py-8 md:justify-end">
        <a
          :href="twitterUrl"
          target="_blank"
          rel="noopener noreferrer"
          class="flex flex-col flex-nowrap items-center font-display text-sm transform hover:-rotate-6 transition-transform duration-300 md:flex-row"
        >
          <span class="inline-block bg-twitter p-3 rounded-full text-white mr-3">
            <TwitterIcon />
          </span>

          <span>Tweetear</span>
        </a>

        <a
          :href="facebookUrl"
          target="_blank"
          rel="noopener noreferrer"
          class="flex flex-col flex-nowrap items-center font-display text-sm ml-8 transform hover:rotate-6 transition-transform duration-300 md:flex-row"
        >
          <span class="inline-block bg-facebook p-3 rounded-full text-white mr-3">
            <FacebookIcon />
          </span>
          <span>Compartir</span>
        </a>

        <button
          v-if="isClipboardAvailable && !copySuccess"
          @click="copyToClipboard"
          class="flex flex-col flex-nowrap items-center font-display text-sm ml-8 transform hover:-rotate-6 transition-transform duration-300 md:mt-0 md:flex-row"
        >
          <span class="inline-block bg-mc-yellow p-3 rounded-full text-white mr-3">
            <ClipboardIcon />
          </span>
          <span>Copiar link</span>
        </button>

        <span v-if="copySuccess" class="flex flex-col flex-nowrap items-center font-display text-sm ml-8 md:flex-row">
          <span class="inline-block bg-mc-yellow p-3 rounded-full text-white mr-3">
            <CheckIcon />
          </span>
          <span>¡Copiado!</span>
        </span>
      </section>
    </div>
  </article>
</template>

<static-query>
query {
  metadata {
    siteUrl
    author
  }
}
</static-query>

<script>
import capitalize from '~/utils/capitalize';
import toHTML from '~/utils/toHTML';
import FacebookIcon from '~/assets/icons/facebook.svg';
import TwitterIcon from '~/assets/icons/twitter.svg';
import ClipboardIcon from '~/assets/icons/clipboard.svg';
import CheckIcon from '~/assets/icons/check.svg';

export default {
  name: 'Post',
  components: {
    FacebookIcon,
    TwitterIcon,
    ClipboardIcon,
    CheckIcon,
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
  },
  data() {
    return {
      isClipboardAvailable: Boolean(navigator.clipboard),
      copySuccess: false,
    };
  },
  mounted() {
    this.observer.observe(this.$el);
  },
  methods: {
    capitalize,
    toHTML,
    copyToClipboard() {
      navigator.clipboard
        .writeText(this.postUrl)
        .then(() => {
          this.copySuccess = true;

          setTimeout(() => {
            this.copySuccess = false;
          }, 5000);
        })
        .catch(console.error);
    },
  },
  computed: {
    postUrl() {
      return `${this.$static.metadata.siteUrl}/blog/${this.slug}`;
    },
    twitterUrl() {
      const hashtags = this.characters
        .map((c) => c.name)
        .map((n) => n.replace(/\s/g, ''))
        .map((n) => encodeURIComponent(n))
        .join(',');
      const text = encodeURIComponent(`¡Échenle un ojo a "${this.title}"! Por ${this.$static.metadata.author} en `);

      return `https://twitter.com/share?url=${this.postUrl}&text=${text}&hashtags=${hashtags}`;
    },
    facebookUrl() {
      return `https://facebook.com/sharer.php?u=${this.postUrl}`;
    },
  },
};
</script>

<style>
article {
  scroll-margin-top: 5rem;
}
</style>
