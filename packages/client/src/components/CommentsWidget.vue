<template>
  <div class="px-6 pb-8">
    <!-- Comments banner -->
    <div
      class="flex flex-col items-center md:flex-row md:items-center md:justify-evenly bg-mc-blue pt-6 pb-4 px-4 rounded-lg md:py-6"
    >
      <div class="flex flex-nowrap justify-between items-start mb-6 md:mb-0">
        <g-image src="~/assets/images/juanele-cartoon.png" alt="" class="w-16 rounded-full bg-white mr-6" />

        <p class="font-display text-white mx-3 text-sm max-w-lg">
          ¿Te gustó? ¿Te encantó? ¿Quieres comprarlos todos? ¡Díme que opinas!
        </p>
      </div>

      <button
        type="button"
        class="self-end flex flex-nowrap items-center font-display text-white px-4 rounded pb-1 text-sm transform hover:rotate-3 transition-transform duration-200 md:self-auto"
      >
        <CommentIcon class="mr-2 w-8 h-8" />
        <span>Comentar</span>
      </button>
    </div>

    <!-- Actual comments -->
    <section>
      <Comment
        v-for="comment in topLevelComments"
        v-bind="comment"
        :replies="comment.replies.edges"
        :key="comment.id"
      />
    </section>
  </div>
</template>

<script>
import CommentIcon from '~/assets/icons/message-circle.svg';
import Comment from './Comment';

export default {
  name: 'CommentsWidget',
  components: {
    CommentIcon,
    Comment,
  },
  props: {
    comments: Array,
  },
  computed: {
    topLevelComments() {
      return this.comments.map(({ node: comment }) => (comment.parent === null ? comment : null)).filter(Boolean);
    },
  },
};
</script>
