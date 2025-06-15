import { Router } from 'express'
import knex from './../database/knex/index'

const routes = Router();

routes.get('/', async (req, res) => {
  try {
    const eventos = await knex('eventos').select('*');
    res.json(eventos);
  } catch (error) {
    res.status(500).json({ mensagem: 'Erro ao buscar eventos' });
  }
});


export default routes