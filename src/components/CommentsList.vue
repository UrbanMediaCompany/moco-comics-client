<template>
  <div class="px-6 pb-8">
    <!-- Comments banner -->
    <div
      class="flex flex-col items-center md:flex-row md:items-center md:justify-evenly bg-mc-blue pt-6 pb-4 px-4 rounded-lg relative md:py-6"
    >
      <div class="flex flex-nowrap justify-between items-start mb-6 md:mb-0">
        <g-image src="~/assets/images/juanele-cartoon.png" alt="" class="w-16 rounded-full bg-white mr-6" />

        <p class="font-display text-white mx-3 text-sm max-w-lg">
          ¿Te gustó? ¿Te encantó? ¿Quieres comprarlos todos? ¡Díme que opinas!
        </p>
      </div>

      <button
        @click="showCommentModal"
        type="button"
        class="self-end flex flex-nowrap items-center font-display text-white px-4 rounded pb-1 text-sm transform hover:rotate-3 transition-transform duration-200 md:self-auto"
      >
        <CommentIcon class="mr-2 w-8 h-8" />
        <span>Comentar</span>
      </button>
    </div>

    <!-- Comments list -->
    <section>
      <Comment
        v-for="comment in topLevelComments"
        v-bind="comment"
        :key="comment.id"
        @reply-button-click="showReplyModal"
      />
    </section>

    <NewCommentModal
      :is-showing="showNewCommentModal"
      :post="post"
      :replies-to="commentToReply"
      @dismiss="handleModalDismiss"
      @comment-created="handleNewComment"
    />
  </div>
</template>

<script>
/* eslint-disable camelcase */
import CommentIcon from '~/assets/icons/message-circle.svg';
import Comment from './Comment';
import NewCommentModal from './NewCommentModal';

export default {
  name: 'CommentsList',
  components: {
    CommentIcon,
    Comment,
    NewCommentModal,
  },
  props: {
    post: {
      type: Object,
      required: true,
    },
    comments: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      showNewCommentModal: false,
      commentToReply: null,
      normalizedComments: {}, // { [ID]: {...Comment, replies: [ID] } }
    };
  },
  created() {
    this.normalizedComments = this.comments.edges
      .map(({ node: comment }) => {
        const replies = comment.replies.edges.map(({ node: reply }) => reply.id);

        return { ...comment, replies };
      })
      .reduce((acc, comment) => {
        acc[comment.id] = comment;
        return acc;
      }, {});
  },
  computed: {
    // [{...Comment, replies: [Comment] } ]
    topLevelComments() {
      return Object.values(this.normalizedComments)
        .filter((comment) => !comment.replies_to)
        .map((comment) => ({
          ...comment,
          replies: comment.replies.map((reply) => this.normalizedComments[reply]),
        }));
    },
  },
  methods: {
    showReplyModal(id) {
      this.commentToReply = this.normalizedComments[id];
      this.showNewCommentModal = true;
    },
    showCommentModal() {
      this.showNewCommentModal = true;
    },
    handleModalDismiss() {
      this.commentToReply = null;
      this.showNewCommentModal = false;
    },
    handleNewComment({ comment: { id, author, gravatar, content, published_at: publishedDate, replies_to } }) {
      const newComment = {
        id: String(id),
        author,
        gravatar,
        content,
        publishedDate,
        formattedPublishedDate: 'Justo ahora',
        replies_to: replies_to?.id ?? null,
        replies: [],
      };

      if (!newComment.replies_to) {
        this.normalizedComments = { ...this.normalizedComments, [newComment.id]: newComment };
        return;
      }

      // eslint-disable-next-line eqeqeq
      const parent = Object.values(this.normalizedComments).find((c) => c.id == newComment.replies_to);
      this.normalizedComments = {
        ...this.normalizedComments,
        [parent.id]: { ...parent, replies: [...parent.replies, newComment.id] },
        [newComment.id]: newComment,
      };
    },
  },
};
</script>
