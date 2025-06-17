import { Router } from 'express'
import knex from './../database/knex/index'

const routes = Router();

routes.get('/', async (req, res) => {
  try {
    const evento = await knex('evento').select('*');
    res.json(evento);
  } catch (error) {
    res.status(500).json({ mensagem: 'Erro ao buscar eventos' });
  }
});


export default routes