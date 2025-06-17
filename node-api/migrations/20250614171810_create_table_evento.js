/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable("evento", (table => {
        table.increments("evento_id").primary();
        table.string("nome").notNull();
        table.string("descricao").notNull()
        table.date("data").notNull();
    }))
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.dropTable("evento");

};
