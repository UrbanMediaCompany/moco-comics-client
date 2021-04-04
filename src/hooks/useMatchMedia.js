import { useEffect, useState } from 'react';

const useMatchMedia = (media) => {
  const [matches, setMatches] = useState();

  const mediaListener = ({ matches }) => {
    setMatches(matches);
  };

  useEffect(() => {
    if (typeof window === 'undefined') return;

    const mq = window.matchMedia(media);
    setMatches(mq.matches);

    mq.addEventListener('change', mediaListener);

    return () => mq.removeEventListener('change', mediaListener);
  }, [media]);

  return matches;
};

export default useMatchMedia;
