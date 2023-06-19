import React from 'react';
import { Helmet } from 'react-helmet';
import '@fontsource/assistant';
import '@fontsource/paytone-one/400.css';
import '@fontsource/luckiest-guy/400.css';
import './src/styles/tailwind.css';

export const wrapRootElement = ({ element }) => {
  return (
    <>
      <Helmet>
        <script async defer data-domain="moco-comics.com" src="https://stats.moco-comics.com/js/index.js"></script>
        <script src="https://cdn.usefathom.com/script.js" data-site="MUJFEEBC" defer></script>
      </Helmet>

      {element}
    </>
  );
};
