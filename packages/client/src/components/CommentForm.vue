<template>
  <form
    @submit.prevent="submitComment"
    class="flex flex-col items-stretch px-6 pt-8 pb-6"
    name="new-comment"
    method="POST"
    data-netlify="true"
  >
    <input type="hidden" name="form-name" value="new-comment" />

    <textarea
      class="w-full max-w-xl min-h-40 mx-auto px-3 py-1 bg-white focus:bg-clip-padding hover:bg-clip-padding rounded-lg placeholder-opacity-80 border-2 border-mc-grey-500 hover:border-white hover:border-dashed focus:border-dashed hover:border-mc-blue focus:border-mc-blue focus:border-white transition-all duration-200 appearance-none resize-y mb-12 md:max-w-none md:mb-6"
      name="content"
      v-model="comment"
      placeholder="Estimado Sr. Juanele..."
      autofocus
      required
    ></textarea>

    <button
      type="submit"
      class="self-center w-full max-w-xl flex flex-nowrap justify-center items-center bg-mc-blue text-white py-2 px-4 rounded-lg font-display text-sm border-2 border-dashed border-transparent focus:border-white transition-colors duration-200 md:mt-8"
    >
      <CommentIcon class="mr-2 w-8 h-8" />
      ¡Comentar!
    </button>
  </form>
</template>

<script>
import CommentIcon from '~/assets/icons/message-circle.svg';

export default {
  name: 'CommentForm',
  components: {
    CommentIcon,
  },
  data() {
    return {
      comment: '',
    };
  },
  methods: {
    submitComment() {
      this.$emit('submit', this.comment);
    },
  },
};
</script>
