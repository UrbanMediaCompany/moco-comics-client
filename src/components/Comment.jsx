import React from 'react';
import PropTypes from 'prop-types';
import capitalize from '../utils/capitalize';
import ReplyIcon from '../assets/icons/corner-up-left.svg';

const Comment = ({ comment, onReplyClick }) => (
  <article className="max-w-3xl mx-auto relative py-4 first:mt-6">
    <div className="flex flex-row justify-between">
      <img src={comment.gravatar} className="relative w-16 h-16 rounded-full mr-4 md:mr-8" alt="" />

      <div className="flex-1 grid grid-cols-2">
        <header>
          <h3 className="font-display text-sm mb-0">{comment.author}</h3>
          <time dateTime={comment.publishedDate} className="block font-display text-grey-400 text-sm mb-4">
            {capitalize(comment.formattedPublishedDate)}
          </time>
        </header>

        <p className="col-span-2 text-sm mb-4 text-grey-700">{comment.content}</p>

        <button
          onClick={() => onReplyClick(comment)}
          type="button"
          className="row-start-3 col-start-2 place-self-end flex flex-nowrap items-center font-display text-grey-400 text-sm hover:text-mc-red transition-colors duration-100 xs:row-start-1 xs:self-center"
        >
          <ReplyIcon className="w-8 h-8" />

          <span className="ml-4">Responder</span>
        </button>
      </div>
    </div>

    {/* Replies */}
    {!comment.replies.length ? null : (
      <section className="pl-2" v-if="filteredReplies.length">
        {comment.replies.map((reply) => (
          <article className="is-reply relative flex flex-row justify-between py-6" key={reply.id}>
            <img src={reply.gravatar} className="relative w-12 h-12 rounded-full mr-12 md:mr-24 lg:mr-24" alt="" />

            <div className="flex-1">
              <header>
                <h3 className="font-display text-sm mb-0">{reply.author}</h3>
                <time dateTime={reply.publishedDate} className="block font-display text-grey-400 text-sm mb-4">
                  {capitalize(reply.formattedPublishedDate)}
                </time>
              </header>

              <p className="text-sm mb-4 text-grey-700">{reply.content}</p>
            </div>
          </article>
        ))}
      </section>
    )}
  </article>
);

Comment.propTypes = {
  comment: PropTypes.shape({
    id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
    author: PropTypes.string,
    gravatar: PropTypes.string,
    content: PropTypes.string.isRequired,
    publishedDate: PropTypes.string.isRequired,
    formattedPublishedDate: PropTypes.string.isRequired,
    replies_to: PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
    }),
    replies: PropTypes.arrayOf(
      PropTypes.shape({
        id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
        author: PropTypes.string,
        gravatar: PropTypes.string,
        content: PropTypes.string.isRequired,
        publishedDate: PropTypes.string.isRequired,
        formattedPublishedDate: PropTypes.string.isRequired,
      }),
    ),
  }),
  onReplyClick: PropTypes.func.isRequired,
};

export default Comment;
