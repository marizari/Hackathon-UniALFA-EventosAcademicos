const express = require('express');
const app = express();

app.use(express.json()); // para aceitar JSON no body

const alunosRouter = require('./routes/alunos');
app.use('/alunos', alunosRouter);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Servidor rodando na porta ${PORT}`));
