import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { GatsbyImage } from 'gatsby-plugin-image';
import { graphql } from 'gatsby';
import Layout from '../components/Layout';
import capitalize from '../utils/capitalize';
import ShareButtons from '../components/ShareButtons';
import CommentsList from '../components/CommentsList';
import markdownToHtml from '../utils/markdownToHtml';
import * as styles from './BlogPostDetailPage.module.css';
import useCommentModal from '../hooks/useCommentModal';
import CommentModal from '../components/CommentModal';

const BlogPostDetailPage = ({ data: { strapiPost: post, allStrapiComment } }) => {
  const [comments, setComments] = useState(allStrapiComment.edges.map(({ node }) => node));
  const [commentModalContext, presentModal, dismissModal] = useCommentModal();

  const handleNewComment = (comment) => {
    setComments([...comments, comment]);
    dismissModal();
  };

  return (
    <Layout>
      <header
        className={`${styles.hero} relative w-full min-h-40 bg-mc-yellow pt-28 pb-32 px-constrained text-left overflow-hidden md:pt-44`}
      >
        <div className="flex flex-col flex-nowrap items-center relative mb-12 max-w-7xl mx-auto">
          <h1 className={`${styles.title} font-display opacity-95 text-white text-4xl leading-none mb-8`}>
            {post.title}
          </h1>

          <time dateTime="post.publishedDate" className="font-cartoon opacity-90 text-white text-lg">
            {capitalize(post.formattedPublishedDate)}
          </time>

          <div className="flex flex-nowrap items-center">
            {post.characters.map((character) => (
              <div className="hidden flex-col flex-nowrap items-center pt-6 md:flex mr-4" key={character.id}>
                <div className="w-32 rounded-full border-4 border-white overflow-hidden mb-4">
                  <GatsbyImage image={character.image.localFile.childImageSharp.gatsbyImageData} alt="" />
                </div>
              </div>
            ))}
          </div>
        </div>
      </header>

      <main className={`${styles.main} relative px-constrained -mt-28 pb-28 md:pb-64`}>
        {post.media.map((image) => (
          <section key={image.id} className="px-6 mb-8">
            <GatsbyImage
              image={image.localFile.childImageSharp.gatsbyImageData}
              alt=""
              className="w-full max-w-5xl border-4 mx-auto border-black"
            />
          </section>
        ))}

        <div className="w-full bg-white border-t-10 border-grey-300 rounded-lg shadow-sm overflow-hidden mb-16">
          <section
            dangerouslySetInnerHTML={{ __html: markdownToHtml(post.content) }}
            className={`${styles.richText} text-gray-800 p-8`}
          ></section>

          <ShareButtons slug={post.slug} title={post.title} characters={post.characters} />

          <CommentsList
            comments={comments}
            onNewCommentClick={() => presentModal({ post })}
            onReplyClick={(comment) => presentModal({ post, comment })}
          />
        </div>
      </main>

      <CommentModal
        presentationContext={commentModalContext}
        dismiss={dismissModal}
        onCommentCreated={handleNewComment}
      />
    </Layout>
  );
};

BlogPostDetailPage.propTypes = {
  data: PropTypes.shape({
    strapiPost: PropTypes.shape({
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
          image: PropTypes.shape({
            localFile: PropTypes.shape({
              id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
              childImageSharp: PropTypes.shape({
                gatsbyImageData: PropTypes.object.isRequired,
              }).isRequired,
            }).isRequired,
          }).isRequired,
        }),
      ),
    }).isRequired,

    allStrapiComment: PropTypes.shape({
      edges: PropTypes.arrayOf(
        PropTypes.shape({
          node: PropTypes.shape({
            id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
            author: PropTypes.string,
            gravatar: PropTypes.string,
            content: PropTypes.string.isRequired,
            publishedDate: PropTypes.string.isRequired,
            formattedPublishedDate: PropTypes.string.isRequired,
            replies_to: PropTypes.shape({
              id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
            }),
            post: PropTypes.shape({
              id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
            }),
          }).isRequired,
        }),
      ).isRequired,
    }).isRequired,
  }).isRequired,
};

export default BlogPostDetailPage;

export const query = graphql`
  query BlogPostDetail($id: Int!) {
    strapiPost(strapiId: { eq: $id }) {
      id: strapiId
      title
      slug
      content
      publishedDate: published_at
      formattedPublishedDate: published_at(formatString: "MMMM D, YYYY", locale: "es-MX")
      media {
        id
        localFile {
          id
          childImageSharp {
            gatsbyImageData(placeholder: DOMINANT_COLOR, layout: CONSTRAINED, width: 640)
          }
        }
      }
      characters {
        id
        name
        image {
          id
          localFile {
            id
            childImageSharp {
              gatsbyImageData(placeholder: DOMINANT_COLOR, layout: FIXED, width: 80)
            }
          }
        }
      }
    }

    allStrapiComment(filter: { post: { id: { eq: $id } } }) {
      edges {
        node {
          id: strapiId
          author
          gravatar
          content
          publishedDate: published_at
          formattedPublishedDate: published_at(formatString: "MMMM D, YYYY", locale: "es-MX")
          replies_to {
            id
          }
        }
      }
    }
  }
`;
