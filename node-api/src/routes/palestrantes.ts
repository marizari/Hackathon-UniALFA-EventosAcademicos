import { Router } from 'express'
import knex from './../database/knex/index'

const routes = Router();

routes.get('/palestrantes/:id', async (req, res) => {
  const palestranteId = req.params.id;

  try {
    const palestrante = await knex('palestrantes').where({ id: palestranteId }).first();

    if (!palestrante) {
     res.status(404).json({ mensagem: 'Palestrante não encontrado' });
    }

    res.json({ palestrante });
  } catch (error) {
    console.error('Erro ao buscar palestrante:', error);
    res.status(500).json({ erro: 'Erro interno no servidor' });
  }
});

export default routes