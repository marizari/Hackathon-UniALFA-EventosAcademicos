import { Router } from 'express';

import alunos from './alunos'
import eventos from './eventos'
import palestrantes from './palestrantes'
import session from './session';
import autenticacao from '../../middlewares/autenticacao';

const routes = Router()

routes.use('/alunos', autenticacao, alunos);
routes.use('/eventos', eventos);
routes.use('/session', session)
routes.use('/palestrantes', palestrantes);
routes.use(autenticacao)

export default routes