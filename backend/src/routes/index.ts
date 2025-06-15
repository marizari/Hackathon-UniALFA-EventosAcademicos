import { Router } from 'express';

import alunos from './alunos'
import eventos from './eventos'
import palestrantes from './palestrantes'

const routes = Router()

routes.use('/alunos', alunos);
routes.use('/eventos', eventos);
routes.use('/palestrantes', palestrantes);

export default routes