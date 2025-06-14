const config = require('./../knexfile');

import knex from 'knex';

const connection = knex(config);

export default connection;
