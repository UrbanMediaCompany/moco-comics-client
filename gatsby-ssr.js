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
        <script async defer data-domain="moco-comics.com" src="https://plausible.io/js/plausible.js"></script>
      </Helmet>

      {element}
    </>
  );
};
