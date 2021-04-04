import { useState } from 'react';

const useCommentModal = () => {
  const [context, setContext] = useState();

  const present = (context) => setContext(context);
  const dismiss = () => setContext(undefined);

  return [context, present, dismiss];
};

export default useCommentModal;
