import { useState } from 'react';

const useVisitor = () => {
  const [visitor, setVisitor] = useState(() => {
    if (typeof window === 'undefined') return null;

    return JSON.parse(localStorage.getItem('visitor'));
  });

  const persistVisitor = (visitor, persist = false) => {
    if (persist) localStorage.setItem('visitor', JSON.stringify(visitor));
    setVisitor(visitor);
  };

  const forgetVisitor = () => {
    localStorage.removeItem('visitor');
    setVisitor(null);
  };

  return { visitor, setVisitor: persistVisitor, forgetVisitor };
};

export default useVisitor;
