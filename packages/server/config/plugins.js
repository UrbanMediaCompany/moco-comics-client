module.exports = ({ env }) => ({
  upload: {
    provider: 'digital-ocean-spaces',
    providerOptions: {
      s3Config: {
        accessKeyId: env('S3_ACCESS_KEY_ID'),
        secretAccessKey: env('S3_ACCESS_SECRET'),
        region: env('S3_REGION'),
        endpoint: env('S3_ENDPOINT'),
        params: {
          Bucket: env('S3_BUCKET'),
        },
      },
      customKey: ({ name, type }) => `${type}/${name}`,
    },
  },
  email: {
    provider: 'mailgun',
    providerOptions: {
      apiKey: env('MAILGUN_API_KEY'),
      domain: env('MAILGUN_DOMAIN'),
      host: env('MAILGUN_HOST', 'api.us.mailgun.net'),
    },
    settings: {
      defaultFrom: env('MAILGUN_FROM_ADDRESS'),
      defaultReplyTo: env('MAILGUN_REPLYTO_ADDRESS'),
    },
  },
});
