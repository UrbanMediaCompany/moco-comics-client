<template>
  <article class="max-w-3xl mx-auto relative py-4 first:mt-6">
    <div class="flex flex-row justify-between">
      <g-image :src="gravatar" class="relative w-16 h-16 rounded-full mr-4 md:mr-8" alt="" />

      <div class="flex-1 grid grid-cols-2">
        <header>
          <h3 class="font-display text-sm mb-0">{{ author }}</h3>
          <time :datetime="publishedDate" class="block font-display text-grey-400 text-sm mb-4">{{
            capitalize(formattedPublishedDate)
          }}</time>
        </header>

        <p class="col-span-2 text-sm mb-4 text-grey-700">{{ content }}</p>

        <button
          @click="onReplyButtonClick"
          type="button"
          class="row-start-3 col-start-2 place-self-end flex flex-nowrap items-center font-display text-grey-400 text-sm hover:text-mc-red transition-colors duration-100 xs:row-start-1 xs:self-center"
        >
          <ReplyIcon class="w-8 h-8" />

          <span class="ml-4">Responder</span>
        </button>
      </div>
    </div>

    <!-- Replies -->
    <section class="pl-2" v-if="filteredReplies.length">
      <article
        v-for="reply in filteredReplies"
        class="is-reply relative flex flex-row justify-between py-6"
        :key="reply.id"
      >
        <g-image :src="reply.gravatar" class="relative w-12 h-12 rounded-full mr-12 md:mr-24 lg:mr-24" alt="" />

        <div class="flex-1">
          <header>
            <h3 class="font-display text-sm mb-0">{{ reply.author }}</h3>
            <time :datetime="reply.publishedDate" class="block font-display text-grey-400 text-sm mb-4">{{
              capitalize(reply.formattedPublishedDate)
            }}</time>
          </header>

          <p class="text-sm mb-4 text-grey-700">{{ reply.content }}</p>
        </div>
      </article>
    </section>
  </article>
</template>

<script>
import capitalize from '~/utils/capitalize';
import ReplyIcon from '~/assets/icons/corner-up-left.svg';

export default {
  name: 'Comment',
  components: {
    ReplyIcon,
  },
  props: {
    id: String,
    gravatar: String,
    author: String,
    publishedDate: String,
    formattedPublishedDate: String,
    content: String,
    replies: Array,
  },
  computed: {
    filteredReplies() {
      return this.replies.filter(Boolean);
    },
  },
  methods: {
    capitalize,
    onReplyButtonClick() {
      this.$emit('reply-button-click', this.id);
    },
  },
};
</script>

<style scoped>
article:not(.is-reply)::before {
  content: '';
  position: absolute;
  top: 10%;
  bottom: 0;
  left: calc(2rem - 1.5px);
  width: 3px;
  height: 90%;
  background-color: var(--mc-color-grey);
}
</style>
