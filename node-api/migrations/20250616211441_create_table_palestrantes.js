/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
  return knex.schema.createTable("palestrantes", (table => {
    table.increments("id").primary();
    table.string("name").notNull();
    table.string("profissao").notNull();
    table.integer('evento_id').unsigned().references('id').inTable('eventos');
}))
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTable("palestrantes");
};
