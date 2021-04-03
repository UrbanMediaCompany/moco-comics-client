import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { StaticImage, GatsbyImage } from 'gatsby-plugin-image';
import { graphql, Link } from 'gatsby';
import Layout from '../components/Layout';
import ChevronLeft from '../assets/icons/chevron-left.svg';
import ChevronRight from '../assets/icons/chevron-right.svg';
import * as styles from './PaginatedBlog.module.css';
import BlogPost from '../components/BlogPost';

const normalizeComments = (comments) => {
  return comments
    .map(({ node }) => node)
    .reduce((acc, comment) => {
      const key = comment.post.id;

      return { ...acc, [key]: acc[key] ? [...acc[key], comment] : [comment] };
    }, {});
};

const PaginatedBlog = ({
  pageContext: { totalPages, currentPage, nextPage, previousPage },
  data: {
    allStrapiPost: { edges: posts },
    allStrapiComment,
  },
}) => {
  const [observedPost, setObservedPost] = useState(null);
  const [comments, setComments] = useState(normalizeComments(allStrapiComment.edges));

  const handleCommentRequest = () => {};

  return (
    <Layout>
      <header
        className={`${styles.hero} relative w-full bg-mc-yellow pt-28 pb-32 px-constrained text-center overflow-hidden md:pt-44`}
      >
        <div className="flex flex-nowrap justify-evenly items-center relative mb-12 max-w-7xl mx-auto">
          <div className="hidden flex-col flex-nowrap items-center pt-6 md:flex">
            <div className="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
              <StaticImage src="../assets/images/chocolomo.png" alt="" loading="eager" />
            </div>
            <p className="font-cartoon text-white">Chocolomo</p>
          </div>

          <div className="flex flex-col flex-nowrap items-center pt-6">
            <div className="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
              <StaticImage src="../assets/images/patote.png" alt="" loading="eager" />
            </div>
            <p className="font-cartoon text-white">Patote</p>
          </div>

          <div className="w-60 rounded-full border-6 border-white mx-3 overflow-hidden">
            <StaticImage src="../assets/images/juanele-cartoon.png" alt="" loading="eager" />
          </div>

          <div className="flex flex-col flex-nowrap items-center pt-6">
            <div className="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
              <StaticImage src="../assets/images/cuco.png" alt="" loading="eager" />
            </div>
            <p className="font-cartoon text-white">Cuco</p>
          </div>

          <div className="hidden flex-col flex-nowrap items-center pt-6 md:flex">
            <div className="w-40 rounded-full border-6 border-white overflow-hidden mb-4">
              <StaticImage src="../assets/images/abuela.png" alt="" loading="eager" />
            </div>
            <p className="font-cartoon text-white">Abuela</p>
          </div>
        </div>

        <h1 className={`${styles.title} font-display opacity-95 uppercase text-white text-4xl leading-none mb-12`}>
          Moco-Comics
        </h1>
        <p className="font-cartoon opacity-90 text-white text-lg">Monitos de Juanele</p>
      </header>

      <main className="px-constrained -mt-20 md:pb-64">
        <section className="grid grid-cols-1 gap-36 pb-20 relative">
          {posts.map(({ node: post }) => (
            <BlogPost
              post={post}
              comments={comments[post.id] || []}
              onCommentClick={handleCommentRequest}
              onIntersection={() => setObservedPost(post.id)}
              className="md:col-start-1"
              key={post.id}
            />
          ))}
        </section>

        <aside className="pb-48 md:sticky md:-top-4 md:h-min">
          <nav className="mb-10">
            <div className="flex flex-row flex-nowrap items-center justify-center md:flex-col">
              <p className="flex justify-center items-center rounded-full bg-mc-red text-white font-cartoon text-center border-b-10 border-mc-red-500 uppercase text-lg p-12 md:p-16">
                Página <br />
                {currentPage} de {totalPages}
              </p>

              <ul className="flex flex-col flex-nowrap max-w-min -ml-4 md:flex-row md:ml-0 md:-mt-16 md:max-w-none md:w-full md:justify-center">
                <li className="mb-4 md:mb-0 md:mr-12">
                  {previousPage ? (
                    <Link
                      to={previousPage}
                      className="inline-block bg-mc-yellow text-white p-2 border-b-4 border-r-4 border-mc-yellow-500 transform rotate-6 scale-125 hover:-rotate-6 duration-300"
                    >
                      <ChevronLeft />
                    </Link>
                  ) : (
                    <span className="inline-block bg-mc-yellow text-mc-yellow-500 p-2 border-b-4 border-r-4 border-mc-yellow-500 transform rotate-6 scale-125 duration-300 cursor-not-allowed">
                      <ChevronLeft />
                    </span>
                  )}
                </li>

                <li>
                  {nextPage ? (
                    <Link
                      to={nextPage}
                      className="inline-block bg-mc-yellow text-white p-2 border-b-4 border-l-4 border-mc-yellow-500 transform -rotate-6 scale-125 hover:-rotate-12 duration-300"
                    >
                      <ChevronRight />
                    </Link>
                  ) : (
                    <span className="inline-block bg-mc-yellow text-mc-yellow-500 p-2 border-b-4 border-r-4 border-mc-yellow-500 transform rotate-6 scale-125 duration-300 cursor-not-allowed">
                      <ChevronRight />
                    </span>
                  )}
                </li>
              </ul>
            </div>

            <ul className="min-w-120 px-8 py-3 bg-white rounded-xl mt-4 shadow-sm">
              {posts.map(({ node: post }) => (
                <li
                  className="font-display text-grey-400 hover:text-black transition-colors py-3 duration-300 border-b-2 border-dotted last:border-0"
                  key={post.id}
                >
                  <a
                    href={`#${post.slug}`}
                    className={`group flex flex-nowrap items-center ${post.id === observedPost ? 'is-active' : ''}`}
                  >
                    {!post.media.length ? null : (
                      <GatsbyImage
                        image={post.media[0].localFile.childImageSharp.thumbnailImageData}
                        alt=""
                        className={`inline-block rounded-md w-16 h-16 object-cover mr-8 border-2 group-hover:border-mc-yellow ${
                          post.id === observedPost ? 'border-mc-yellow' : 'border-grey-400}'
                        }`}
                      />
                    )}

                    <span>{post.title}</span>
                  </a>
                </li>
              ))}
            </ul>
          </nav>

          {/* <SocialsNav /> */}
        </aside>
      </main>
    </Layout>
  );
};

