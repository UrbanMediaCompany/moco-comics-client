<template>
  <portal to="modal" v-if="isShowing">
    <div class="bg-black bg-opacity-50 fixed top-0 bottom-0 left-0 right-0 z-20">
      <div
        class="absolute bottom-0 left-2/4 w-full max-w-4xl bg-white rounded-tl-xl rounded-tr-xl pb-sa-3 bg-mc-grey transform -translate-x-2/4 md:bottom-auto md:top-2/4 md:-translate-y-2/4 md:rounded-xl md:shadow-md"
      >
        <button
          @click="dismiss"
          type="button"
          class="absolute -top-20 right-3 font-display text-xs bg-white p-2 rounded-full"
        >
          <CloseIcon class="text-mc-blue" />
        </button>

        <div
          class="flex flex-nowrap items-center bg-mc-blue px-6 py-4 overflow-hidden text-white rounded-tl-xl rounded-tr-xl border-b-8 border-grey-300"
          :class="{ 'items-end': hasIdentified }"
        >
          <g-image
            :src="post.media.url"
            alt=""
            class="inline-block rounded-tl-md rounded-tr-md w-28 h-28 object-cover mr-8 border-2 border-white transform -rotate-6 -mb-8 md:w-40 md:h-40"
          />

          <div class="w-full pr-8">
            <p class="flex flex-nowrap items-center font-display text-black text-sm opacity-70 w-full truncate">
              <ReplyIcon class="w-6 h-6 mr-2" />

              <span>{{ repliesTo ? '¡Pelea, Pelea, Pel...! ah no verdá?' : '¿Qué te pareció esta tira?' }}</span>
            </p>

            <p class="w-10/12 font-display truncate leading-snug">
              <span v-if="!repliesTo">{{ post.title }}</span>
              <span v-if="repliesTo">RE: {{ repliesTo.author }} {{ repliesTo.content }}</span>
            </p>

            <p v-if="hasIdentified" class="text-sm">
              ¡Tanto tiempo {{ visitor.name }}!
              <button @click="forgetVisitor" type="button" class="underline ml-2 xs:inline">¡No soy yo!</button>
            </p>
          </div>
        </div>

        <CommentForm v-if="hasIdentified" @submit="submitComment($event)" />

        <VisitorForm v-if="!hasIdentified" @identified-visitor="setVisitor($event)" />
      </div>
    </div>
  </portal>
</template>

<script>
import CloseIcon from '~/assets/icons/x.svg';
import ReplyIcon from '~/assets/icons/corner-up-left.svg';
import VisitorForm from '~/components/VisitorForm.vue';
import CommentForm from '~/components/CommentForm.vue';

export default {
  name: 'NewCommentModal',
  components: {
    CloseIcon,
    ReplyIcon,
    VisitorForm,
    CommentForm,
  },
  props: {
    isShowing: {
      type: Boolean,
      required: true,
    },
    post: {
      type: Object,
      required: true,
    },
    repliesTo: {
      type: Object,
      required: false,
      default: null,
    },
  },
  data() {
    return {
      hasIdentified: false,
      visitor: null,
    };
  },
  created() {
    this.hasIdentified = this.persistedVisitor !== null;
    this.visitor = this.persistedVisitor;
  },
  computed: {
    persistedVisitor() {
      return this.$store.state.persistedVisitor;
    },
  },
  methods: {
    dismiss() {
      this.$emit('dismiss');
    },
    setVisitor(visitor) {
      this.visitor = visitor;
      this.hasIdentified = true;
    },
    forgetVisitor() {
      this.$store.dispatch('forgetVisitor');
      this.visitor = null;
      this.hasIdentified = false;
    },
    encodeFormData(data) {
      return Object.keys(data)
        .map((key) => `${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`)
        .join('&');
    },
    submitComment(comment) {
      const body = {
        'form-name': 'new-comment',
        comment,
        ...this.visitor,
        post: this.post.id,
      };

      if (this.repliesTo) body.replies_to = this.repliesTo.id;

      fetch('/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: this.encodeFormData(body),
      })
        .then(async (response) => {
          const data = await response.json();

          if (response.ok && data) this.$emit('comment-created', data);

          this.$emit('dismiss');
        })
        .catch(() => this.$emit('dismiss'));
    },
  },
};
</script>
