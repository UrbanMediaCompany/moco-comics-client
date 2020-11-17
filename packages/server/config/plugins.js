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
      customKey: ({ name, type }) => `${env('S3_KEY')}/${type}/${name}`,
    },
  },
});