PaginatedBlog.propTypes = {
  pageContext: PropTypes.shape({
    totalPages: PropTypes.number.isRequired,
    currentPage: PropTypes.number.isRequired,
    nextPage: PropTypes.string,
    previousPage: PropTypes.string,
  }).isRequired,

  data: PropTypes.shape({
    allStrapiPost: PropTypes.shape({
      edges: PropTypes.arrayOf(
        PropTypes.shape({
          node: PropTypes.shape({
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
                    thumbnailImageData: PropTypes.object.isRequired,
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
          }),
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

export default PaginatedBlog;

export const query = graphql`
  query PaginatedBlog($postsPerPage: Int!, $skip: Int!, $postsInPage: [Int]!) {
    allStrapiPost(limit: $postsPerPage, skip: $skip, sort: { fields: published_at, order: DESC }) {
      edges {
        node {
          id: strapiId
          title
          slug
          content
          publishedDate: published_at
          formattedPublishedDate: published_at(formatString: "MMMM D, YYYY", locale: "es-MX")
          media {
            localFile {
              id
              childImageSharp {
                thumbnailImageData: gatsbyImageData(
                  placeholder: DOMINANT_COLOR
                  layout: CONSTRAINED
                  width: 80
                  quality: 1
                )
                gatsbyImageData(placeholder: DOMINANT_COLOR, layout: CONSTRAINED, width: 640)
              }
            }
          }
          characters {
            id
            name
          }
        }
      }
    }

    allStrapiComment(filter: { post: { id: { in: $postsInPage } } }) {
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
          post {
            id
          }
        }
      }
    }
  }
`;
