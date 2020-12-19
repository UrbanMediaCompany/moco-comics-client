<template>
  <article class="flex flex-col flex-nowrap items-center">
    <div v-for="image in media" :key="image.id" class="px-3 mb-3">
      <g-image :src="image.url" class="w-full max-w-xl border-4 border-black" />
    </div>

    <div class="bg-white p-4 border-t-8 border-mc-grey-300 rounded-lg shadow-sm">
      <header class="mb-8">
        <h2 class="font-display text-3xl mb-2">{{ title }}</h2>
        <time :datetime="publishedDate" class="font-display text-mc-grey-400">{{
          capitalize(formattedPublishedDate)
        }}</time>
      </header>

      <section v-html="toHTML(content)" class="text-gray-800"></section>
    </div>
  </article>
</template>

<script>
import capitalize from '~/utils/capitalize';
import toHTML from '~/utils/toHTML';

export default {
  name: 'Post',
  props: {
    id: String,
    title: String,
    publishedDate: String,
    formattedPublishedDate: String,
    content: String,
    media: Array,
  },
  methods: { capitalize, toHTML },
};
</script>
