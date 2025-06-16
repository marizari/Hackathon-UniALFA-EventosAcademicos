/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
  return knex.schema.createTable("alunos", (table => {
    table.increments("id").primary();
    table.string("name").notNull();
    table.string("email").notNull()
    table.integer("cpf").notNull();
    table.string("password").notNullable(); 
    table.integer('evento_id').unsigned().references('id').inTable('eventos');

  }))
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
  return knex.schema.dropTable("alunos");
};