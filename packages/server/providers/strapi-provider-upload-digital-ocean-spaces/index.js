const AWS = require('aws-sdk');

const resolveFileType = (ext) => {
  if (['.jpg', '.png', '.gif', '.svg', '.tiff', '.ico', '.dvu'].includes(ext)) return 'image';

  if (['.mpeg', '.mp4', '.qt', '.wmv', '.avi', '.flv'].includes(ext)) return 'video';

  return 'file';
};

module.exports = {
  init({ s3Config, customKey }) {
    const S3 = new AWS.S3({
      apiVersion: '2006-03-01',
      ...s3Config,
    });

    return {
      upload: (file) =>
        new Promise((resolve, reject) => {
          const path = file.path ? `${file.path}/` : '';

          S3.upload(
            {
              Key:
                customKey && typeof customKey === 'function'
                  ? customKey({ ...file, path, type: resolveFileType(file.ext) })
                  : `${path}${file.hash}${file.ext}`,
              Body: Buffer.from(file.buffer, 'binary'),
              ACL: 'public-read',
              ContentType: file.mime,
            },
            (error, data) => {
              if (error) return reject(error);

              // set the bucket file url
              // eslint-disable-next-line no-param-reassign
              file.url = data.Location;
              return resolve();
            },
          );
        }),

      delete: (file) =>
        new Promise((resolve, reject) => {
          const path = file.path ? `${file.path}/` : '';

          S3.deleteObject(
            {
              Key:
                customKey && typeof customKey === 'function'
                  ? customKey({ ...file, path, type: resolveFileType(file.ext) })
                  : `${path}${file.hash}${file.ext}`,
            },
            (error) => {
              if (error) return reject(error);

              return resolve();
            },
          );
        }),
    };
  },
};
