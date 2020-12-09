const mysql = require('mysql');
const fs = require('fs');

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'moco_comics',
});

connection.connect((error) => console.log('[ERROR]', error));

connection.query('SELECT * FROM Characters', (error, result, fields) => {
  fs.writeFile('db/original/categories.json', JSON.stringify(result), (error) => console.log);
});

connection.query('SELECT * FROM Products', (error, result, fields) => {
  fs.writeFile('db/original/products.json', JSON.stringify(result), (error) => console.log);
});

connection.query('SELECT * FROM Comments', (error, result, fields) => {
  fs.writeFile('db/original/comments.json', JSON.stringify(result), (error) => console.log);
});

connection.query('SELECT * FROM Posts', (error, result, fields) => {
  fs.writeFile('db/original/posts.json', JSON.stringify(result), (error) => console.log);
});

connection.end();
