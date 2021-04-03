import React from 'react';
import { PropTypes } from 'prop-types';
import { StaticImage } from 'gatsby-plugin-image';
import CommentIcon from '../assets/icons/message-circle.svg';
import Comment from './Comment';

const CommentsList = ({ comments, onNewCommentClick, onReplyClick }) => {
  const topLevelComments = comments
    .filter((comment) => !comment.replies_to)
    .map((comment) => ({
      ...comment,
      replies: comments.filter((c) => c.replies_to?.id === comment.id),
    }));

  return (
    <div className="px-6 pb-8">
      {/* Comments banner */}
      <div className="flex flex-col items-center md:flex-row md:items-center md:justify-evenly bg-mc-blue pt-6 pb-4 px-4 rounded-lg relative md:py-6">
        <div className="flex flex-nowrap justify-between items-start mb-6 md:mb-0">
          <StaticImage src="../assets/images/juanele-cartoon.png" alt="" className="w-16 rounded-full bg-white mr-6" />

          <p className="font-display text-white mx-3 text-sm max-w-lg">
            ¿Te gustó? ¿Te encantó? ¿Quieres comprarlos todos? ¡Díme que opinas!
          </p>
        </div>

        <button
          onClick={onNewCommentClick}
          type="button"
          className="self-end flex flex-nowrap items-center font-display text-white px-4 rounded pb-1 text-sm transform hover:rotate-3 transition-transform duration-200 md:self-auto"
        >
          <CommentIcon className="mr-2 w-8 h-8" />
          <span>Comentar</span>
        </button>
      </div>

      {/* Comments list */}
      <section>
        {topLevelComments.map((comment) => (
          <Comment comment={comment} onReplyClick={onReplyClick} key={comment.id} />
        ))}
      </section>
    </div>
  );
};

CommentsList.propTypes = {
  comments: PropTypes.arrayOf(
    PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
      author: PropTypes.string,
      gravatar: PropTypes.string,
      content: PropTypes.string.isRequired,
      publishedDate: PropTypes.string.isRequired,
      formattedPublishedDate: PropTypes.string.isRequired,
      replies_to: PropTypes.shape({
        id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
      }),
    }),
  ).isRequired,
  onNewCommentClick: PropTypes.func.isRequired,
  onReplyClick: PropTypes.func.isRequired,
};

export default CommentsList;
