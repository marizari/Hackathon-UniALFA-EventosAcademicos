/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable("eventos", (table => {
        table.increments("id").primary();
        table.string("name").notNull();
        table.string("descricao").notNull()
        table.date("data").notNull();
        table.string("local").notNull();
    }))
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.dropTable("eventos");

};
