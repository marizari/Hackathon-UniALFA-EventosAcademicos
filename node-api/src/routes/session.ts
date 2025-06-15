import Router from 'express'
import knex from '../database/knex'
import { z } from 'zod'
import { hash, compare } from 'bcryptjs'
import { sign } from 'jsonwebtoken'
import alunos from './alunos'

const router = Router();

router.post('/', async (req, res) => {
    const registerBodySchema = z.object({
        name: z.string(),
        email: z.string().email(),
        ra: z.number().min(2),
        password: z.string().min(6),
        evento_id: z.number()
    });

    try {
        const { name, email, ra, password, evento_id } = registerBodySchema.parse(req.body);

        const eventoExiste = await knex('eventos').where({ id: evento_id }).first();
        if (!eventoExiste) {
            res.status(400).json({ mensagem: 'Esse evento não foi encontrado' });
        }

        const senhaCriptografada = await hash(password, 10);

        await knex('alunos').insert({ name, email, ra, password: senhaCriptografada, evento_id });

        res.status(201).json({ mensagem: 'Aluno cadastrado com sucesso!' });
    } catch (error) {
        console.error(error);
        res.status(500).json({ mensagem: 'Erro ao cadastrar aluno' });
    }
});

export default router