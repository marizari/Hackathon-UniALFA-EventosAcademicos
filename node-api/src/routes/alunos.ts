import { Router } from 'express'
import knex from './../database/knex/index'
import { z } from 'zod'

const routes = Router();

routes.get('/', async (req, res) => {
  try {
    const alunos = await knex('alunos').select('*');
    res.json(alunos);
  } catch (error) {
    res.status(500).json({ mensagem: 'Erro ao buscar alunos' });
  }
});


routes.post('/', async (req, res) => {
  const registerBodySchema = z.object({
    nome: z.string(),
    email: z.string().email(),
    senha: z.string(),
    ra: z.string().min(2),
    evento_id: z.number() 
  });

  try {
    const { nome, email, senha, ra, evento_id } = registerBodySchema.parse(req.body);

    // Aqui valida se o evento existe no banco
    const eventoExiste = await knex('eventos').where({ id: evento_id }).first();
    if (!eventoExiste) {
     res.status(400).json({ mensagem: 'Evento não encontrado' });
    }

    await knex('alunos').insert({ nome, email, senha, ra, evento_id });

    res.status(201).json({ mensagem: 'Aluno cadastrado com sucesso!' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ mensagem: 'Erro ao cadastrar aluno' });
  }
});

export default routes