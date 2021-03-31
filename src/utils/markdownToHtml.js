import showdown from 'showdown';

const converter = new showdown.Converter();

const markdownToHtml = (markdown) => converter.makeHtml(markdown);

export default markdownToHtml;
