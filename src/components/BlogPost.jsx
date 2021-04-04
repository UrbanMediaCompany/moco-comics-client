import React, { useEffect } from 'react';
import PropTypes from 'prop-types';
import { GatsbyImage } from 'gatsby-plugin-image';
import { useInView } from 'react-intersection-observer';
import capitalize from '../utils/capitalize';
import markdownToHtml from '../utils/markdownToHtml';
import ShareButtons from './ShareButtons';
import CommentsList from './CommentsList';

const BlogPost = ({ post, comments, onIntersection, onCommentClick, className }) => {
  const { ref, inView } = useInView({ threshold: 0.6 });

  useEffect(() => {
    if (!inView) return;

    onIntersection();
  }, [inView, onIntersection]);

  return (
    <article
      className={`flex flex-nowrap flex-col items-center ${className}`}
      data-uuid={post.id}
      id={post.slug}
      ref={ref}
    >
      {post.media?.map(({ localFile: image }) => (
        <div className="px-6 mb-8" key={image.id}>
          <GatsbyImage
            image={image.childImageSharp.gatsbyImageData}
            alt=""
            className="w-full max-w-5xl border-4 mx-auto border-black"
          />
        </div>
      ))}

      <div className="w-full bg-white border-t-10 border-grey-300 rounded-lg shadow-sm overflow-hidden">
        <header className="px-8 pt-8 mb-8">
          <h2 className="font-display text-lg">{post.title}</h2>
          <time dateTime={post.publishedDate} className="font-display text-grey-400">
            {capitalize(post.formattedPublishedDate)}
          </time>
        </header>

        <section
          dangerouslySetInnerHTML={{ __html: markdownToHtml(post.content) }}
          className="rich-text text-gray-800 px-8 pb-8"
        ></section>

        <ShareButtons slug={post.slug} title={post.title} characters={post.characters} />

        <CommentsList
          comments={comments}
          onNewCommentClick={() => onCommentClick({ post })}
          onReplyClick={(comment) => onCommentClick({ post, comment })}
        />
      </div>
    </article>
  );
};

BlogPost.propTypes = {
  onIntersection: PropTypes.func.isRequired,
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
  onCommentClick: PropTypes.func.isRequired,
  className: PropTypes.string,
};

BlogPost.defaultProps = {
  className: '',
};

export default BlogPost;
