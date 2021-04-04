import React from 'react';
import CommentIcon from '../assets/icons/message-circle.svg';
import { PropTypes } from 'prop-types';

const CommentForm = ({ onCommentSubmit }) => {
  const handleSubmit = (event) => {
    event.preventDefault();

    const elements = [...event.target.elements];
    const formData = elements.reduce((acc, element) => {
      if (element.name) acc[element.name] = element.value;

      return acc;
    }, {});

    onCommentSubmit(formData);
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="flex flex-col items-stretch px-6 pt-8 pb-6"
      name="new-comment"
      method="POST"
      data-netlify="true"
    >
      <input type="hidden" name="form-name" value="new-comment" />

      <textarea
        className="w-full max-w-xl min-h-40 mx-auto px-3 py-1 bg-white focus:bg-clip-padding hover:bg-clip-padding rounded-lg placeholder-opacity-80 border-2 border-mc-grey-500 hover:border-white hover:border-dashed focus:border-dashed hover:border-mc-blue focus:border-mc-blue focus:border-white transition-all duration-200 appearance-none resize-y mb-12 md:max-w-none md:mb-6"
        name="comment"
        placeholder="Estimado Sr. Juanele..."
        autoFocus
        required
      ></textarea>

      <button
        type="submit"
        className="self-center w-full max-w-xl flex flex-nowrap justify-center items-center bg-mc-blue text-white py-2 px-4 rounded-lg font-display text-sm border-2 border-dashed border-transparent focus:border-white transition-colors duration-200 md:mt-8"
      >
        <CommentIcon className="mr-2 w-8 h-8" />
        ¡Comentar!
      </button>
    </form>
  );
};

CommentForm.propTypes = {
  onCommentSubmit: PropTypes.func.isRequired,
};

export default CommentForm;
