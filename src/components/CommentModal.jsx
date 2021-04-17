import React from 'react';
import { createPortal } from 'react-dom';
import PropTypes from 'prop-types';
import CloseIcon from '../assets/icons/x.svg';
import ReplyIcon from '../assets/icons/corner-up-left.svg';
import { GatsbyImage } from 'gatsby-plugin-image';
import useVisitor from '../hooks/useVistor';
import VisitorForm from './VisitorForm';
import CommentForm from './CommentForm';
import encodeFormData from '../utils/encodeFormData';

const CommentModal = ({ presentationContext, dismiss, onCommentCreated }) => {
  const { visitor, setVisitor, forgetVisitor } = useVisitor();

  // Placeholder for the Netlify post-processing bots
  if (!presentationContext)
    return (
      <form method="POST" name="new-comment" data-netlify="true" hidden>
        <input type="hidden" name="form-name" value="new-comment" />
        <input type="text" name="name" />
        <input type="email" name="email" />
        <input type="website" name="website" />
        <textarea name="comment"></textarea>
        <input type="number" name="post" />
      </form>
    );

  const { post, comment: parent } = presentationContext;

  const submitComment = (comment) => {
    const body = {
      ...comment,
      ...visitor,
      post: post.id,
    };

    if (parent) body.replies_to = parent.id;

    fetch('/', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: encodeFormData(body),
    })
      .then(async (response) => {
        const data = await response.json();

        if (response.ok && data) onCommentCreated(data.comment);
      })
      .catch(dismiss);
  };

  return createPortal(
    <div className="bg-black bg-opacity-50 fixed top-0 bottom-0 left-0 right-0 z-20">
      <div className="absolute bottom-0 left-2/4 w-full max-w-4xl bg-white rounded-tl-xl rounded-tr-xl pb-sa-3 bg-mc-grey transform -translate-x-2/4 md:bottom-auto md:top-2/4 md:-translate-y-2/4 md:rounded-xl md:shadow-md">
        <button
          onClick={dismiss}
          type="button"
          className="absolute -top-20 right-3 font-display text-xs bg-white p-2 rounded-full webkit-mask-image"
        >
          <CloseIcon className="text-mc-blue" />
        </button>

        <div
          className={`flex flex-nowrap items-center bg-mc-blue px-6 py-4 overflow-hidden text-white rounded-tl-xl rounded-tr-xl border-b-8 border-grey-300 ${
            !visitor ? 'items-end' : ''
          }`}
        >
          {post.media?.length ? (
            <GatsbyImage
              image={post.media[0].localFile.childImageSharp.gatsbyImageData}
              alt=""
              className="inline-block rounded-tl-md rounded-tr-md min-w-28 w-28 h-28 object-cover mr-8 border-2 border-white transform -rotate-6 -mb-8 md:min-w-40 md:w-40 md:h-40"
            />
          ) : null}

          <div className="w-full pr-8">
            <p className="flex flex-nowrap items-center font-display text-black text-sm opacity-70 w-full truncate">
              <ReplyIcon className="w-6 h-6 mr-2" />

              <span>{parent ? '¡Pelea, Pelea, Pel...! ah no verdá?' : '¿Qué te pareció esta tira?'}</span>
            </p>

            <p className="w-10/12 font-display truncate leading-snug">
              <span>{!parent ? post.title : `RE: ${parent.author} ${parent.content}`}</span>
            </p>

            {!visitor ? null : (
              <p className="text-sm">
                ¡Tanto tiempo {visitor.name}!
                <button onClick={forgetVisitor} type="button" className="underline ml-2 xs:inline">
                  ¡No soy yo!
                </button>
              </p>
            )}
          </div>
        </div>

        {/* <CommentForm v-if="hasIdentified" onSubmit={submitComment} /> */}

        {!visitor ? <VisitorForm onIdentified={setVisitor} /> : <CommentForm onCommentSubmit={submitComment} />}
      </div>
    </div>,
    document.body,
  );
};

CommentModal.propTypes = {
  presentationContext: PropTypes.shape({
    post: PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
      title: PropTypes.string.isRequired,
      slug: PropTypes.string.isRequired,
      content: PropTypes.string.isRequired,
      publishedDate: PropTypes.string.isRequired,
      formattedPublishedDate: PropTypes.string.isRequired,
      media: PropTypes.arrayOf(
        PropTypes.shape({
          localFile: PropTypes.shape({
            id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
            childImageSharp: PropTypes.shape({
              gatsbyImageData: PropTypes.object.isRequired,
            }).isRequired,
          }).isRequired,
        }),
      ),
      characters: PropTypes.arrayOf(
        PropTypes.shape({
          id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
          name: PropTypes.string.isRequired,
        }),
      ),
    }).isRequired,
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
    }),
  }),
  dismiss: PropTypes.func.isRequired,
  onCommentCreated: PropTypes.func.isRequired,
};

CommentModal.defaultProps = {
  presentationContext: null,
};

export default CommentModal;
