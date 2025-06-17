/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
  return knex.schema.createTable("palestrante", (table) => {
    table.increments("palestrante_id").primary();
    table.string("nome").notNullable();
    table.integer('evento_id').unsigned().notNullable()
           .references('evento_id').inTable('evento'); // Corrigido para evento_id
  });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTable("palestrante");
};
