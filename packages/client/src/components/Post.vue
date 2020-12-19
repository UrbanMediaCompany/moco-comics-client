<template>
  <article class="flex flex-col flex-nowrap items-center">
    <div v-for="image in media" :key="image.id" class="px-6 mb-8">
      <g-image :src="image.url" class="w-full max-w-5xl border-4 border-black" />
    </div>

    <div class="bg-white p-8 border-t-10 border-grey-300 rounded-lg shadow-sm">
      <header class="mb-8">
        <h2 class="font-display text-lg">{{ title }}</h2>
        <time :datetime="publishedDate" class="font-display text-grey-400">{{
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
