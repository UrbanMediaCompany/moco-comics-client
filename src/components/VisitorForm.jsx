import React from 'react';
import CommentIcon from '../assets/icons/message-circle.svg';
import { PropTypes } from 'prop-types';

const VisitorForm = ({ onIdentified }) => {
  const handleSubmit = (event) => {
    event.preventDefault();

    const elements = [...event.target.elements];
    const formData = elements.reduce((acc, element) => {
      if (element.name) {
        acc[element.name] = element.type === 'checkbox' ? element.checked : element.value;
      }

      return acc;
    }, {});

    const visitor = { name: formData.name, email: formData.email, website: formData.website };

    onIdentified(visitor, formData.persist);
  };

  return (
    <form onSubmit={handleSubmit} className="flex flex-col items-stretch px-6 pt-10 pb-6">
      <div className="w-full max-w-xl mx-auto mb-4 md:flex flex-nowrap justify-evenly md:max-w-none">
        <label className="block flex-1 cursor-pointer mb-4 md:mr-4">
          <span className="font-display text-sm block mb-2">¿Cómo te llamas?</span>
          <input
            className="w-full px-3 py-1 bg-white focus:bg-clip-padding hover:bg-clip-padding rounded-lg placeholder-opacity-80 border-2 border-mc-grey-500 hover:border-white hover:border-dashed focus:border-dashed hover:border-mc-blue focus:border-mc-blue focus:border-white transition-all duration-200 appearance-none"
            type="text"
            name="name"
            autoComplete="name"
            placeholder="Juanito Pérez"
            autoFocus
            required
          />
        </label>

        <label className="block flex-1 cursor-pointer">
          <span className="font-display text-sm block mb-2">¿Cuál es tu correo?</span>
          <input
            className="w-full px-3 py-1 bg-white focus:bg-clip-padding hover:bg-clip-padding rounded-lg placeholder-opacity-80 border-2 border-mc-grey-500 hover:border-white hover:border-dashed focus:border-dashed hover:border-mc-blue focus:border-mc-blue focus:border-white transition-all duration-200 appearance-none"
            type="email"
            name="email"
            autoComplete="email"
            placeholder="tu@dominio.com"
            required
          />
        </label>
      </div>

      <div className="w-full max-w-xl mx-auto mb-8 md:flex flex-nowrap justify-evenly items-end md:max-w-none">
        <label className="block flex-1 cursor-pointer mb-6 md:mr-4 md:mb-0">
          <span className="font-display text-sm block mb-2">¿Sitio web?</span>
          <input
            className="w-full px-3 py-1 bg-white focus:bg-clip-padding hover:bg-clip-padding rounded-lg placeholder-opacity-80 border-2 border-mc-grey-500 hover:border-white hover:border-dashed focus:border-dashed hover:border-mc-blue focus:border-mc-blue focus:border-white transition-all duration-200 appearance-none"
            type="url"
            name="website"
            autoComplete="url"
            placeholder="https://miblog.com"
          />
        </label>

        <div className="xs:flex-1 md:mb-1">
          <label className="flex flex-nowrap items-center cursor-pointer border-2 border-transparent px-3 py-1 rounded-lg focus-within:border-mc-blue focus-within:border-dashed transition-all duration-200">
            <input
              type="checkbox"
              name="persist"
              value="yes"
              className="checkbox appearance-none w-8 h-8 rounded-lg mr-4 border-2 border-mc-grey-500 bg-white checked:bg-check-mark"
            />
            <span className="flex-1 font-display text-sm leading-none">Recuérdame en este navegador</span>
          </label>
        </div>
      </div>

      <button
        type="submit"
        className="self-center w-full max-w-xl flex flex-nowrap justify-center items-center bg-mc-blue text-white py-2 px-4 rounded-lg font-display text-sm border-2 border-dashed border-transparent focus:border-white transition-colors duration-200 md:mt-8"
      >
        <CommentIcon className="mr-2 w-8 h-8" />
        Ya ¡Lo que sigue!
      </button>
    </form>
  );
};

VisitorForm.propTypes = {
  onIdentified: PropTypes.func.isRequired,
};

export default VisitorForm;
