/* eslint-disable max-len */
const { parseMultipartData, sanitizeEntity } = require('strapi-utils');

module.exports = {
  async create(ctx) {
    let entity;

    if (ctx.is('multipart')) {
      const { data, files } = parseMultipartData(ctx);
      entity = await strapi.services.comment.create(data, { files });
    } else {
      entity = await strapi.services.comment.create(ctx.request.body);
    }

    entity = sanitizeEntity(entity, { model: strapi.models.comment });

    const {
      author,
      email,
      content,
      post: { title, slug },
    } = entity;

    // We don't want to receive emails about our own comments
    if (email === process.env.EDITOR_EMAIL_ADDRESS) return entity;

    await strapi.plugins.email.services.email.send({
      to: process.env.FORWARD_EMAIL_ADDRESS,
      subject: `¡Nuevo comentario en ${title}!`,
      text: `
      ${author} acaba de comentar en el post ${title}:

      > ${content}

      Para responder visita https://moco-comics.com/blog/${slug}
      `,
      html: `
      <p>${author} acaba de comentar en el post ${title}:</p>

      <br />
      
      <blockquote>> <i>${content}</i></blockquote>
      
      <br />

      <p>Para responder visita <a href="https://moco-comics.com/blog/${slug}">https://moco-comics.com/blog/${slug}</a></p>
      `,
    });

    return entity;
  },
};
