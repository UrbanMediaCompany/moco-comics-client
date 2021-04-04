const loadPayPalSDK = () => {
  return new Promise((resolve, reject) => {
    if (typeof window === 'undefined') {
      reject(new Error('"window" is not defined.'));
      return;
    }

    const script = document.createElement('script');
    script.type = 'text/javascript';
    script.async = true;
    script.src = `https://www.paypal.com/sdk/js?client-id=${process.env.GATSBY_PAYPAL_CLIENT_ID}&currency=MXN`;

    script.addEventListener('error', reject);
    script.addEventListener('load', () => {
      resolve();
    });

    document.head.appendChild(script);
  });
};

export default loadPayPalSDK;
