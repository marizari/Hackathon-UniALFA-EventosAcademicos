const path = require('path');

module.exports = {
  development: {
    client: 'mysql2',
    connection: {
      database: 'eventosunialfa',
      user: 'root',
      password: ''
    },
    pool: { min: 2, max: 10 },
    migrations: {
      tableName: 'knex_migrations',
      directory: path.resolve(__dirname, 'migration')

    }
  }
};

// fazendo a conexão com o banco


