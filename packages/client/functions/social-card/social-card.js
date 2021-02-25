const { readFileSync } = require('fs');
const fetch = require('node-fetch');
const chrome = require('chrome-aws-lambda');
const puppeteer = require('puppeteer-core');

const template = readFileSync(`${__dirname}/template.html`).toString();
const executablePath = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const isDev = process.env.URL.includes('localhost');

const getImageDataURL = async (resource) => {
  const response = await fetch(resource);
  const ab = await response.arrayBuffer();

  return Buffer.from(ab).toString('base64');
};

const getOptions = async () => {
  return {
    product: 'chrome',
    args: isDev ? [] : chrome.args,
    executablePath: isDev ? executablePath : await chrome.executablePath,
    headless: isDev || chrome.headless,
  };
};

exports.handler = async ({ queryStringParameters: { title, url } }) => {
  const html = template.replace('<% TITLE %>', title).replace('<% IMAGE %>', await getImageDataURL(url));

  const browser = await puppeteer.launch(await getOptions());
  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 669 });
  await page.setContent(html);

  const screenshot = await page.screenshot({ type: 'png' });
  const encodedScreenshot = screenshot.toString('base64');

  await browser.close();

  return {
    statusCode: 200,
    isBase64Encoded: true,
    body: encodedScreenshot,
  };
};
