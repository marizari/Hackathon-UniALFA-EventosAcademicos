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

routes.get('/eventos-com-alunos', async (req, res) => {
  try {

    const eventos = await knex('eventos').select('*');

    
    const alunos = await knex('alunos')
      .select('name', 'ra', 'evento_id');

    
    const eventosComAlunos = eventos.map(evento => {
      return {
        ...evento,
        alunos: alunos.filter(aluno => aluno.evento_id === evento.id)
      };
    });

    res.json(eventosComAlunos);

  } catch (error) {
    console.error(error);
    res.status(500).json({ mensagem: 'Erro ao buscar eventos com alunos' });
  }
});



routes.post('/', async (req, res) => {
  const registerBodySchema = z.object({
    name: z.string(),
    email: z.string().email(),
    ra: z.number().min(2),
    evento_id: z.number() 
  });

  try {
    const { name, email, ra, evento_id } = registerBodySchema.parse(req.body);

    
    const eventoExiste = await knex('eventos').where({ id: evento_id }).first();
    if (!eventoExiste) {
     res.status(400).json({ mensagem: 'Evento não encontrado' });
    }

    await knex('alunos').insert({ name, email, ra, evento_id });

    res.status(201).json({ mensagem: 'Aluno cadastrado com sucesso!' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ mensagem: 'Erro ao cadastrar aluno' });
  }
});

export default routes
