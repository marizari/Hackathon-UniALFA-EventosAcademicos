import { Router } from 'express'
import knex from './../database/knex'

const routes = Router();

// Nova rota para buscar palestrante por evento
routes.get('/evento/:eventoId', async (req, res) => {
  const eventoId = req.params.eventoId;

  try {
    const palestrante = await knex('palestrante')
      .where({ evento_id: eventoId })
      .first();

    if (!palestrante) {
       res.status(404).json({ mensagem: 'Nenhum palestrante encontrado para este evento' });
       return
    }

    res.json([palestrante]); 
  } catch (error) {
    console.error('Erro ao buscar palestrante por evento:', error);
    res.status(500).json({ erro: 'Erro interno no servidor' });
  }
});

export default routes;