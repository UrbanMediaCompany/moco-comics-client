<template>
  <section class="flex flex-npwrap justify-evenly items-center px-8 pt-8 pb-12 md:justify-end">
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
import FacebookIcon from '~/assets/icons/facebook.svg';
import TwitterIcon from '~/assets/icons/twitter.svg';
import ClipboardIcon from '~/assets/icons/clipboard.svg';
import CheckIcon from '~/assets/icons/check.svg';
import isSSR from '~/utils/isSSR';

export default {
  name: 'ShareButtons',
  components: {
    FacebookIcon,
    TwitterIcon,
    ClipboardIcon,
    CheckIcon,
  },
  props: {
    slug: String,
    characters: Array,
  },
  data() {
    return {
      isClipboardAvailable: !isSSR() && Boolean(navigator.clipboard),
      copySuccess: false,
    };
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
  methods: {
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
};
</script>
