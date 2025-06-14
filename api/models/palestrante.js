'use strict';
const {
  Model
} = require('sequelize');
module.exports = (sequelize, DataTypes) => {
  class Palestrante extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      // define association here
    }
  }
  Palestrante.init({
    nome: DataTypes.STRING,
    minicurriculo: DataTypes.TEXT,
    foto: DataTypes.STRING
  }, {
    sequelize,
    modelName: 'Palestrante',
  });
  return Palestrante;
};