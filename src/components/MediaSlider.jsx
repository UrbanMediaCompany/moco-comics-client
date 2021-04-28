import React, { useState } from 'react';
import { GatsbyImage } from 'gatsby-plugin-image';
import ChevronLeft from '../assets/icons/chevron-left.svg';
import ChevronRight from '../assets/icons/chevron-right.svg';

const MediaSlider = ({ media }) => {
  const [activeImage, setActiveImage] = useState(0);

  if (!media) return null;

  return (
    <div className="relative">
      {media.map(({ localFile: image }, index) => (
        <div
          className={`top-0 left-0 px-6 mb-8 flex justify-center items-center ${
            activeImage === index ? 'static' : 'absolute opacity-0'
          } `}
          key={image.id}
        >
          <GatsbyImage
            image={image.childImageSharp.gatsbyImageData}
            alt=""
            className="w-full max-w-5xl border-4 mx-auto border-black"
          />
        </div>
      ))}

      {media.length === 1 ? null : (
        <nav className="flex flex-row justify-end items-center pb-12 -mt-16" aria-label="Imagenes de esta publicación">
          <button
            className="inline-block bg-mc-red text-white p-2 border-b-4 border-r-4 rounded-full border-mc-red-500 transform rotate-6 scale-125 xl:scale-150 hover:-rotate-6 duration-300 disabled:cursor-not-allowed disabled:text-mc-red-500"
            aria-label="Imagen anterior"
            onClick={() => setActiveImage(activeImage - 1)}
            disabled={activeImage === 0}
          >
            <ChevronLeft />
          </button>

          <button
            className="inline-block bg-mc-red text-white p-2 border-b-4 border-l-4 rounded-full border-mc-red-500 ml-5 xl:ml-10 transform -rotate-6 scale-125 xl:scale-150 hover:-rotate-12 duration-300 disabled:cursor-not-allowed disabled:text-mc-red-500"
            aria-label="Siguiente imagen"
            onClick={() => setActiveImage(activeImage + 1)}
            disabled={activeImage === media.length - 1}
          >
            <ChevronRight />
          </button>
        </nav>
      )}
    </div>
  );
};

export default MediaSlider;
