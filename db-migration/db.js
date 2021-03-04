const mysql = require('mysql');

const client = mysql.createConnection('mysql://');

const queryOne = (...params) =>
  new Promise((resolve, reject) => {
    client.query(...params, (error, result) => (error ? reject([error]) : resolve([null, result[0]])));
  });

module.exports = { client, queryOne };
