import showdown from 'showdown';

const converter = new showdown.Converter();

const toHTML = (markdown) => converter.makeHtml(markdown);

export default toHTML;
